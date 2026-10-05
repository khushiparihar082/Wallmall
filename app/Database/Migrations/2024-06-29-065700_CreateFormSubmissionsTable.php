<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFormSubmissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'form_submissions_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'form_type' => [
                'type' => 'ENUM',
                'constraint' => ['contact_us', 'sales', 'support', 'career'],
                'default' => 'contact_us'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'partial_pending', 'resolved', 'status_remark'],
                'default' => 'pending'
            ],
            'status_remark' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true,
            ],
            'message' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'attachment_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'unsigned' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addPrimaryKey('form_submissions_id');
        $this->forge->addForeignKey('product_id', 'product', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('form_submissions', true);
    }

    public function down()
    {
        $this->forge->dropTable('form_submissions', true);
    }
}
