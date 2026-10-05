<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerCartSummaryTable extends Migration
{
    public function up()
    {
        // Create customer_cart_summary table
        $this->forge->addField([
            'customer_cart_summary_id' => [
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
            'total_product_quantity_sum' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
            ],
        ]);

        $this->forge->addKey('customer_cart_summary_id', true);
        $this->forge->addUniqueKey('customer_id');

        $this->forge->createTable('customer_cart_summary');

        // Create triggers for updating the customer_cart_summary table
        $this->db->query("
            CREATE TRIGGER update_customer_cart_summary
            AFTER INSERT ON customer_cart
            FOR EACH ROW
            BEGIN
                -- Update existing summary
                IF EXISTS (SELECT 1 FROM customer_cart_summary WHERE customer_id = NEW.customer_id) THEN
                    UPDATE customer_cart_summary
                    SET total_product_count = (SELECT COUNT(DISTINCT product_id) FROM customer_cart WHERE customer_id = NEW.customer_id),
                        total_product_quantity_sum = (SELECT SUM(cart_quantity) FROM customer_cart WHERE customer_id = NEW.customer_id)
                    WHERE customer_id = NEW.customer_id;
                ELSE
                    -- Insert new summary
                    INSERT INTO customer_cart_summary (customer_id, total_product_count, total_product_quantity_sum)
                    VALUES (NEW.customer_id,
                            (SELECT COUNT(DISTINCT product_id) FROM customer_cart WHERE customer_id = NEW.customer_id),
                            (SELECT SUM(cart_quantity) FROM customer_cart WHERE customer_id = NEW.customer_id));
                END IF;
            END
        ");

        $this->db->query("
            CREATE TRIGGER update_customer_cart_summary_on_update
            AFTER UPDATE ON customer_cart
            FOR EACH ROW
            BEGIN
                -- Update summary for the customer
                UPDATE customer_cart_summary
                SET total_product_count = (SELECT COUNT(DISTINCT product_id) FROM customer_cart WHERE customer_id = NEW.customer_id),
                    total_product_quantity_sum = (SELECT SUM(cart_quantity) FROM customer_cart WHERE customer_id = NEW.customer_id)
                WHERE customer_id = NEW.customer_id;
            END
        ");

        $this->db->query("
            CREATE TRIGGER update_customer_cart_summary_on_delete
            AFTER DELETE ON customer_cart
            FOR EACH ROW
            BEGIN
                -- Update summary for the customer
                UPDATE customer_cart_summary
                SET total_product_count = (SELECT COUNT(DISTINCT product_id) FROM customer_cart WHERE customer_id = OLD.customer_id),
                    total_product_quantity_sum = (SELECT SUM(cart_quantity) FROM customer_cart WHERE customer_id = OLD.customer_id)
                WHERE customer_id = OLD.customer_id;

                -- Remove summary if there are no more records
                DELETE FROM customer_cart_summary
                WHERE customer_id = OLD.customer_id
                  AND total_product_count = 0
                  AND total_product_quantity_sum = 0;
            END
        ");
    }

    public function down()
    {
        // Drop triggers first to avoid foreign key constraints issues
        $this->db->query("DROP TRIGGER IF EXISTS update_customer_cart_summary");
        $this->db->query("DROP TRIGGER IF EXISTS update_customer_cart_summary_on_update");
        $this->db->query("DROP TRIGGER IF EXISTS update_customer_cart_summary_on_delete");

        // Drop the customer_cart_summary table
        $this->forge->dropTable('customer_cart_summary');
    }
}
