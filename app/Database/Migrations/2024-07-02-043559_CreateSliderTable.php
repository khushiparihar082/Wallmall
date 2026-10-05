<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSliderTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'sliderid' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'slidertype' => [
                'type' => 'ENUM',
                'constraint' => ['Homepage slider', 'Banner slider', 'Product slider', 'Category type slider', 'Category slider', 'Brand slider', 'Other'],
                 'default' => 'Other'
            ],
            'sliderstyletype' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'slidertittle' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'sliderdescription' => [
                'type' => 'TEXT',
            ],
            'isactive' => [
                'type' => 'BOOLEAN',
                'default' => 1,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('sliderid');
        $this->forge->createTable('slider', true);
    }

    public function down()
    {
        $this->forge->dropTable('slider', true);
    }
}
