<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCouponFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('website_profile', [
            'is_refer_coupon_active' => [
                'type' => 'BOOLEAN',
                'default' => 0,
            ],
            'refer_coupon_calculation_type' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'refer_coupon_value' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'refer_coupon_min_order_value' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'refer_coupon_max_order_value' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'refer_coupon_valid_days' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'refer_coupon_send' => [
                'type' => 'ENUM',
                'constraint' => ['after_registration', 'after_order_placed', 'after_delivered'],

            ],
            'level1' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'level1_commission_percentage' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'level2' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'level2_commission_percentage' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'wallet_activation_amount' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'wallet_withdrawal_amount' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'firm_pincode' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'pickup_location' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'order_tracking_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],

        ]);
    }

    public function down()
    {
        //
    }
}
