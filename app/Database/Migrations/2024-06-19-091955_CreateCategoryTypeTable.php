<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoryTypeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'category_type_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'category_type_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'category_type_description' => [
                'type' => 'TEXT',
                'NULL' => true
            ],
            'category_type_seo_description' => [
                'type' => 'TEXT',
                'NULL' => true,
            ],
            'category_type_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'NULL' => true,
            ],
            'category_type_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'category_type_alt_text' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'category_type_image' => [
                'type' => 'VARCHAR', 
                'constraint' => 255, 
            ],
            'category_type_icon' => [
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
        $this->forge->addPrimaryKey('category_type_id');
        $this->forge->addUniqueKey('category_type_name');
        $this->forge->createTable('category_type',true);
    }

    public function down()
    {
        $this->forge->dropTable('category_type',true);
    }
}
