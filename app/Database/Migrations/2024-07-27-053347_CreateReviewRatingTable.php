<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReviewRatingTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customer_review_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
                'auto_increment' => true,
            ],
            'customer_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'product_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'variant_id' => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'customer_rating' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'customer_review' => [
                'type' => 'TEXT',
            ],
            'customer_review_image1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'customer_review_image2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'customer_review_image3' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'customer_review_image4' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'customer_review_status' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('customer_review_id', true);

        // Adding foreign key constraints
        $this->forge->addForeignKey('customer_id', 'customer', 'customer_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'product', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('variant_id', 'product_variant', 'variant_id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('customer_review');
    }

    public function down()
    {
        $this->forge->dropTable('customer_review');
    }
}
