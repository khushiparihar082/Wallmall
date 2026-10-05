<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUnitTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'unit_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'unit_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('unit_id');
        $this->forge->addUniqueKey('unit_name');
        $this->forge->createTable('unit',true);
    }

    public function down()
    {
        $this->forge->dropTable('unit',true);
    }
}
