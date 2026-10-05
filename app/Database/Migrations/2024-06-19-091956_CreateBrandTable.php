<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBrandTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'brand_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'brand_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'brand_description' => [
                'type' => 'TEXT',
                'NULL' => true
            ],
            'brand_seo_description' => [
                'type' => 'TEXT',
                'NULL' => true,
            ],
            'brand_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'NULL' => true,
            ],
            'brand_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'brand_alt_text' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'brand_image' => [
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
        $this->forge->addPrimaryKey('brand_id');
        $this->forge->addUniqueKey('brand_name');
        $this->forge->createTable('brand',true);
    }

    public function down()
    {
        $this->forge->dropTable('brand',true);
    }
}
