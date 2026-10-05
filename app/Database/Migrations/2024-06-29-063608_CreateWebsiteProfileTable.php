<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteProfileTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'website_profile_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            // Header footer
            'firm_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'firm_slogan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'firm_logo_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'firm_address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
          
            'firm_cin_no' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'firm_gst_no' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'firm_pan_no' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'firm_address_gmap_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'website_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'play_store_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'app_store_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'facebook_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'instagram_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'twitter_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'linkedin_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'youtube_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'pinterest_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'telegram_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'google_search_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // Pages
            // Home Page
            'sales_mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true,
            ],
            'sales_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'sales_whatsapp' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true,
            ],
            'home_page_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'home_page_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'home_page_seo_description' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            'home_page_content' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],

            // About Page
            'about_page_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'about_page_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'about_page_seo_description' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            'about_page_content' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
          

            // Contact Page
            'contact_mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true,
            ],
            'contact_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'contact_whatsapp' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true,
            ],
            'contact_page_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'contact_page_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'contact_page_seo_description' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            'contact_page_content' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            'google_embaded_iframe' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'contact_page_content',
            ],
            // Support Page
            'support_mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true,
            ],
            'support_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'support_whatsapp' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true,
            ],
            'support_page_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'support_page_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'support_page_seo_description' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            'support_page_content' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            // Career Page
            'career_mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true,
            ],
            'career_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'career_whatsapp' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true,
            ],
            'career_page_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'career_page_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'career_page_seo_description' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            'career_page_content' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            // faq Page
            'faq_page_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'faq_page_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'faq_page_seo_description' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            'faq_page_content' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            // Term and Condetion Page
            'tc_page_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tc_page_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tc_page_seo_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tc_page_content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // Privacy and Policy Page
            'pp_page_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'pp_page_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'pp_page_seo_description' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            'pp_page_content' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            // return Page
            'return_page_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'return_page_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'return_page_seo_description' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            'return_page_content' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            // refund Page
            'refund_page_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'refund_page_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'refund_page_seo_description' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            'refund_page_content' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            // disclaimer Page
            'disclaimer_page_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'disclaimer_page_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'disclaimer_page_seo_description' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            'disclaimer_page_content' => [
                'type' => 'TEXT',
                'constraint' => 255,
                'null' => true,
            ],
            'shipping_policy_page_seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'shipping_policy_page_seo_keyword' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'shipping_policy_page_seo_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'shipping_policy_page_content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'image_slider_web_img_1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_web_img_alt_1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_web_redirect_url_1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_web_img_2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_web_img_alt_2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_web_redirect_url_2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_web_img_3' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_web_img_alt_3' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_web_redirect_url_3' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_web_img_4' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_web_img_alt_4' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_web_redirect_url_4' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_web_img_5' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_web_img_alt_5' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_web_redirect_url_5' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            // Add columns for mobile images
            'image_slider_mob_img_1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_mob_img_alt_1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_mob_redirect_url_1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_mob_img_2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_mob_img_alt_2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_mob_redirect_url_2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_mob_img_3' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_mob_img_alt_3' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_mob_redirect_url_3' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_mob_img_4' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_mob_img_alt_4' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_mob_redirect_url_4' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_mob_img_5' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_mob_img_alt_5' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'image_slider_mob_redirect_url_5' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addPrimaryKey('website_profile_id');
        $this->forge->createTable('website_profile', true);
    }


    public function down()
    {
        $this->forge->dropTable('website_profile', true);
    }
}
