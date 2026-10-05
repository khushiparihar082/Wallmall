<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFeatureTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'feature_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'feature_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'feature_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'NULL' => true,
            ],
            'feature_type_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'feature_seo_description' => [
                'type' => 'TEXT',
                'NULL' => true,
            ],
            'feature_description' => [
                'type' => 'TEXT',
                'NULL' => true
            ],
            'feature_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'feature_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'feature_alt_text' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('feature_id');
        $this->forge->addForeignKey('feature_type_id', 'feature_type', 'feature_type_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('feature', true);
    }

    public function down()
    {
        $this->forge->dropTable('feature', true);
    }
}
