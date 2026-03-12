<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUniqueVisitorsToPageviews extends Migration
{
    public function up()
    {
        // Add unique visitor tracking column
        $this->db->query('ALTER TABLE pageviews ADD COLUMN unique_visitor_count INT(11) DEFAULT 0 AFTER view_count');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE pageviews DROP COLUMN unique_visitor_count');
    }
}
