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

        ]);
    }

    public function down()
    {
        //
    }
}
