<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReviewSummaryTable extends Migration
{
    public function up()
    {
        // Create review_summary table
        $this->forge->addField([
            'review_summary_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'variant_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'review_count_sum' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'default' => 0,
            ],
            'review_rating_avg' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0.00,
            ],
        ]);

        $this->forge->addKey('review_summary_id', true);
        $this->forge->addUniqueKey('variant_id');

        $this->forge->createTable('review_summary');

        // Create triggers for the review summary
        $this->db->query("
            CREATE TRIGGER update_review_summary
            AFTER INSERT ON customer_review
            FOR EACH ROW
            BEGIN
                IF NEW.customer_review_status = 1 THEN
                    IF EXISTS (SELECT 1 FROM review_summary WHERE variant_id = NEW.variant_id) THEN
                        UPDATE review_summary
                        SET review_count_sum = (SELECT COUNT(*) FROM customer_review WHERE variant_id = NEW.variant_id AND customer_review_status = 1),
                            review_rating_avg = (SELECT AVG(customer_rating) FROM customer_review WHERE variant_id = NEW.variant_id AND customer_review_status = 1)
                        WHERE variant_id = NEW.variant_id;
                    ELSE
                        INSERT INTO review_summary (variant_id, review_count_sum, review_rating_avg)
                        VALUES (NEW.variant_id, 
                                (SELECT COUNT(*) FROM customer_review WHERE variant_id = NEW.variant_id AND customer_review_status = 1),
                                (SELECT AVG(customer_rating) FROM customer_review WHERE variant_id = NEW.variant_id AND customer_review_status = 1));
                    END IF;
                END IF;
            END
        ");

        $this->db->query("
            CREATE TRIGGER update_review_summary_on_update
            AFTER UPDATE ON customer_review
            FOR EACH ROW
            BEGIN
                IF (NEW.customer_review_status = 1 AND OLD.customer_review_status = 1) OR 
                   (NEW.customer_review_status = 1 AND OLD.customer_review_status = 0) THEN
                    UPDATE review_summary
                    SET review_count_sum = (SELECT COUNT(*) FROM customer_review WHERE variant_id = NEW.variant_id AND customer_review_status = 1),
                        review_rating_avg = (SELECT AVG(customer_rating) FROM customer_review WHERE variant_id = NEW.variant_id AND customer_review_status = 1)
                    WHERE variant_id = NEW.variant_id;
                END IF;
            END
        ");
    }

    public function down()
    {
        // Drop triggers first to avoid foreign key constraints issues
        $this->db->query("DROP TRIGGER IF EXISTS update_review_summary");
        $this->db->query("DROP TRIGGER IF EXISTS update_review_summary_on_update");

        // Drop the review_summary table
        $this->forge->dropTable('review_summary');
    }
}
