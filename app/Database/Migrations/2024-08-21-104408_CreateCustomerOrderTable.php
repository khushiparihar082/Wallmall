<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerOrderTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'refund_transaction_id' => [
                'type'       => 'INT',
                'constraint' => 11,  // Added constraint for consistency
                'null'       => true,
            ],
            'razorpay_order_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'order_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'order_date datetime default current_timestamp',
            'order_delivery_expected_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'order_delivered_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'customer_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'purchase_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'mrp_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'variant_dis_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'offer_total_dis' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'order_coupon_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'coupon_calc_type' => [
                'type' => 'ENUM',
                'constraint' => ['percentage', 'amount'],
            ],
            'coupon_value' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'coupon_dis_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'shipping_charges_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'order_shipping_company_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'total_refund_amount' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,  // Ensuring this field is not nullable
            ],
            'roundoff_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'return_docker_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'return_shipping_company_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'return_delivery_expected_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'return_delivered_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'order_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'gst_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'default' => 0.00,
            ],
            'taxable_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'default' => 0.00,
            ],
            'cod_charges_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'remaining_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'is_order_patner_request' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true,
            ],
            'order_remark' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'order_status' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'order_payment_pending',
                    'order_payment_processing',
                    'order_payment_success',
                    'order_payment_fail',
                    'order_payment_verified_manual',
                    'order_payment_verified_razorpay',
                    'order_accepted',
                    'order_ready_to_ship',
                    'order_shipped',
                    'order_exchange_shipped',
                    'order_delivered',
                    'order_not_delivered',
                    'order_exchanged',
                    'refund_request',
                    'return_request',
                    'exchange_request',
                    'request_return_rejected',
                    'request_exchange_rejected',
                    'request_refund_approved',
                    'request_return_approved',
                    'request_exchange_approved',
                    'refund_to_customer',
                ],
                'default' => 'order_payment_pending',
                'null'    => false,  // Ensuring this field is not nullable
            ],

            'docket_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'payment_mode' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'billing_address' => [
                'type' => 'TEXT',
            ],
            'billing_country_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'billing_state_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'billing_city_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'billing_pincode' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'receiver_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'receiver_mobile' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'order_return_exchange_days' => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'wallet_used_amount' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'delhivery_waybill' => [
                'type' => 'TEXT',
            ],
            'return_shipping_charge' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'is_return_shipping_charge_agree' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true,
            ],

            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('order_id', true);
        // Adding foreign key constraints
        $this->forge->addForeignKey('customer_id', 'customer', 'customer_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('billing_country_id', 'country', 'country_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('billing_state_id', 'state', 'state_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('billing_city_id', 'city', 'city_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('order');
    }

    public function down()
    {
        $this->forge->dropTable('order');
    }
}
