<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use App\Traits\CommonTraits;

class ThirdPartyIntegration extends Migration
{
    use CommonTraits;
    public function up()
    {
        $this->forge->addField([
            'third_party_integration_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'third_party_integration_heading' => [
                'type'       => 'VARCHAR',
                'constraint' => 255, // Example: 'google_auth', 'firebase', 'razorpay', 'sms', 'email'
                'unique'     => true, // Ensures the type is unique
                'null' => false,
            ],
            'third_party_integration_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 100, // Example: 'google_auth', 'firebase', 'razorpay', 'sms', 'email'
                'unique'     => true, // Ensures the type is unique
                'null' => false,
            ],
            'third_party_integration_image' => [
                'type'       => 'text',
                'constraint' => 255, // Example: image URL or SVG
                'null' => true,
            ],
            'third_party_integration_testing_data' => [
                'type'       => 'TEXT', // JSON or encoded JWT token for storing various credential data
                'null' => false,
            ],
            'third_party_integration_production_data' => [
                'type'       => 'TEXT', // JSON or encoded JWT token for storing various credential data
                'null' => false,
            ],
            'third_party_integration_is_production' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'third_party_integration_is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('third_party_integration_id'); // Primary Key
        $this->forge->createTable('third_party_integration', true);
    }

    public function down()
    {
        //
    }
}
