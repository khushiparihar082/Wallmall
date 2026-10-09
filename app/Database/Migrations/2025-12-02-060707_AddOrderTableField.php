<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOrderTableField extends Migration
{
    public function up()
    {
        $this->forge->addColumn('order', [
           
            'status_action_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'status_action_date' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            
        ]);

        // Add foreign key constraint
        $this->forge->addForeignKey('status_action_id', 'user', 'user_id', 'CASCADE', 'RESTRICT');
        $this->forge->processIndexes('order');
    }

    public function down()
    {
        // Rollback logic if needed
    }
}
