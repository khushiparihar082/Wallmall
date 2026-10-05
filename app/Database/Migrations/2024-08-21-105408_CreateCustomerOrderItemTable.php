<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerOrderItemTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_item_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'customer_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null' => false
            ],
            'order_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null' => false
            ],
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null' => false
            ],
            'variant_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null' => false
            ],
            'size_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'color_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'purches_rate' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'mrp' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'order_qty' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'final_rate' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'final_discount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'coupan_dis_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'shipping_charges_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'item_total_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'gst_per' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0.00,
            ],
            'taxable_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'default' => 0.00,
            ],
            'gst_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'default' => 0.00,
            ],
            'return_qty' => [
                'type'       => 'INT',
                'constraint' => 11,  // Added constraint for better control
                'null'       => true,
            ],
            'exchange_qty' => [
                'type'       => 'INT',
                'constraint' => 255,
                'null'       => false,  // Ensuring this field is not nullable
            ],
            'refund_amount' => [
                'type'       => 'INT',
                'constraint' => 255,
                'null'       => false,  // Ensuring this field is not nullable
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('order_item_id', true);
        $this->forge->addForeignKey('customer_id', 'customer', 'customer_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('order_id', 'order', 'order_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'product', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('variant_id', 'product_variant', 'variant_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('order_item');
    }

    public function down()
    {
        $this->forge->dropTable('order_item');
    }
}
