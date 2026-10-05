<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductVsFeature extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_vs_feature_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'feature_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('product_vs_feature_id');
        $this->forge->addForeignKey('feature_id', 'feature', 'feature_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'product', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_vs_feature', true);
    }

    public function down()
    {
        $this->forge->createTable('product_vs_feature', true);
    }
}
