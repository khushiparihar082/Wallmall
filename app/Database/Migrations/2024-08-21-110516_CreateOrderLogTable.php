<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderLogTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_log_id' => [
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
            'order_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'log_remark' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('order_log_id', true);
        $this->forge->addForeignKey('order_id', 'order', 'order_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('order_log');
    }

    public function down()
    {
        $this->forge->dropTable('order_log');
    }
}
