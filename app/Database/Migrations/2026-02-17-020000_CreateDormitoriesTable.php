<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDormitoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
            ],
            'room_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'location' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
            ],
            'map_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'room_capacity' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
            ],
            'facilities' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'gallery' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['available', 'full', 'maintenance', 'inactive'],
                'default'    => 'available',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('dormitories');
    }

    public function down()
    {
        $this->forge->dropTable('dormitories');
    }
}
