<?php

namespace Modules\Users\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * List all users
     */
    public function index()
    {
        $users = $this->userModel->findAll();
        
        // Get groups for each user
        $usersData = [];
        foreach ($users as $user) {
            $usersData[] = [
                'id' => $user->id,
                'username' => $user->username,
                'active' => $user->active,
                'last_active' => $user->last_active,
                'groups' => $user->getGroups()
            ];
        }

        $data = [
            'title' => 'User Management',
            'users' => $usersData
        ];

        return view('Modules\Users\Views\index', $data);
    }

    /**
     * Show edit user form
     */
    public function edit($id)
    {
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            return redirect()->to('/users')->with('error', 'User not found');
        }

        $authGroups = config('AuthGroups');
        
        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'availableGroups' => $authGroups->groups,
            'userGroups' => $user->getGroups()
        ];

        return view('Modules\Users\Views\edit', $data);
    }

    /**
     * Update user groups
     */
    public function update($id)
    {
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            return redirect()->to('/users')->with('error', 'User not found');
        }

        $groups = $this->request->getPost('groups') ?? [];
        
        // Remove all current groups
        foreach ($user->getGroups() as $group) {
            $user->removeGroup($group);
        }
        
        // Add selected groups
        foreach ($groups as $group) {
            $user->addGroup($group);
        }

        return redirect()->to('/users')->with('success', 'User roles updated successfully');
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus($id)
    {
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            return redirect()->to('/users')->with('error', 'User not found');
        }

        if ($user->active) {
            $user->deactivate();
            $message = 'User deactivated successfully';
        } else {
            $user->activate();
            $message = 'User activated successfully';
        }

        return redirect()->to('/users')->with('success', $message);
    }
}
