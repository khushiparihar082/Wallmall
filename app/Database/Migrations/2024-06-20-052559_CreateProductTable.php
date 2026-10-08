<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'product_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'product_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'product_hsn_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'category_type_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'brand_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'height' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true, // adjust as per your requirement
            ],
            'width' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true, // adjust as per your requirement
            ],
            'length' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '0.00',
            ],
            'product_description' => [
                'type' => 'TEXT',
            ],
            'product_seo_title' => [
                'type' => 'TEXT',
            ],
            'product_seo_description' => [
                'type' => 'TEXT',
            ],
            'product_keyfeature' => [
                'type' => 'TEXT',
            ],
            'product_specialcare' => [
                'type' => 'TEXT',
            ],
            'product_refund_exchange' => [
                'type' => 'TEXT',
            ],
            'default_variant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'product_alt_text1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'product_alt_text2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'product_alt_text3' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'product_image1' => [
                'type' => 'VARCHAR', 
                'constraint' => 255, 
            ],
            'product_image2' => [
                'type' => 'VARCHAR', 
                'constraint' => 255, 
            ],
            'product_image3' => [
                'type' => 'VARCHAR', 
                'constraint' => 255, 
            ],
            'is_recommended' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'is_returnable' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'is_exchangeable' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'is_sponsore' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'spotlight_image' => [
                'type' => 'VARCHAR', 
                'constraint' => 255, 
            ],
            'fluencer_video' => [
                'type' => 'VARCHAR', 
                'constraint' => 255, 
            ],
             'is_fluencer' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true,
            ],
             'is_spotlight' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true,
            ],
            'spotlight_alt_text' => [
                'type' => 'VARCHAR', 
                'constraint' => 255, 
            ],
            'fluencer_alt_text' => [
                'type' => 'VARCHAR', 
                'constraint' => 255, 
            ],
            'spotlight_product_title' => [
                'type' => 'VARCHAR', 
                'constraint' => 255, 
            ],
            'spotlight_product_description' => [
                'type' => 'VARCHAR', 
                'constraint' => 255, 
            ],
            'view_count' => [
                'type' => 'VARCHAR', 
                'constraint' => 255, 
            ],
            'product_return_exchange_days' => [
                'type' => 'VARCHAR', 
                'constraint' => 255, 
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('product_id');
        $this->forge->addForeignKey('category_type_id', 'category_type', 'category_type_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('category_id', 'category', 'category_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('brand_id', 'brand', 'brand_id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('product', true);
    }

    public function down()
    {
        $this->forge->createTable('product', true);
    }
}
