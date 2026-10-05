<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFeaturesTypeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'feature_type_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'feature_type_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'feature_type_description' => [
                'type' => 'TEXT',
                'NULL' => true
            ],
            'feature_type_seo_description' => [
                'type' => 'TEXT',
                'NULL' => true,
            ],
            'feature_type_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'NULL' => true,
            ],
            'feature_type_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'feature_type_alt_text' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'feature_type_image' => [
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
        $this->forge->addPrimaryKey('feature_type_id');
        $this->forge->addUniqueKey('feature_type_name');
        $this->forge->createTable('feature_type',true);
    }

    public function down()
    {
        $this->forge->dropTable('feature_type',true);
    }
}
