<?php

namespace Modules\Test\Controllers;

use App\Controllers\BaseController;
use Modules\Test\Models\TestRegistrationModel;

class TestController extends BaseController
{
    protected $registrationModel;

    public function __construct()
    {
        $this->registrationModel = new TestRegistrationModel();
    }

    /**
     * Display all HSK test registrations
     * 
     * @return string
     */
    public function hskRegistrations(): string
    {
        $user = auth()->user();
        
        if (!$user->can('test.view')) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Get filter parameters
        $status = $this->request->getGet('status');
        $level = $this->request->getGet('level');
        $search = $this->request->getGet('search');

        // Get pagination
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        // Build conditions array
        $conditions = [];
        if ($status) {
            $conditions['status'] = $status;
        }
        if ($level) {
            $conditions['hsk_level'] = $level;
        }
        
        // Get total count with filters
        $totalBuilder = $this->registrationModel->builder();
        if ($status) {
            $totalBuilder->where('status', $status);
        }
        if ($level) {
            $totalBuilder->where('hsk_level', $level);
        }
        if ($search) {
            $totalBuilder->groupStart()
                ->like('full_name', $search)
                ->orLike('email', $search)
                ->orLike('phone', $search)
                ->groupEnd();
        }
        $total = $totalBuilder->countAllResults();
        
        // Get paginated results - use fresh model instance
        $db = \Config\Database::connect();
        $builder = $db->table('test_registrations');
        
        if ($status) {
            $builder->where('status', $status);
        }
        if ($level) {
            $builder->where('hsk_level', $level);
        }
        if ($search) {
            $builder->groupStart()
                ->like('full_name', $search)
                ->orLike('email', $search)
                ->orLike('phone', $search)
                ->groupEnd();
        }
        
        $registrations = $builder->orderBy('created_at', 'DESC')
                                  ->limit($perPage, $offset)
                                  ->get()
                                  ->getResultArray();

        // Create simple pager
        $pager = service('pager');
        $pager->makeLinks($page, $perPage, $total);

        // Get statistics - use fresh query
        $dbStats = \Config\Database::connect();
        $stats = [
            'total' => $dbStats->table('test_registrations')->countAll(),
            'pending' => $dbStats->table('test_registrations')->where('status', 'pending')->countAllResults(),
            'contacted' => $dbStats->table('test_registrations')->where('status', 'contacted')->countAllResults(),
            'confirmed' => $dbStats->table('test_registrations')->where('status', 'confirmed')->countAllResults(),
            'cancelled' => $dbStats->table('test_registrations')->where('status', 'cancelled')->countAllResults(),
        ];

        // Get unique levels for filter
        $db3 = \Config\Database::connect();
        $levelResults = $db3->table('test_registrations')
                           ->select('hsk_level')
                           ->distinct()
                           ->get()
                           ->getResultArray();
        $levelOptions = array_column($levelResults, 'hsk_level');

        return view('Modules\Test\Views\index', [
            'title' => 'HSK Test Registrations',
            'registrations' => $registrations,
            'pager' => $pager,
            'stats' => $stats,
            'levelOptions' => $levelOptions,
            'filters' => [
                'status' => $status,
                'level' => $level,
                'search' => $search,
            ],
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
        ]);
    }

    /**
     * View single registration detail
     * 
     * @param int $id
     * @return string
     */
    public function viewHskRegistration(int $id): string
    {
        $user = auth()->user();
        
        if (!$user->can('test.view')) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $registration = $this->registrationModel->find($id);

        if (!$registration) {
            return redirect()->to('/test/hsk-registrations')
                           ->with('error', 'Registrasi tidak ditemukan.');
        }

        return view('Modules\Test\Views\view', [
            'title' => 'Detail Registrasi HSK',
            'registration' => $registration,
        ]);
    }

    /**
     * Update registration status
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function updateHskStatus(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $user = auth()->user();
        
        if (!$user->can('test.manage')) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses untuk melakukan tindakan ini.');
        }

        $registration = $this->registrationModel->find($id);

        if (!$registration) {
            return redirect()->to('/test/hsk-registrations')
                           ->with('error', 'Registrasi tidak ditemukan.');
        }

        $status = $this->request->getPost('status');
        
        if (!in_array($status, ['pending', 'contacted', 'confirmed', 'cancelled'])) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $this->registrationModel->update($id, ['status' => $status]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    /**
     * Delete registration
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function deleteHskRegistration(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $user = auth()->user();
        
        if (!$user->can('test.delete')) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses untuk melakukan tindakan ini.');
        }

        $registration = $this->registrationModel->find($id);

        if (!$registration) {
            return redirect()->to('/test/hsk-registrations')
                           ->with('error', 'Registrasi tidak ditemukan.');
        }

        $this->registrationModel->delete($id);

        return redirect()->to('/test/hsk-registrations')
                       ->with('success', 'Registrasi berhasil dihapus.');
    }
}
