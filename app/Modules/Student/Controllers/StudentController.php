<?php

namespace Modules\Student\Controllers;

use App\Controllers\BaseController;
use Modules\Student\Models\StudentModel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class StudentController extends BaseController
{
    protected $studentModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Student Management',
            'students' => $this->studentModel->getAllWithDetails(),
            'menuItems' => $this->loadModuleMenus(),
            'user' => auth()->user()
        ];

        return view('Modules\Student\Views\index', $data);
    }

    public function show($id)
    {
        $student = $this->studentModel->getStudentWithDetails($id);

        if (!$student) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found');
        }

        $data = [
            'title' => 'Student Details - ' . $student['full_name'],
            'student' => $student,
            'menuItems' => $this->loadModuleMenus(),
            'user' => auth()->user()
        ];

        return view('Modules\Student\Views\view', $data);
    }

    public function edit($id)
    {
        $student = $this->studentModel->find($id);

        if (!$student) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found');
        }

        // Get profile details for name
        $profileModel = new \Modules\Account\Models\ProfileModel();
        $profile = $profileModel->find($student['profile_id']);

        $data = [
            'title' => 'Edit Student - ' . ($profile['full_name'] ?? 'Unknown'),
            'student' => $student,
            'profile' => $profile,
            'menuItems' => $this->loadModuleMenus(),
            'user' => auth()->user()
        ];

        return view('Modules\Student\Views\edit', $data);
    }

    public function update($id)
    {
        $student = $this->studentModel->find($id);

        if (!$student) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found');
        }

        $data = [
            'status' => $this->request->getPost('status'),
            'gpa' => $this->request->getPost('gpa') ?: null,
            'total_credits' => $this->request->getPost('total_credits') ?: null,
            'graduation_date' => $this->request->getPost('graduation_date') ?: null,
            'graduation_gpa' => $this->request->getPost('graduation_gpa') ?: null,
        ];

        if ($this->studentModel->update($id, $data)) {
            return redirect()->to('/student')->with('success', 'Student updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update student: ' . implode(', ', $this->studentModel->errors()));
        }
    }

    public function promoteForm()
    {
        // Get all APPROVED admissions not yet promoted (no user/login account)
        // Also get citizen_id and phone for account creation
        $db = \Config\Database::connect();

        $admissions = $db->table('admissions a')
            ->select('a.*, p.full_name, p.email, p.phone, p.citizen_id, prog.title as program_title')
            ->join('profiles p', 'p.id = a.profile_id', 'left')
            ->join('programs prog', 'prog.id = a.program_id', 'left')
            ->where('a.status', 'approved')
            ->where('p.user_id IS NULL')
            ->orderBy('a.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Batch Promote Students',
            'admissions' => $admissions,
            'menuItems' => $this->loadModuleMenus(),
            'user' => auth()->user()
        ];

        return view('Modules\Student\Views\promote_form', $data);
    }

    /**
     * Process batch promotion of admissions to students
     */
    public function doPromote()
    {
        $admissionIds = $this->request->getPost('admission_ids');

        if (empty($admissionIds) || !is_array($admissionIds)) {
            return redirect()->back()->with('error', 'Please select at least one admission to promote.');
        }

        $db = \Config\Database::connect();
        $admissionModel = new \Modules\Admission\Models\AdmissionModel();

        $results = [
            'total_selected' => count($admissionIds),
            'promoted' => 0,
            'failed' => 0,
            'skipped' => 0
        ];

        $createdAccounts = [];
        $errors = [];

        foreach ($admissionIds as $admissionId) {
            $admission = $admissionModel->getWithDetails($admissionId);

            if (!$admission) {
                $results['failed']++;
                $errors[] = "Admission ID {$admissionId}: Not found";
                continue;
            }

            if ($admission['status'] !== 'approved') {
                $results['skipped']++;
                $errors[] = "{$admission['full_name']}: Not approved";
                continue;
            }

            // Validate required fields
            if (empty($admission['citizen_id'])) {
                $results['skipped']++;
                $errors[] = "{$admission['full_name']}: Missing Citizen ID";
                continue;
            }

            if (empty($admission['phone'])) {
                $results['skipped']++;
                $errors[] = "{$admission['full_name']}: Missing Phone";
                continue;
            }

            $db->transBegin();

            try {
                // 1. Create User using Shield's User entity
                // Auto-generate username from citizen_id and password from phone
                $username = $admission['citizen_id'];
                $password = $admission['phone'];

                $userProvider = auth()->getProvider();

                // Check if username already exists
                $existingUser = $userProvider->where('username', $username)->first();
                if ($existingUser) {
                    throw new \Exception('Username already exists');
                }

                $userEntity = new User([
                    'username' => $username,
                    'email'    => $admission['email'],
                    'password' => $password,
                ]);

                if (!$userProvider->save($userEntity)) {
                    throw new \Exception('Failed to create user account');
                }

                $userId = $userProvider->getInsertID();
                $user = $userProvider->findById($userId);

                if (!$user) {
                    throw new \Exception('Failed to retrieve created user');
                }

                // Activate and add to student group
                $user->activate();
                $user->addGroup('student');

                if (!$userProvider->save($user)) {
                    throw new \Exception('Failed to activate user and add group');
                }

                // 2. Update Profile with User ID
                if (!$db->table('profiles')
                    ->where('id', $admission['profile_id'])
                    ->update(['user_id' => $userId])) {
                    throw new \Exception('Failed to update profile');
                }

                // 3. Create Student Record
                $studentNumber = 'STU-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

                if (!$db->table('students')->insert([
                    'student_number' => $studentNumber,
                    'profile_id' => $admission['profile_id'],
                    'admission_id' => $admissionId,
                    'enrollment_date' => date('Y-m-d'),
                    'status' => 'active',
                    'program_id' => $admission['program_id'],
                    'batch' => date('Y'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'deleted_at' => null
                ])) {
                    throw new \Exception('Failed to create student record');
                }

                $db->transCommit();

                $results['promoted']++;
                $createdAccounts[] = [
                    'name' => $admission['full_name'],
                    'username' => $username,
                    'password' => $password
                ];

            } catch (\Exception $e) {
                $db->transRollback();
                $results['failed']++;
                $errors[] = "{$admission['full_name']}: " . $e->getMessage();
                log_message('error', 'Promotion error for admission ' . $admissionId . ': ' . $e->getMessage());
            }
        }

        // Prepare flash messages
        $message = "Batch promotion completed: {$results['promoted']} promoted, {$results['failed']} failed, {$results['skipped']} skipped.";

        return redirect()->to('/student/promote')
            ->with('success', $message)
            ->with('results', $results)
            ->with('created_accounts', $createdAccounts)
            ->with('promotion_errors', $errors);
    }
}
