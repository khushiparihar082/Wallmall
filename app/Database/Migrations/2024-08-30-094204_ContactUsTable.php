<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContactUsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'contact_us_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
                'auto_increment' => true,
            ],
            'fullname' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
                'null' => true,
            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'unique' => true,
                'null' => true,
            ],
            'message' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'order_inquiry' => [
                'type' => 'ENUM',
                'constraint' => ['business', 'product_quality', 'other', 'order_specific'],
                'default' => 'other',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('contact_us_id', true);

        $this->forge->createTable('contact_us');
    }

    public function down()
    {
        $this->forge->dropTable('contact_us');
    }
}

