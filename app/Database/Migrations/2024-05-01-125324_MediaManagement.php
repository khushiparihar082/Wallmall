<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MediaManagement extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'media_id' => [
                'type' => 'CHAR',
                'constraint' => 36,
            ],
            'module_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'record_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'media_type' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'media_filename' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'media_file_extension' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'media_sequence' => [
                'type' => 'INT',
            ],
            'alt_text' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'media_text_content' => [
                'type' => 'TEXT',
            ],
            'media_author' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'media_creation_date' => [
                'type' => 'DATE',
            ],
            'media_expiration_date' => [
                'type' => 'DATE',
            ],
            'is_featured' => [
                'type' => 'BOOLEAN',
                'default' => 0,
            ],
            'media_visibility' => [
                'type' => 'ENUM',
                'constraint' => ['public', 'private'],
                'default' => 'public',
            ],
            'media_path' => [
                'type' => 'TEXT',
            ],
            'is_external_drive' => [
                'type' => 'BOOLEAN',
                'default' => 0,
            ],
            'is_blob' => [
                'type' => 'BOOLEAN',
                'default' => 0,
            ],
            'media_blob' => [
                'type' => 'BLOB',
            ],
            'thumbnail_path' => [
                'type' => 'TEXT',
            ],
            'thumbnail_external_drive' => [
                'type' => 'BOOLEAN',
                'default' => 0,
            ],
            'thumbnail_blob' => [
                'type' => 'BLOB',
            ],
            'redirect_url' => [
                'type' => 'TEXT',
            ],
            'uploader_type' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'uploader_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'uploader_username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('media_id');
        $this->forge->createTable('media_management',true);
    }

    public function down()
    {
        $this->forge->dropTable('media_management');
    }
}
