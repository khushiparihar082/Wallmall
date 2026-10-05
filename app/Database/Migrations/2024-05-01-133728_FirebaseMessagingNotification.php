<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FirebaseMessagingNotification extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'firebase_messaging_notification_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'access_type' => [
                'type' => 'ENUM',
                'constraint' => ['user', 'customer', 'other'],
                'default' => 'other'
            ],
            'access_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'body' => [
                'type'       => 'TEXT',
            ],
            'url' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->forge->addPrimaryKey('firebase_messaging_notification_id');
        $this->forge->createTable('firebase_messaging_notification', true);
    }

    public function down()
    {
        //
    }
}
