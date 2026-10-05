<?php

namespace App\Database\Seeds;

use ApiResponseStatusCode;
use App\Models\TemplateModel;
use CodeIgniter\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run()
    {
        $tm = new TemplateModel();
        $template_data = [];
        //Template Data
        // Existing Template Data
        $template_data[] = [
            "template_id" => 1,
            "template_type" => "registration_otp",
            "template_heading" => "Registration OTP",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{OTP}}"
        ];
        $template_data[] = [
            "template_id" => 2,
            "template_type" => "registration_successfully",
            "template_heading" => "Registration Successfully",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}}"
        ];
        $template_data[] = [
            "template_id" => 3,
            "template_type" => "forget_password",
            "template_heading" => "Forget Password OTP",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{OTP}}"
        ];
        $template_data[] = [
            "template_id" => 4,
            "template_type" => "login_otp",
            "template_heading" => "Login OTP ",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{OTP}}"
        ];
        $template_data[] = [
            "template_id" => 5,
            "template_type" => "password_change_successfully",
            "template_heading" => "Password Change Successfully",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}}"
        ];

        // New Template Data as per given content

        // Order Confirmation
        $template_data[] = [
            "template_id" => 6,
            "template_type" => "order_confirmation",
            "template_heading" => "Order Confirmation",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{ORDER_NUMBER}} {{ORDER_DATE}} {{ORDER_AMOUNT}} {{ORDER_LINK}} {{SUPPORT_CONTACT}}"
        ];

        // Order Shipped
        $template_data[] = [
            "template_id" => 7,
            "template_type" => "order_shipped",
            "template_heading" => "Order Shipped",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{ORDER_NUMBER}} {{TRACKING_LINK}} {{CARRIER_NAME}} {{TRACKING_NUMBER}} {{ESTIMATED_DELIVERY_DATE}}"
        ];

        // Delivery Confirmation
        $template_data[] = [
            "template_id" => 8,
            "template_type" => "delivery_confirmation",
            "template_heading" => "Delivery Confirmation",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{ORDER_NUMBER}} {{SUPPORT_CONTACT}}"
        ];

        // Order Cancelled
        $template_data[] = [
            "template_id" => 9,
            "template_type" => "order_cancelled",
            "template_heading" => "Order Cancelled",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{ORDER_NUMBER}} {{SUPPORT_CONTACT}}"
        ];

        // Order Refund Processed
        $template_data[] = [
            "template_id" => 10,
            "template_type" => "order_refund_processed",
            "template_heading" => "Order Refund Processed",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{ORDER_NUMBER}} {{SUPPORT_CONTACT}}"
        ];

        // Payment Failure
        $template_data[] = [
            "template_id" => 11,
            "template_type" => "payment_failure",
            "template_heading" => "Payment Failure",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{ORDER_NUMBER}} {{SUPPORT_CONTACT}}"
        ];

        // Back-in-Stock Notification
        $template_data[] = [
            "template_id" => 12,
            "template_type" => "back_in_stock",
            "template_heading" => "Back-in-Stock Notification",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{PRODUCT_NAME}} {{PRODUCT_LINK}}"
        ];

        // Abandoned Cart Reminder
        $template_data[] = [
            "template_id" => 13,
            "template_type" => "abandoned_cart_reminder",
            "template_heading" => "Abandoned Cart Reminder",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{CART_LINK}} {{SUPPORT_CONTACT}}"
        ];

        // Account Registration Confirmation
        $template_data[] = [
            "template_id" => 14,
            "template_type" => "account_registration_confirmation",
            "template_heading" => "Account Registration Confirmation",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{LOGIN_LINK}} {{SUPPORT_CONTACT}}"
        ];

        // Password Reset
        $template_data[] = [
            "template_id" => 15,
            "template_type" => "password_reset",
            "template_heading" => "Password Reset",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{RESET_LINK}} {{SUPPORT_CONTACT}}"
        ];

        // Promotional Offer
        $template_data[] = [
            "template_id" => 16,
            "template_type" => "promotional_offer",
            "template_heading" => "Promotional Offer",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{DISCOUNT}} {{PROMO_CODE}} {{STORE_LINK}}"
        ];

        // Feedback Request
        $template_data[] = [
            "template_id" => 17,
            "template_type" => "feedback_request",
            "template_heading" => "Feedback Request",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{FEEDBACK_LINK}}"
        ];

        // General Reminder
        $template_data[] = [
            "template_id" => 18,
            "template_type" => "general_reminder",
            "template_heading" => "General Reminder",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{SERVICE_NAME}} {{DATE}} {{SUBSCRIPTION_LINK}}"
        ];
        $template_data[] = [
            "template_id" => 19,
            "template_type" => "template_testing",
            "template_heading" => "Template Testing",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}}  {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{OTP}}"
        ];
        // Refer Coupon
        $template_data[] = [
            "template_id" => 20,
            "template_type" => "ref_coupon",
            "template_heading" => "Refer Coupon",
            "email_send" => 0,
            "sms_send" => 0,
            "template_placeholder" => "{{CUSTOMER_NAME}} {{CUSTOMER_MOBILE}} {{CUSTOMER_EMAIL}} {{FIRM_NAME}} {{FIRM_LOGO_URL}} {{FIRM_EMAIL}} {{FIRM_MOBILE}} {{FIRM_ADDRESS}} {{SERVICE_NAME}} {{DATE}} {{COUPON_CODE}} {{COUPON_VALUE}} {{MAX_ORDER_VALUE}} {{MIN_ORDER_VALUE}} {{VALID_UPTO}}"
        ];
        //Template Data
        foreach ($template_data as $key => $value) {
            $data = $tm->find($value['template_id']);
            if (empty($data)) {
                $response = $tm->RecordCreate($value);
                if ($response['status'] != ApiResponseStatusCode::CREATED) {
                    print_r($response);
                    break;
                }
            }
        }
    }
}
