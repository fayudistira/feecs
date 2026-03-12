<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIpLocationToPageviews extends Migration
{
    public function up()
    {
        // Add columns to existing pageviews table
        $this->db->query('ALTER TABLE pageviews ADD COLUMN visitor_ip VARCHAR(45) NULL AFTER view_count');
        $this->db->query('ALTER TABLE pageviews ADD COLUMN visitor_country VARCHAR(100) NULL AFTER visitor_ip');
        $this->db->query('ALTER TABLE pageviews ADD COLUMN visitor_city VARCHAR(100) NULL AFTER visitor_country');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE pageviews DROP COLUMN visitor_ip');
        $this->db->query('ALTER TABLE pageviews DROP COLUMN visitor_country');
        $this->db->query('ALTER TABLE pageviews DROP COLUMN visitor_city');
    }
}
