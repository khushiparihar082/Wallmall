<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSizeVsVariantTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'size_vs_variant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'size_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'variant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        
        $this->forge->addPrimaryKey('size_vs_variant_id');
        $this->forge->addForeignKey('size_id', 'size', 'size_id','CASCADE','CASCADE');
        $this->forge->addForeignKey('variant_id', 'product_variant', 'variant_id','CASCADE','CASCADE');
        $this->forge->createTable('size_vs_variant',true);
    }

    public function down()
    {
        $this->forge->dropTable('size_vs_variant',true);
    }
}
