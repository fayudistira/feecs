<?php

namespace Modules\Settings\Controllers;

use App\Controllers\BaseController;
use App\Models\TermsConditionModel;

class TermsController extends BaseController
{
    protected $termsModel;

    public function __construct()
    {
        $this->termsModel = new TermsConditionModel();
    }

    /**
     * List all terms and conditions
     */
    public function index()
    {
        $data = [
            'title' => 'Terms & Conditions',
            'menuItems' => $this->loadModuleMenus(),
            'user' => auth()->user(),
            'terms' => $this->termsModel->getAllTerms(),
            'availableLanguages' => TermsConditionModel::getAvailableProgramLanguages(),
        ];

        return view('Modules\Settings\Views\terms\index', $data);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $data = [
            'title' => 'Create Terms',
            'menuItems' => $this->loadModuleMenus(),
            'user' => auth()->user(),
            'availableLanguages' => TermsConditionModel::getAvailableProgramLanguages(),
            'existingLanguages' => array_column($this->termsModel->getAvailableLanguages(), 'language'),
        ];

        return view('Modules\Settings\Views\terms\create', $data);
    }

    /**
     * Store new terms
     */
    public function store()
    {
        $validation = $this->validate([
            'language' => 'required|max_length[100]|is_unique[terms_conditions.language]',
            'title'    => 'required|max_length[255]',
            'content'  => 'required',
            'is_active' => 'permit_empty|in_list[0,1]',
        ]);

        if (!$validation) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'language'  => $this->request->getPost('language'),
            'title'     => $this->request->getPost('title'),
            'content'   => $this->request->getPost('content'),
            'is_active' => $this->request->getPost('is_active') ?? 1,
        ];

        $this->termsModel->insert($data);

        return redirect()->to('settings/terms')
            ->with('success', 'Terms & Conditions created successfully!');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $term = $this->termsModel->find($id);

        if (!$term) {
            return redirect()->to('settings/terms')
                ->with('error', 'Terms & Conditions not found!');
        }

        $data = [
            'title' => 'Edit Terms',
            'menuItems' => $this->loadModuleMenus(),
            'user' => auth()->user(),
            'term' => $term,
            'availableLanguages' => TermsConditionModel::getAvailableProgramLanguages(),
        ];

        return view('Modules\Settings\Views\terms\edit', $data);
    }

    /**
     * Update existing terms
     */
    public function update($id)
    {
        $term = $this->termsModel->find($id);

        if (!$term) {
            return redirect()->to('settings/terms')
                ->with('error', 'Terms & Conditions not found!');
        }

        $language = $this->request->getPost('language');
        
        // Check if language is being changed and if it already exists
        $isUnique = $language === $term['language'] ? '' : '|is_unique[terms_conditions.language]';

        $validation = $this->validate([
            'language' => "required|max_length[100]{$isUnique}",
            'title'    => 'required|max_length[255]',
            'content'  => 'required',
            'is_active' => 'permit_empty|in_list[0,1]',
        ]);

        if (!$validation) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'language'  => $language,
            'title'     => $this->request->getPost('title'),
            'content'   => $this->request->getPost('content'),
            'is_active' => $this->request->getPost('is_active') ?? 1,
        ];

        $this->termsModel->update($id, $data);

        return redirect()->to('settings/terms')
            ->with('success', 'Terms & Conditions updated successfully!');
    }

    /**
     * Delete terms
     */
    public function delete($id)
    {
        $term = $this->termsModel->find($id);

        if (!$term) {
            return redirect()->to('settings/terms')
                ->with('error', 'Terms & Conditions not found!');
        }

        $this->termsModel->delete($id);

        return redirect()->to('settings/terms')
            ->with('success', 'Terms & Conditions deleted successfully!');
    }

    /**
     * Toggle active status
     */
    public function toggle($id)
    {
        $term = $this->termsModel->find($id);

        if (!$term) {
            return redirect()->to('settings/terms')
                ->with('error', 'Terms & Conditions not found!');
        }

        $this->termsModel->update($id, [
            'is_active' => $term['is_active'] ? 0 : 1
        ]);

        $status = $term['is_active'] ? 'deactivated' : 'activated';
        
        return redirect()->to('settings/terms')
            ->with('success', "Terms & Conditions {$status} successfully!");
    }

    /**
     * API: Get all active terms
     */
    public function apiIndex()
    {
        $terms = $this->termsModel->getAllActive();
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $terms
        ]);
    }

    /**
     * API: Get terms by language
     */
    public function apiShow($language)
    {
        $term = $this->termsModel->getActiveByLanguage($language);
        
        if (!$term) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terms and conditions not found for this language'
            ])->setStatusCode(404);
        }
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $term
        ]);
    }
}
