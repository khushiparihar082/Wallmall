<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FAQTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'faq_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'faq_question' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'faq_answer' => [
                'type' => 'TEXT',
                'null' => true,  // Corrected line
            ],
            'faq_status' => [
                'type' => 'ENUM',
                'constraint' => ['draft', 'published'],
                'default' => 'draft',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('faq_id');
        $this->forge->createTable('faq', true);
    }

    public function down()
    {
        $this->forge->dropTable('faq', true);
    }
}
