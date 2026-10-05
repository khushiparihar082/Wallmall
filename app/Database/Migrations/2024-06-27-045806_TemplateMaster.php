<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TemplateMaster extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'template_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'template_type' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => false,
                'unique' => true,
            ],
            'template_heading' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => false,
                'unique' => true,
            ],
            'email_send' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],
            'email_subject' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'email_cc' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'email_body' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'email_attachment' => [
                'type' => 'TINYINT',
                'constraint' => 0,
                'null' => false,
            ],
            'sms_send' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
            ],
            'sms_template_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'sms_dlt_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'sms_message' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'template_placeholder' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addPrimaryKey('template_id');
        $this->forge->createTable('template', true);
    }

    public function down()
    {
        $this->forge->dropTable('template', true);
    }
}
