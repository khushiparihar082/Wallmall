<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'category_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'category_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'category_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'NULL' => true,
            ],
            'category_type_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'category_seo_description' => [
                'type' => 'TEXT',
                'NULL' => true,
            ],
            'category_description' => [
                'type' => 'TEXT',
                'NULL' => true
            ],
            'category_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'category_alt_text' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'category_image' => [
                'type' => 'VARCHAR', 
                'constraint' => 255, 
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('category_id');
        $this->forge->addForeignKey('category_type_id', 'category_type', 'category_type_id','CASCADE','CASCADE');
        $this->forge->createTable('category',true);
    }

    public function down()
    {
        $this->forge->dropTable('category',true);
    }
}
