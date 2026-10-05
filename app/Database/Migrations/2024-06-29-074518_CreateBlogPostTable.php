<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogPostTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'blog_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'blog_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'blog_short_content' => [
                'type' => 'TEXT',
            ],
            'blog_long_content' => [
                'type' => 'TEXT',
            ],
            // About Page
            'blog_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'blog_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'blog_seo_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'blog_featured_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'blog_alt_text' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'blog_status' => [
                'type' => 'ENUM',
                'constraint' => ['draft', 'published'],
                'default' => 'draft',
            ],
            'blog_views_count' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'blog_likes_count' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'blog_author_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'published_at datetime default current_timestamp',
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('blog_id');
        $this->forge->addForeignKey('user_id', 'user', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('blog', true);
    }

    public function down()
    {
        $this->forge->dropTable('blog', true);
    }
}
