<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubscriptionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'subscriptions_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'subscription_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'subscription_plan_detail' => [
                'type' => 'TEXT',
            ],
            'maintannace_duration_month' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'maintanance_duration_charges' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'per_order_commission' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'subscription_image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('subscriptions_id', true);
        $this->forge->createTable('subscriptions');
    }

    public function down()
    {
        $this->forge->dropTable('subscriptions');
    }
}
