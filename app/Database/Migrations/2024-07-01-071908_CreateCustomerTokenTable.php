<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerTokenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'token_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'customer_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'token' => [
                'type' => 'TEXT',
            ],
            'expiry' => [
                'type' => 'TIMESTAMP',
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'device_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at datetime default current_timestamp',
        ]);

        $this->forge->addPrimaryKey('token_id');
        $this->forge->addForeignKey('customer_id', 'customer', 'customer_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('customer_token',true);
    }

    public function down()
    {
        $this->forge->dropTable('customer_token',true);
    }
}
