<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class AdminUsersSeeder extends Seeder
{
    public function run()
    {
        $users = auth()->getProvider();

        // 1. Create Frontline Admin
        $frontlineUser = new User([
            'username' => 'frontline',
            'email'    => 'frontline@example.com',
            'password' => 'frontline123',
        ]);
        $users->save($frontlineUser);
        
        // Activate and add to frontline group
        $frontlineUser = $users->findById($users->getInsertID());
        $frontlineUser->activate();
        $frontlineUser->addGroup('frontline');
        
        echo "✓ Frontline Admin created: frontline@example.com / frontline123\n";

        // 2. Create Finance Admin
        $financeUser = new User([
            'username' => 'finance',
            'email'    => 'finance@example.com',
            'password' => 'finance123',
        ]);
        $users->save($financeUser);
        
        // Activate and add to finance group
        $financeUser = $users->findById($users->getInsertID());
        $financeUser->activate();
        $financeUser->addGroup('finance');
        
        echo "✓ Finance Admin created: finance@example.com / finance123\n";

        // 3. Create Combined Admin (both roles)
        $combinedUser = new User([
            'username' => 'combined',
            'email'    => 'combined@example.com',
            'password' => 'combined123',
        ]);
        $users->save($combinedUser);
        
        // Activate and add to both groups
        $combinedUser = $users->findById($users->getInsertID());
        $combinedUser->activate();
        $combinedUser->addGroup('frontline');
        $combinedUser->addGroup('finance');
        
        echo "✓ Combined Admin created: combined@example.com / combined123 (Frontline + Finance)\n";

        echo "\n=== Admin Users Created Successfully ===\n";
        echo "Frontline Admin: frontline@example.com / frontline123\n";
        echo "Finance Admin:   finance@example.com / finance123\n";
        echo "Combined Admin:  combined@example.com / combined123\n";
    }
}
