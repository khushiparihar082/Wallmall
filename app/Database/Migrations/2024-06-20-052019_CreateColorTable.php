<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateColorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'color_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'color_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'color_code' => [
                'type' => 'TEXT',
                'NULL' => true
            ],
            'color_alt_text' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'color_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('color_id');
        $this->forge->addUniqueKey('color_name');
        $this->forge->createTable('color',true);
    }


    public function down()
    {
        $this->forge->createTable('color', true);
    }
}
