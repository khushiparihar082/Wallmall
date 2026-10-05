<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EWalletPaymentWithdrawal extends Migration
{
    public function up()
  {
        $this->forge->addField([
            'withdraw_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],

            'customer_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],

            'e_wallet_ids' => [
                'type' => 'JSON',
                'null' => true
            ],

            'requested_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2'
            ],

            'approved_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true
            ],

            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending','approved','rejected','processing','paid'],
                'default'    => 'pending'
            ],

            'deduction_details' => [
                'type' => 'JSON',
                'null' => true
            ],

            'payment_method' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true
            ],

            'transaction_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],

            'remark' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],

            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('withdraw_id');
        $this->forge->addForeignKey('customer_id', 'customer', 'customer_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('e_wallet_payment_withdrawals',true);
    }

    public function down()
    {
      
        $this->forge->dropTable('e_wallet_payment_withdrawals',true);
    }
}
