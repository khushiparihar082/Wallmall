<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubscribersListTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'subscriber_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'is_subscribe' => [
                'type' => 'BOOLEAN',
                'default' => true, 
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addPrimaryKey('subscriber_id');
        $this->forge->createTable('subscribers',true);
    }

    public function down()
    {
        //
    }
}
