<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerWishlistSummaryTable extends Migration
{
    public function up()
    {
        // Create customer_wishlist_summary table
        $this->forge->addField([
            'customer_wishlist_summary_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'customer_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'total_product_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
            ],
        ]);

        $this->forge->addKey('customer_wishlist_summary_id', true);
        $this->forge->addUniqueKey('customer_id');

        $this->forge->createTable('customer_wishlist_summary');

        // Create triggers for updating the customer_wishlist_summary table
        $this->db->query("
            CREATE TRIGGER update_customer_wishlist_summary
            AFTER INSERT ON customer_wishlist
            FOR EACH ROW
            BEGIN
                -- Update existing summary
                IF EXISTS (SELECT 1 FROM customer_wishlist_summary WHERE customer_id = NEW.customer_id) THEN
                    UPDATE customer_wishlist_summary
                    SET total_product_count = (SELECT COUNT(*) FROM customer_wishlist WHERE customer_id = NEW.customer_id)
                    WHERE customer_id = NEW.customer_id;
                ELSE
                    -- Insert new summary
                    INSERT INTO customer_wishlist_summary (customer_id, total_product_count)
                    VALUES (NEW.customer_id,
                            (SELECT COUNT(*) FROM customer_wishlist WHERE customer_id = NEW.customer_id));
                END IF;
            END
        ");

        $this->db->query("
            CREATE TRIGGER update_customer_wishlist_summary_on_update
            AFTER UPDATE ON customer_wishlist
            FOR EACH ROW
            BEGIN
                -- Update summary for the customer
                UPDATE customer_wishlist_summary
                SET total_product_count = (SELECT COUNT(*) FROM customer_wishlist WHERE customer_id = NEW.customer_id)
                WHERE customer_id = NEW.customer_id;
            END
        ");

        $this->db->query("
            CREATE TRIGGER update_customer_wishlist_summary_on_delete
            AFTER DELETE ON customer_wishlist
            FOR EACH ROW
            BEGIN
                -- Update summary for the customer
                UPDATE customer_wishlist_summary
                SET total_product_count = (SELECT COUNT(*) FROM customer_wishlist WHERE customer_id = OLD.customer_id)
                WHERE customer_id = OLD.customer_id;

                -- Remove summary if there are no more records
                DELETE FROM customer_wishlist_summary
                WHERE customer_id = OLD.customer_id
                  AND total_product_count = 0;
            END
        ");
    }

    public function down()
    {
        // Drop triggers first to avoid foreign key constraints issues
        $this->db->query("DROP TRIGGER IF EXISTS update_customer_wishlist_summary");
        $this->db->query("DROP TRIGGER IF EXISTS update_customer_wishlist_summary_on_update");
        $this->db->query("DROP TRIGGER IF EXISTS update_customer_wishlist_summary_on_delete");

        // Drop the customer_wishlist_summary table
        $this->forge->dropTable('customer_wishlist_summary');
    }
}
