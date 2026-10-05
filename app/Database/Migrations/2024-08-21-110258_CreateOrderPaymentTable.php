<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderPaymentTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_payment_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'razorpay_payment_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'razorpay_signature' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'payment_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'payment_verify' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'payment_transaction_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'payment_amt' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'payment_remark' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'payment_response' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('order_payment_id', true);
        $this->forge->addForeignKey('order_id', 'order', 'order_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('order_payment');
    }

    public function down()
    {
        $this->forge->dropTable('order_payment');
    }
}
