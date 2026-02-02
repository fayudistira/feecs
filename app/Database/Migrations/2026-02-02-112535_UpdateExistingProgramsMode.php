<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateExistingProgramsMode extends Migration
{
    public function up()
    {
        // Update all existing programs to set mode = 'offline' where it's NULL or empty
        $this->db->query("UPDATE programs SET mode = 'offline' WHERE mode IS NULL OR mode = ''");
    }

    public function down()
    {
        // No rollback needed - this is a data migration
    }
}
