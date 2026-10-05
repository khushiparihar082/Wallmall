<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStockTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'stock_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'variant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addPrimaryKey('stock_id');
        $this->forge->addForeignKey('variant_id', 'product_variant', 'variant_id','CASCADE','CASCADE');
        $this->forge->createTable('stock',true);
   
    }

    public function down()
    {
        $this->forge->createTable('stock', true);
    }
}
