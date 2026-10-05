<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerAddressTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customer_address_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
                'auto_increment' => true,
            ],
            'customer_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'customer_country_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'customer_state_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'customer_city_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'customer_addresses' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255, 
            ],
            'customer_pincode' => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
            ],
            'address_type' => [
                'type'           => 'ENUM',
                'constraint'     => ['office', 'home', 'other'],
                'default'        => 'home',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('customer_address_id', true);

        // Adding foreign key constraints
        $this->forge->addForeignKey('customer_id', 'customer', 'customer_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('customer_country_id', 'country', 'country_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('customer_state_id', 'state', 'state_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('customer_city_id', 'city', 'city_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('customer_address');
    }

    public function down()
    {
        $this->forge->dropTable('customer_address');
    }
}
