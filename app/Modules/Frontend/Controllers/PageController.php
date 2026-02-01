<?php

namespace Modules\Frontend\Controllers;

use App\Controllers\BaseController;

class PageController extends BaseController
{
    protected $admissionModel;
    
    public function __construct()
    {
        // Will be loaded after Admission module is created
        // $this->admissionModel = new \Modules\Admission\Models\AdmissionModel();
    }
    
    public function home(): string
    {
        return view('Modules\Frontend\Views\home', [
            'title' => 'Home'
        ]);
    }
    
    public function about(): string
    {
        return view('Modules\Frontend\Views\about', [
            'title' => 'About Us'
        ]);
    }
    
    public function contact(): string
    {
        return view('Modules\Frontend\Views\contact', [
            'title' => 'Contact Us'
        ]);
    }
    
    public function apply(): string
    {
        return view('Modules\Frontend\Views\apply', [
            'title' => 'Apply for Admission'
        ]);
    }
    
    public function submitApplication()
    {
        // Load model (will work after Admission module is created)
        if (!isset($this->admissionModel)) {
            $this->admissionModel = new \Modules\Admission\Models\AdmissionModel();
        }
        
        // Validate input
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'gender' => 'required|in_list[Male,Female]',
            'place_of_birth' => 'required|min_length[3]|max_length[100]',
            'date_of_birth' => 'required|valid_date',
            'religion' => 'required|min_length[3]|max_length[50]',
            'phone' => 'required|regex_match[/^[0-9]{10,15}$/]',
            'email' => 'required|valid_email|is_unique[admissions.email]',
            'street_address' => 'required|min_length[5]',
            'district' => 'required|min_length[3]',
            'regency' => 'required|min_length[3]',
            'province' => 'required|min_length[3]',
            'emergency_contact_name' => 'required|min_length[3]|max_length[100]',
            'emergency_contact_phone' => 'required|regex_match[/^[0-9]{10,15}$/]',
            'emergency_contact_relation' => 'required|min_length[3]|max_length[50]',
            'father_name' => 'required|min_length[3]|max_length[100]',
            'mother_name' => 'required|min_length[3]|max_length[100]',
            'course' => 'required|min_length[3]',
            'photo' => 'uploaded[photo]|max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
            'documents.*' => 'max_size[documents,5120]|ext_in[documents,pdf,doc,docx]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        // Handle photo upload
        $photo = $this->request->getFile('photo');
        $photoName = null;
        
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $photoName = $photo->getRandomName();
            $photo->move(WRITEPATH . 'uploads/admissions/photos', $photoName);
        }
        
        // Handle documents upload
        $documents = $this->request->getFileMultiple('documents');
        $documentNames = [];
        
        if ($documents) {
            foreach ($documents as $doc) {
                if ($doc->isValid() && !$doc->hasMoved()) {
                    $docName = $doc->getRandomName();
                    $doc->move(WRITEPATH . 'uploads/admissions/documents', $docName);
                    $documentNames[] = $docName;
                }
            }
        }
        
        // Prepare data
        $data = [
            'registration_number' => $this->admissionModel->generateRegistrationNumber(),
            'full_name' => $this->request->getPost('full_name'),
            'nickname' => $this->request->getPost('nickname'),
            'gender' => $this->request->getPost('gender'),
            'place_of_birth' => $this->request->getPost('place_of_birth'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'religion' => $this->request->getPost('religion'),
            'citizen_id' => $this->request->getPost('citizen_id'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'street_address' => $this->request->getPost('street_address'),
            'district' => $this->request->getPost('district'),
            'regency' => $this->request->getPost('regency'),
            'province' => $this->request->getPost('province'),
            'postal_code' => $this->request->getPost('postal_code'),
            'emergency_contact_name' => $this->request->getPost('emergency_contact_name'),
            'emergency_contact_phone' => $this->request->getPost('emergency_contact_phone'),
            'emergency_contact_relation' => $this->request->getPost('emergency_contact_relation'),
            'father_name' => $this->request->getPost('father_name'),
            'mother_name' => $this->request->getPost('mother_name'),
            'course' => $this->request->getPost('course'),
            'notes' => $this->request->getPost('notes'),
            'photo' => $photoName,
            'documents' => !empty($documentNames) ? json_encode($documentNames) : null,
            'status' => 'pending',
            'application_date' => date('Y-m-d'),
        ];
        
        // Save application
        if (!$this->admissionModel->save($data)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to submit application. Please try again.');
        }
        
        // Get the registration number for confirmation
        $registrationNumber = $data['registration_number'];
        
        return redirect()->to('/apply/success')
            ->with('success', 'Your application has been submitted successfully!')
            ->with('registration_number', $registrationNumber);
    }
    
    public function applySuccess(): string
    {
        return view('Modules\Frontend\Views\apply_success', [
            'title' => 'Application Submitted'
        ]);
    }
}
