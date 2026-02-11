<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDurationToProgramsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('programs', [
            'duration' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'sub_category'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('programs', 'duration');
    }
}
