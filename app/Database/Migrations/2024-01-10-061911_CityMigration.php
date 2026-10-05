<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CityMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'city_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'city_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'country_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'state_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('city_id', true);
        $this->forge->addForeignKey('country_id', 'country', 'country_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('state_id', 'state', 'state_id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('city', true);
    }

    public function down()
    {
        $this->forge->dropTable('city', true);
    }
}
