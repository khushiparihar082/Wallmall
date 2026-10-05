<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StateMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'state_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'state_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'state_code' => [
                'type' => 'CHAR',
                'constraint' => 3,
                'null' => true,
                'comment' => 'gst state code',
            ],
            'country_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'short_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('state_id', true);
        $this->forge->addForeignKey('country_id', 'country', 'country_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('state', true);
    }

    public function down()
    {
        $this->forge->dropTable('state', true);
    }
}
