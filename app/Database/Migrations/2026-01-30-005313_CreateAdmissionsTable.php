<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdmissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'registration_number' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'nickname' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['Male', 'Female'],
            ],
            'place_of_birth' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'date_of_birth' => [
                'type' => 'DATE',
            ],
            'religion' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'citizen_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'street_address' => [
                'type' => 'TEXT',
            ],
            'district' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'regency' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'emergency_contact_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'emergency_contact_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
            'emergency_contact_relation' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'father_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'mother_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'course' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default' => 'pending',
            ],
            'application_date' => [
                'type' => 'DATE',
            ],
            'photo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'documents' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'JSON array of document filenames',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addUniqueKey('registration_number');
        $this->forge->addUniqueKey('email');
        $this->forge->addKey('status');
        $this->forge->addKey('deleted_at');
        $this->forge->createTable('admissions');
    }

    public function down()
    {
        $this->forge->dropTable('admissions');
    }
}
