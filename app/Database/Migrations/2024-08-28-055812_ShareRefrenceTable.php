<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ShareRefrenceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'share_reference_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
                'auto_increment' => true,
            ],
            'share_by_customer_id' => [
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
            'source' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('share_reference_id', true);

        // Adding foreign key constraints
        $this->forge->addForeignKey('share_by_customer_id', 'customer', 'customer_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'product', 'product_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('share_reference');
    }

    public function down()
    {
        $this->forge->dropTable('share_reference');
    }
}
