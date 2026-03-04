<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogTables extends Migration
{
    public function up()
    {
        // ==========================================
        // BLOG POSTS TABLE
        // ==========================================
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'unique' => true,
            ],
            'content' => [
                'type' => 'LONGTEXT',
                'null' => false,
            ],
            'excerpt' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'featured_image' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'author_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'meta_title' => [
                'type' => 'VARCHAR',
                'constraint' => 70,
                'null' => true,
            ],
            'meta_description' => [
                'type' => 'VARCHAR',
                'constraint' => 160,
                'null' => true,
            ],
            'meta_keywords' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'reading_time' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'view_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'is_published' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'is_featured' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'ai_summary' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ai_keywords' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'published_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('author_id');
        $this->forge->addKey('category_id');
        $this->forge->addKey('is_published');
        $this->forge->addKey('is_featured');
        $this->forge->addKey('published_at');
        
        $this->forge->createTable('blog_posts', true);

        // ==========================================
        // BLOG CATEGORIES TABLE
        // ==========================================
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'unique' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'parent_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'display_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('parent_id');
        $this->forge->addKey('is_active');
        $this->forge->addKey('display_order');
        
        $this->forge->createTable('blog_categories', true);

        // ==========================================
        // BLOG TAGS TABLE
        // ==========================================
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'unique' => true,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'unique' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        
        $this->forge->createTable('blog_tags', true);

        // ==========================================
        // BLOG POST TAGS PIVOT TABLE
        // ==========================================
        $this->forge->addField([
            'post_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'tag_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        $this->forge->addKey('post_id');
        $this->forge->addKey('tag_id');
        $this->forge->addPrimaryKey(['post_id', 'tag_id']);
        
        $this->forge->createTable('blog_post_tags', true);

        // Add foreign keys (with IF NOT EXISTS to handle partial migrations)
        $this->db->query('ALTER TABLE blog_posts ADD CONSTRAINT blog_fk_posts_author FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE blog_posts ADD CONSTRAINT blog_fk_posts_category FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL');
        $this->db->query('ALTER TABLE blog_categories ADD CONSTRAINT blog_fk_categories_parent FOREIGN KEY (parent_id) REFERENCES blog_categories(id) ON DELETE SET NULL');
        $this->db->query('ALTER TABLE blog_post_tags ADD CONSTRAINT blog_fk_post_tags_post FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE blog_post_tags ADD CONSTRAINT blog_fk_post_tags_tag FOREIGN KEY (tag_id) REFERENCES blog_tags(id) ON DELETE CASCADE');

        // ==========================================
        // BLOG SETTINGS TABLE
        // ==========================================
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'setting_key' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'unique' => true,
            ],
            'setting_value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        
        $this->forge->createTable('blog_settings', true);

        // Insert default settings
        $this->db->table('blog_settings')->insertBatch([
            [
                'setting_key' => 'posts_per_page',
                'setting_value' => '12',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'blog_name',
                'setting_value' => 'Education Blog',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'blog_description',
                'setting_value' => 'Learn with our educational articles and tutorials',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function down()
    {
        // Drop foreign keys first
        $this->db->query('ALTER TABLE blog_posts DROP FOREIGN KEY blog_fk_posts_author');
        $this->db->query('ALTER TABLE blog_posts DROP FOREIGN KEY blog_fk_posts_category');
        $this->db->query('ALTER TABLE blog_categories DROP FOREIGN KEY blog_fk_categories_parent');
        $this->db->query('ALTER TABLE blog_post_tags DROP FOREIGN KEY blog_fk_post_tags_post');
        $this->db->query('ALTER TABLE blog_post_tags DROP FOREIGN KEY blog_fk_post_tags_tag');

        // Drop tables
        $this->forge->dropTable('blog_post_tags', true);
        $this->forge->dropTable('blog_tags', true);
        $this->forge->dropTable('blog_categories', true);
        $this->forge->dropTable('blog_posts', true);
        $this->forge->dropTable('blog_settings', true);
    }
}
