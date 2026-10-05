<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OTPVerificationTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'otp_verification_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
            'otp' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addPrimaryKey('otp_verification_id');
        $this->forge->createTable('otp_varification', true);
    }

    public function down()
    {
        $this->forge->dropTable('otp_varification', true);
    }
}
