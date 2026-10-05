<?php

namespace App\Controllers;

use ApiResponseStatusCode;
use App\Controllers\BaseController;
use App\Traits\CommonTraits;
use Config\Services;

class SmsController extends BaseController
{
    use CommonTraits;

    protected $third_party_data_array = [];
    protected $integration_data_array = [];
    protected $template_data_array = [];
    protected $dlt_id = '';
    protected $sms_message = '';
    protected $numbers = '';
    protected $template_type = '';
    protected $website_profile_data = [];
    protected $recipient = '';
    protected $cc = '';
    protected $subject = '';
    protected $message = '';
    protected $attachment = '';
    protected $firm_name;
    protected $firm_logo_url;
    protected $firm_email;
    protected $firm_mobile;
    protected $firm_address;
    protected $support_contact;
    public $is_active = false;
    public $mode = 'testing';
    public $integration_validation_errors = [];
    public $response = [];


    public function __construct()
    {
        $this->third_party_data_array = $this->getThirdPartyIntegrationModel()->getIntegrationDataByType('sms');
        if (!empty($this->third_party_data_array) && $this->third_party_data_array['third_party_integration_is_active']) {
            $this->is_active = true;
            if ($this->third_party_data_array['third_party_integration_is_production']) {
                $this->mode = 'production';
            }
            switch ($this->mode) {
                case 'testing':
                    $this->integration_data_array = $this->third_party_data_array['third_party_integration_testing_data'];
                    break;
                case 'production':
                    $this->integration_data_array = $this->third_party_data_array['third_party_integration_production_data'];
                    break;
            }
            $this->validate_integration_fields();
        }
    }

    public function validate_integration_fields()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'send_sms_url' => 'required',
            'api_key' => 'required',
            'username' => 'required',
            'password' => 'required',
            'sendername' => 'required',
            'smstype' => 'required',
            'peid' => 'required',
        ]);

        if (!$validation->run($this->integration_data_array)) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::VALIDATION_FAILED, 'SMS Integration Validation Failed', [], $validation->getErrors());
        } else {
            $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'SMS Integration Valid');
        }
    }

    private function templatePerProcess(string $template_type)
    {
        $this->template_data_array = $this->getTemplateModel()->getTemplateDataByType($template_type);
        if (empty($this->template_data_array)) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, 'Template Master Not Exist in Database');
            return;
        }

        if (!$this->template_data_array['sms_send']) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, 'Sms Template Send is Disabled');
            return;
        }
        $this->template_type = $this->template_data_array['template_type'];
        $this->dlt_id = $this->template_data_array['sms_dlt_id'];
        $this->sms_message = $this->template_data_array['sms_message'];

        $this->templateValidate();
    }

    private function templateValidate()
    {
        $validation = Services::validation();
        $validation->setRules([
            'template_type' => 'required',
            'sms_dlt_id' => 'required',
            'sms_message' => 'required',
        ]);

        if (!$validation->run($this->template_data_array)) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::VALIDATION_FAILED, 'SMS Template Validation Failed', [], $validation->getErrors());
        } else {
            $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'SMS Template Validation Success');
        }
    }

    private function sendSMS(): bool
    {
        $place_holders = [
            "api_key" => htmlspecialchars($this->integration_data_array['api_key']),
            "username" => htmlspecialchars($this->integration_data_array['username']),
            "password" => htmlspecialchars($this->integration_data_array['password']),
            "sendername" => htmlspecialchars($this->integration_data_array['sendername']),
            "smstype" => htmlspecialchars($this->integration_data_array['smstype']),
            "peid" => htmlspecialchars($this->integration_data_array['peid']),
            "templateid" => htmlspecialchars($this->dlt_id),
            "message" => htmlspecialchars($this->sms_message),
            "numbers" => htmlspecialchars($this->numbers),
        ];
        updatePlaceHolder($place_holders, $this->integration_data_array['send_sms_url']);
        $parseData = extractUrlComponents($this->integration_data_array['send_sms_url']);
        $domain = $parseData['domain'];
        $path = $parseData['path'];
        $response = curlApiRequest($domain . $path, 'GET', $parseData['parameters']);

        $this->reset();
        return true;
    }

    private function reset()
    {
        $this->dlt_id = '';
        $this->sms_message = '';
        $this->template_type = '';
    }

    // SMS sending methods with templates
    public function sendSmsWithTemplate(string $template, $numbers, array $placeholders): bool
    {
        $this->numbers = $numbers;
        $this->templatePerProcess($template);

        // Check if the template was processed successfully
        if ($this->response['status'] != ApiResponseStatusCode::OK) {
            return false;
        }

        // Replace placeholders in the SMS message
        updatePlaceHolder($placeholders, $this->sms_message); // Assuming this method replaces the placeholders

        // Send the SMS
        return $this->sendSMS();
    }


    // Send Templates Functions -------------------------------------------------------
    public function testing($numbers, $fullname, $otp): bool
    {
        return $this->sendSmsWithTemplate('template_testing', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'OTP' => $otp,
        ]);
    }

    public function UserForgetPasswordSendOtp($numbers, $fullname, $otp): bool
    {
        return $this->sendSmsWithTemplate('forget_password', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'OTP' => $otp,
        ]);
    }

    public function registration_otp_send($numbers, $fullname, $otp): bool
    {
        return $this->sendSmsWithTemplate('registration_otp', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'OTP' => $otp,
        ]);
    }

    public function send_registration_successfully($numbers, $fullname): bool
    {
        return $this->sendSmsWithTemplate('registration_successfully', $numbers, [
            'CUSTOMER_NAME' => $fullname,
        ]);
    }

    public function forget_password_otp_send($numbers, $fullname, $otp): bool
    {
        return $this->sendSmsWithTemplate('forget_password', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'OTP' => $otp,
        ]);
    }

    public function login_otp_send($numbers, $fullname, $otp): bool
    {
        return $this->sendSmsWithTemplate('login_otp', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'OTP' => $otp,
        ]);
    }

    public function send_password_change_successfully($numbers, $fullname): bool
    {
        return $this->sendSmsWithTemplate('password_change_successfully', $numbers, [
            'CUSTOMER_NAME' => $fullname,
        ]);
    }

    public function order_confirmation_successfully($numbers, $fullname, $order_number, $order_date, $order_amount, $order_link): bool
    {
        return $this->sendSmsWithTemplate('order_confirmation', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'ORDER_NUMBER' => $order_number,
            'ORDER_DATE' => $order_date,
            'ORDER_AMOUNT' => $order_amount,
            'ORDER_LINK' => $order_link,
        ]);
    }

    public function order_shipped_successfully($numbers, $fullname, $order_number, $tracking_link, $tracking_number, $carrier_name, $estimate_delivery_date): bool
    {
        return $this->sendSmsWithTemplate('order_shipped', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'ORDER_NUMBER' => $order_number,
            'TRACKING_LINK' => $tracking_link,
            'TRACKING_NUMBER' => $tracking_number,
            'CARRIER_NAME' => $carrier_name,
            'ESTIMATE_DELIVERY_DATE' => $estimate_delivery_date,
        ]);
    }

    public function delivery_confirmation_successfully($numbers, $fullname, $order_number): bool
    {
        return $this->sendSmsWithTemplate('delivery_confirmation', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'ORDER_NUMBER' => $order_number,
        ]);
    }

    public function order_cancelled_successfully($numbers, $fullname, $order_number): bool
    {
        return $this->sendSmsWithTemplate('order_cancelled', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'ORDER_NUMBER' => $order_number,
        ]);
    }

    public function order_refund_processed_successfully($numbers, $fullname, $order_number): bool
    {
        return $this->sendSmsWithTemplate('order_refund_processed', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'ORDER_NUMBER' => $order_number,
        ]);
    }

    public function payment_failure($numbers, $fullname, $order_number): bool
    {
        return $this->sendSmsWithTemplate('payment_failure', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'ORDER_NUMBER' => $order_number,
        ]);
    }

    public function back_in_stock_notification($numbers, $fullname, $product_name, $product_link): bool
    {
        return $this->sendSmsWithTemplate('back_in_stock', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'PRODUCT_NAME' => $product_name,
            'PRODUCT_LINK' => $product_link,
        ]);
    }

    public function abandoned_cart_reminder($numbers, $fullname, $cart_link): bool
    {
        return $this->sendSmsWithTemplate('abandoned_cart_reminder', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'CART_LINK' => $cart_link,
        ]);
    }

    public function account_registration_confirmation($numbers, $fullname, $login_link): bool
    {
        return $this->sendSmsWithTemplate('account_registration_confirmation', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'LOGIN_LINK' => $login_link,
        ]);
    }

    public function password_reset_process_successfully($numbers, $fullname, $reset_link): bool
    {
        return $this->sendSmsWithTemplate('password_reset', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'RESET_LINK' => $reset_link,
        ]);
    }

    public function promotional_offer_genrate($numbers, $fullname, $discount, $promo_code, $store_link): bool
    {
        return $this->sendSmsWithTemplate('promotional_offer', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'DISCOUNT' => $discount,
            'PROMO_CODE' => $promo_code,
            'STORE_LINK' => $store_link,
        ]);
    }

    public function feedback_request_genrate($numbers, $fullname, $feedback_link): bool
    {
        return $this->sendSmsWithTemplate('feedback_request', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'FEEDBACK_LINK' => $feedback_link,
        ]);
    }

    public function general_reminder($numbers, $fullname, $service_name, $date, $subscription_link): bool
    {
        return $this->sendSmsWithTemplate('general_reminder', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'SERVICE_NAME' => $service_name,
            'DATE' => $date,
            'SUBSCRIPTION_LINK' => $subscription_link,
        ]);
    }
    public function ref_coupon($numbers, $fullname, $coupon_code, $coupon_value, $min_order_value, $max_order_value, $valid_upto): bool
    {
        return $this->sendSmsWithTemplate('ref_coupon', $numbers, [
            'CUSTOMER_NAME' => $fullname,
            'COUPON_CODE' => $coupon_code,
            'COUPON_VALUE' => $coupon_value,
            'MAX_ORDER_VALUE' => $max_order_value,
            'MIN_ORDER_VALUE' => $min_order_value,
            'VALID_UPTO' => $valid_upto,
        ]);
    }
}
