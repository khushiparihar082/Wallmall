<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerWishlistTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customer_wishlist_id' => [
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
          
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('customer_wishlist_id', true);

        // Adding foreign key constraints
        $this->forge->addForeignKey('customer_id', 'customer', 'customer_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'product', 'product_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('customer_wishlist');
    }

    public function down()
    {
        $this->forge->dropTable('customer_wishlist');
    }
}
