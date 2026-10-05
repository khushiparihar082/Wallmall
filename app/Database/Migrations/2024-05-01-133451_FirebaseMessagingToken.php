<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FirebaseMessagingToken extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'firebase_messaging_token_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'access_type' => [
                'type' => 'ENUM',
                'constraint' => ['user','customer','other'],
                'default' => 'other'
            ],
            'access_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'token' => [
                'type' => 'TEXT',
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        ]);
        $this->forge->addPrimaryKey('firebase_messaging_token_id');
        $this->forge->createTable('firebase_messaging_tokken', true);
    }

    public function down()
    {
        //
    }
}
