<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixPageviewVisitorsTable extends Migration
{
    public function up()
    {
        // Drop the unique key that was causing issues
        $this->db->query('ALTER TABLE pageview_visitors DROP INDEX page_url_visitor_ip');
    }

    public function down()
    {
        // Restore unique key (though it will have the same issue)
        $this->db->query('ALTER TABLE pageview_visitors ADD UNIQUE INDEX page_url_visitor_ip (page_url, visitor_ip)');
    }
}
