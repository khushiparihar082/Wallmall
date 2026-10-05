<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOrderPaymentIdToCustomerOrder extends Migration
{
    public function up()
    {
        // Add the new column to the customer_order table
        $this->forge->addColumn('order', [
            'order_payment_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // Set to true if the field can be null
                'after'      => 'docket_number', // Adjust the position of the new column as needed
            ],
        ]);

        // Add the foreign key constraint
        $this->forge->addForeignKey('order_payment_id', 'order_payment', 'order_payment_id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        // Drop the foreign key first
        $this->forge->dropForeignKey('customer_order', 'customer_order_order_payment_id_foreign');
        
        // Remove the column
        $this->forge->dropColumn('customer_order', 'order_payment_id');
    }
}
