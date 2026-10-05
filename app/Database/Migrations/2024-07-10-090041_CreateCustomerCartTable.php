<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerCartTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customer_cart_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
                'auto_increment' => true,
            ],
            'customer_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'product_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'variant_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'size_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
                'null' => true,

            ],
            'cart_quantity' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('customer_cart_id', true);

        // Adding foreign key constraints
        $this->forge->addForeignKey('customer_id', 'customer', 'customer_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'product', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('variant_id', 'product_variant', 'variant_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('size_id', 'size', 'size_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('customer_cart');
    }

    public function down()
    {
        $this->forge->dropTable('customer_cart');
    }
}
