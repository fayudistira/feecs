<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddModeCurriculumToPrograms extends Migration
{
    public function up()
    {
        $fields = [
            'mode' => [
                'type' => 'ENUM',
                'constraint' => ['online', 'offline'],
                'default' => 'offline',
                'null' => false,
                'after' => 'status'
            ],
            'curriculum' => [
                'type' => 'JSON',
                'null' => true,
                'after' => 'mode'
            ]
        ];
        
        $this->forge->addColumn('programs', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('programs', ['mode', 'curriculum']);
    }
}
