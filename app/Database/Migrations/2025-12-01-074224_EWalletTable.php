<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EWalletTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'e_wallet_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'customer_type' => [
                'type' => 'ENUM',
                'constraint' => ['self', 'patner', 'parent_patner'],
                'default' => 'self',
            ],
            'customer_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'e_wallet_percentage' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'NULL' => true,
            ],
            'order_amount' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'NULL' => true,
            ],
            'e_wallet_amount' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'NULL' => true,
            ],

            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addPrimaryKey('e_wallet_id');
        $this->forge->addForeignKey('customer_id', 'customer', 'customer_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('order_id', 'order', 'order_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('e_wallet', true);
    }

    public function down()
    {
        $this->forge->dropTable('e_wallet', true);
    }
}
