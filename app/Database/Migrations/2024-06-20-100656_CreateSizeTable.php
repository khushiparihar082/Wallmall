<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSizeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'size_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'size_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('size_id');
        $this->forge->addUniqueKey('size_name');
        $this->forge->createTable('size',true);
    }

    public function down()
    {
        $this->forge->dropTable('size',true);
    }
}
