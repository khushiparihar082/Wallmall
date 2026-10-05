<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCouponTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'coupon_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'coupon_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'coupon_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'coupon_description' => [
                'type' => 'TEXT',
                'constraint' => 255,
            ],
            'coupon_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'coupon_image_alt' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'coupon_type' => [
                'type' => 'ENUM',
                'constraint' => ['ref_coupon', 'multi_customer_coupon'],
            ],
            'coupon_from' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'coupon_to' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'calculation_type' => [
                'type' => 'ENUM',
                'constraint' => ['percentage', 'amount'],
            ],
            'coupon_value' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
            ],
            'repeat_no' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'max_use_coupon_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
            ],
            'min_order_value' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'null' => true,
            ],
            'max_order_value' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'null' => true,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addPrimaryKey('coupon_id');
        $this->forge->createTable('coupon', true);
    }

    public function down()
    {
        $this->forge->dropTable('coupon', true);
    }
}
