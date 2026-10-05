<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OfferMasterTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'offer_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'offer_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'offer_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'offer_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'offer_alt_text' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],

            'offer_type' => [
                'type' => 'ENUM',
                'constraint' => ['festival', 'season', 'other', 'deal_of_the_day'],
                'default' => 'other',
            ],
            'offer_discount' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true, // Set to null
            ],
            'offer_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'offer_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'offer_seo_description' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            'offer_from' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'offer_to' => [
                'type' => 'DATE',
                'null' => true,
            ],

            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],

            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('offer_id');
        $this->forge->createTable('offer', true);
    }

    public function down()
    {
        $this->forge->createTable('offer', true);
    }
}
