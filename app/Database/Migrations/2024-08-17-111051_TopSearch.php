<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TopSearch extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'top_search_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
                'auto_increment' => true,
            ],
            'customer_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
                'null' => true
            ],
            'product_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
                'null' => false
            ],
            'customer_search_count' => [
                'type' => 'INT',
                'default' => 1,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('top_search_id', true);

        // Adding foreign key constraints
        $this->forge->addForeignKey('customer_id', 'customer', 'customer_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'product', 'product_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('top_search');
    }

    public function down()
    {
        $this->forge->dropTable('top_search');
    }
}
