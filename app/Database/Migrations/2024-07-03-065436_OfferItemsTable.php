<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OfferItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'offer_item_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'offer_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('offer_item_id');
        $this->forge->addForeignKey('product_id', 'product', 'product_id','CASCADE','CASCADE');
        $this->forge->addForeignKey('offer_id', 'offer', 'offer_id','CASCADE','CASCADE');
       
        $this->forge->createTable('offer_item', true);
    }

    public function down()
    {
        $this->forge->createTable('offer_item', true);
    }
}
