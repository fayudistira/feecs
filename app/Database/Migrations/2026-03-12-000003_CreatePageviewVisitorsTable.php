<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePageviewVisitorsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'page_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'visitor_ip' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
            ],
            'visited_at' => [
                'type' => 'DATETIME',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['page_url', 'visitor_ip'], false, true); // Unique key for page+ip combination
        $this->forge->createTable('pageview_visitors');
    }

    public function down()
    {
        $this->forge->dropTable('pageview_visitors');
    }
}
