<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSliderItemTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'slideritemid' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'sliderid' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'recordid' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'redirecturl' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('slideritemid');
        $this->forge->addForeignKey('sliderid', 'slider', 'sliderid', 'CASCADE', 'CASCADE');
        $this->forge->createTable('slideritem', true);
    }

    public function down()
    {
        $this->forge->dropTable('slideritem', true);
    }
}
