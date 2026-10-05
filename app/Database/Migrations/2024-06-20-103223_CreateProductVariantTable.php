<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductVariantTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'variant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'unit_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'variant_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'size_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'variant_sku_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],

            'color_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'minimum_stock' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'variant_weight' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => '0.00',
            ],
            'mrp' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => '0.00',
            ],
            'purchase_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => '0.00',
            ],
            'cost_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => '0.00',
            ],
            'profit_per' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => '0.00',
            ],
            'profit_amt' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => '0.00',
            ],
            'discount_per' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => '0.00',
            ],
            'discount_amt' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => '0.00',
            ],
            'gst_per' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => '0.00',
            ],
            'gst_amt' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => '0.00',
            ],
            'selling_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => '0.00',
            ],
            'delivery_charge' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => '0.00',
            ],
            'variant_description' => [
                'type' => 'TEXT',
            ],
            'variant_seo_keyword' => [
                'type' => 'TEXT',
            ],
            'variant_seo_description' => [
                'type' => 'TEXT',
            ],
            'product_variant_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'variant_alt_text1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'variant_alt_text2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'variant_alt_text3' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'variant_alt_text4' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'variant_alt_text5' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'variant_alt_text6' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'variant_image1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'variant_image2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'variant_image3' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'variant_image4' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'variant_image5' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'variant_image6' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('variant_id');
        $this->forge->addForeignKey('product_id', 'product', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('unit_id', 'unit', 'unit_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('size_id', 'size', 'size_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('color_id', 'color', 'color_id', 'RESTRICT', 'RESTRICT');
        
        $this->forge->createTable('product_variant', true);

        $this->forge->addColumn('product', [
            "variant_id" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null" => true
            ]
        ]);
        $this->forge->addForeignKey('variant_id', 'product_variant', 'variant_id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->forge->createTable('product_variant', true);
    }
}
