<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTopSearchSummaryTable extends Migration
{
    public function up()
    {
        // Create top_search_summary table
        $this->forge->addField([
            'top_search_summary_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'total_search_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
            ],
        ]);

        $this->forge->addKey('top_search_summary_id', true);
        $this->forge->addUniqueKey('product_id');

        $this->forge->createTable('top_search_summary');

        // Create triggers for updating the top_search_summary table
        $this->db->query("
            CREATE TRIGGER update_top_search_summary
            AFTER INSERT ON top_search
            FOR EACH ROW
            BEGIN
                -- Update existing summary
                IF EXISTS (SELECT 1 FROM top_search_summary WHERE product_id = NEW.product_id) THEN
                    UPDATE top_search_summary
                    SET total_search_count = (SELECT SUM(customer_search_count) FROM top_search WHERE product_id = NEW.product_id)
                    WHERE product_id = NEW.product_id;
                ELSE
                    -- Insert new summary
                    INSERT INTO top_search_summary (product_id, total_search_count)
                    VALUES (NEW.product_id, NEW.customer_search_count);
                END IF;
            END
        ");

        $this->db->query("
            CREATE TRIGGER update_top_search_summary_on_update
            AFTER UPDATE ON top_search
            FOR EACH ROW
            BEGIN
                -- Update summary for the product
                UPDATE top_search_summary
                SET total_search_count = (SELECT SUM(customer_search_count) FROM top_search WHERE product_id = NEW.product_id)
                WHERE product_id = NEW.product_id;
            END
        ");
    }

    public function down()
    {
        // Drop triggers first to avoid foreign key constraints issues
        $this->db->query("DROP TRIGGER IF EXISTS update_top_search_summary");
        $this->db->query("DROP TRIGGER IF EXISTS update_top_search_summary_on_update");

        // Drop the top_search_summary table
        $this->forge->dropTable('top_search_summary');
    }
}
