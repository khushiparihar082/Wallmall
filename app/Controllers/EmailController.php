<?php

namespace App\Controllers;

use ApiResponseStatusCode;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Traits\CommonTraits;
use Config\Services;

class EmailController extends BaseController
{
    use CommonTraits;

    protected $third_party_data_array = [];
    protected $integration_data_array = [];
    protected $template_data_array = [];
    protected $website_profile_data = [];
    protected $recipient = '';
    protected $cc = '';
    protected $subject = '';
    protected $message = '';
    protected $attachment = '';
    protected $template_type = '';
    protected $firm_name;
    protected $firm_logo_url;
    protected $firm_email;
    protected $firm_mobile;
    protected $firm_address;
    protected $support_contact;
    public $is_active = false;
    public $mode = 'testing';
    public $response = [];

    public function __construct()
    {
        // Fetch third-party email integration data
        $this->third_party_data_array = $this->getThirdPartyIntegrationModel()->getIntegrationDataByType('email');

        // Validate email integration status
        if (empty($this->third_party_data_array) || !$this->third_party_data_array['third_party_integration_is_active']) {
            return $this->setDisabledResponse();
        }

        // Set the environment mode
        $this->is_active = true;
        $this->mode = $this->third_party_data_array['third_party_integration_is_production'] ? 'production' : 'testing';

        // Load the respective integration data
        $this->integration_data_array = $this->mode === 'production' ?
            $this->third_party_data_array['third_party_integration_production_data'] :
            $this->third_party_data_array['third_party_integration_testing_data'];

        // Validate integration data
        $this->validateIntegrationFields();
        if ($this->response['status'] == ApiResponseStatusCode::OK) {
            $this->website_profile_data =  $this->getWebsiteProfileModel()->first() ?? [];
            $this->firm_name = $this->website_profile_data['firm_name'];
            $this->firm_logo_url = base_url($this->website_profile_data['firm_logo_url']);
            $this->firm_email = $this->website_profile_data['contact_email'];
            $this->firm_mobile = $this->website_profile_data['contact_mobile'];
            $this->firm_address = $this->website_profile_data['firm_address'];
        }
    }

    private function setDisabledResponse()
    {
        $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, 'Email Integration is Disabled');
    }

    public function validateIntegrationFields()
    {
        $validation = Services::validation();
        $validation->setRules([
            'protocol' => 'required',
            'smtp_host' => 'required',
            'smtp_port' => 'required|integer',
            'sender_name' => 'required',
            'smtp_user' => 'required',
            'smtp_pass' => 'required',
            'mail_type' => 'required',
            'smtp_timeout' => 'required',
            'smtp_crypto' => 'required',
        ]);

        if (!$validation->run($this->integration_data_array)) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::VALIDATION_FAILED, 'Email Integration Validation Failed', [], $validation->getErrors());
        } else {
            $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'Email Integration Valid');
        }
    }

    private function templatePerProcess(string $template_type)
    {
        $this->template_data_array = $this->getTemplateModel()->getTemplateDataByType($template_type);
        if (empty($this->template_data_array)) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, 'Template Master Not Exist in Database');
            return;
        }

        if (!$this->template_data_array['email_send']) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, 'Email Template Send is Disabled');
            return;
        }

        $this->subject = $this->template_data_array['email_subject'];
        $this->message = $this->template_data_array['email_body'];
        $this->cc = $this->template_data_array['email_cc'];
        $this->attachment = $this->template_data_array['email_attachment'];

        $this->templateValidate();
    }

    private function templateValidate()
    {
        $validation = Services::validation();
        $validation->setRules([
            'email_subject' => 'required',
            'email_body' => 'required',
            'email_cc' => 'permit_empty|valid_email',
            'email_attachment' => 'permit_empty',
        ]);

        if (!$validation->run($this->template_data_array)) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::VALIDATION_FAILED, 'Email Template Validation Failed', [], $validation->getErrors());
        } else {
            $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'Email Template Validation Success');
        }
    }

    private function sendEmail($attachment = null): bool
    {
        $emailService = Services::email();

        $config = [
            'protocol'    => 'smtp',
            'SMTPHost'    => $this->integration_data_array['smtp_host'],
            'SMTPUser'    => $this->integration_data_array['smtp_user'],
            'SMTPPass'    => $this->integration_data_array['smtp_pass'],
            'SMTPPort'    => (int) $this->integration_data_array['smtp_port'],
            'SMTPCrypto'  => $this->integration_data_array['smtp_crypto'],
            'mailType'    => $this->integration_data_array['mail_type'],
            // 'charset'     => 'utf-8',
            // 'wordWrap'    => true
        ];

        $emailService->initialize($config);
        $emailService->setTo($this->recipient);
        $emailService->setFrom($this->integration_data_array['smtp_user'], $this->integration_data_array['sender_name']);

        if (!empty($this->cc)) {
            $emailService->setCC($this->cc);
        }

        $emailService->setSubject($this->subject);
        $emailService->setMessage($this->message);

        if (!empty($attachment)) {
            $emailService->attach($attachment);
        }

        if (!$emailService->send()) {
            $this->reset();
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, $emailService->printDebugger(['headers', 'subject', 'body']));
            return false;
        }

        $this->reset();
        return true;
    }

    private function reset()
    {
        $this->recipient = '';
        $this->subject = '';
        $this->message = '';
        $this->template_type = '';
        $this->template_data_array = [];
    }

    // Send Templates Functions -------------------------------------------------------
    public function testing($email, $fullname, $otp): bool
    {
        return $this->sendEmailWithTemplate('template_testing', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'OTP' => $otp,
        ]);
    }

    public function UserForgetPasswordSendOtp($email, $fullname, $otp): bool
    {
        return $this->sendEmailWithTemplate('forget_password', $email, [
            'CUSTOMER_NAME' => $fullname,
            'OTP' => $otp,
        ]);
    }

    public function registration_otp_send($email, $fullname, $otp): bool
    {
        return $this->sendEmailWithTemplate('registration_otp', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'OTP' => $otp,
        ]);
    }

    public function send_registration_successfully($email, $fullname): bool
    {
        return $this->sendEmailWithTemplate('registration_successfully', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
        ]);
    }

    public function forget_password_otp_send($email, $fullname, $otp): bool
    {
        return $this->sendEmailWithTemplate('forget_password', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'OTP' => $otp,
        ]);
    }

    public function login_otp_send($email, $fullname, $otp): bool
    {
        return $this->sendEmailWithTemplate('login_otp', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'OTP' => $otp,
        ]);
    }

    public function send_password_change_successfully($email, $fullname): bool
    {
        return $this->sendEmailWithTemplate('password_change_successfully', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
        ]);
    }

    public function order_confirmation_successfully($email, $fullname, $order_number, $order_date, $order_amount, $order_link): bool
    {
        return $this->sendEmailWithTemplate(
            'order_confirmation', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'ORDER_NUMBER' => $order_number,
            'ORDER_DATE' => $order_date,
            'ORDER_AMOUNT' => $order_amount,
            'ORDER_LINK' => $order_link,
            'SUPPORT_CONTACT' => $this->support_contact,
        ]);
    }

    public function order_shipped_successfully($email, $fullname, $order_number, $tracking_link, $tracking_number, $carrier_name, $estimate_delivery_date): bool
    {
        return $this->sendEmailWithTemplate('order_shipped', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'ORDER_NUMBER' => $order_number,
            'TRACKING_LINK' => $tracking_link,
            'TRACKING_NUMBER' => $tracking_number,
            'CARRIER_NAME' => $carrier_name,
            'ESTIMATE_DELIVERY_DATE' => $estimate_delivery_date,
        ]);
    }

    public function delivery_confirmation_successfully($email, $fullname, $order_number): bool
    {
        return $this->sendEmailWithTemplate('delivery_confirmation', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'ORDER_NUMBER' => $order_number,
            'SUPPORT_CONTACT' => $this->support_contact,
        ]);
    }

    public function order_cancelled_successfully($email, $fullname, $order_number): bool
    {
        return $this->sendEmailWithTemplate('order_cancelled', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'ORDER_NUMBER' => $order_number,
            'SUPPORT_CONTACT' => $this->support_contact,
        ]);
    }

    public function order_refund_processed_successfully($email, $fullname, $order_number): bool
    {
        return $this->sendEmailWithTemplate('order_refund_processed', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'ORDER_NUMBER' => $order_number,
            'SUPPORT_CONTACT' => $this->support_contact,
        ]);
    }

    public function payment_failure($email, $fullname, $order_number): bool
    {
        return $this->sendEmailWithTemplate('payment_failure', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'ORDER_NUMBER' => $order_number,
            'SUPPORT_CONTACT' => $this->support_contact,
        ]);
    }

    public function back_in_stock_notification($email, $fullname, $product_name, $product_link): bool
    {
        return $this->sendEmailWithTemplate('back_in_stock', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'PRODUCT_NAME' => $product_name,
            'PRODUCT_LINK' => $product_link,
        ]);
    }

    public function abandoned_cart_reminder($email, $fullname, $cart_link): bool
    {
        return $this->sendEmailWithTemplate('abandoned_cart_reminder', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'CART_LINK' => $cart_link,
            'SUPPORT_CONTACT' => $this->support_contact,
        ]);
    }

    public function account_registration_confirmation($email, $fullname, $login_link): bool
    {
        return $this->sendEmailWithTemplate('account_registration_confirmation', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'LOGIN_LINK' => $login_link,
            'SUPPORT_CONTACT' => $this->support_contact,
        ]);
    }

    public function password_reset_process_successfully($email, $fullname, $reset_link): bool
    {
        return $this->sendEmailWithTemplate('password_reset', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'RESET_LINK' => $reset_link,
            'SUPPORT_CONTACT' => $this->support_contact,
        ]);
    }

    public function promotional_offer_genrate($email, $fullname, $discount, $promo_code, $store_link): bool
    {
        return $this->sendEmailWithTemplate('promotional_offer', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'DISCOUNT' => $discount,
            'PROMO_CODE' => $promo_code,
            'STORE_LINK' => $store_link,
        ]);
    }

    public function feedback_request_genrate($email, $fullname, $feedback_link): bool
    {
        return $this->sendEmailWithTemplate('feedback_request', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'FEEDBACK_LINK' => $feedback_link,
        ]);
    }

    public function general_reminder($email, $fullname, $service_name, $date, $subscription_link): bool
    {
        return $this->sendEmailWithTemplate('general_reminder', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'SERVICE_NAME' => $service_name,
            'DATE' => $date,
            'SUBSCRIPTION_LINK' => $subscription_link,
        ]);
    }
    public function ref_coupon($email,$fullname,$coupon_code,$coupon_value,$min_order_value,$max_order_value,$valid_upto): bool
    {
        return $this->sendEmailWithTemplate('ref_coupon', $email, [
            'FIRM_NAME' => $this->firm_name,
            'FIRM_LOGO_URL' => $this->firm_logo_url,
            'FIRM_EMAIL' => $this->firm_email,
            'FIRM_MOBILE' => $this->firm_mobile,
            'FIRM_ADDRESS' => $this->firm_address,
            'CUSTOMER_NAME' => $fullname,
            'COUPON_CODE' =>$coupon_code,
            'COUPON_VALUE'=>$coupon_value,
            'MAX_ORDER_VALUE'=>$max_order_value,
            'MIN_ORDER_VALUE'=>$min_order_value,
            'VALID_UPTO'=>$valid_upto,

        ]);
    }

    // Helper function to send emails with templates
    private function sendEmailWithTemplate(string $template, string $email, array $placeholders): bool
    {
        $this->templatePerProcess($template);
        if ($this->response['status'] != ApiResponseStatusCode::OK) {
            return false;
        }

        // Replace placeholders in subject and message
        updatePlaceHolder($placeholders, $this->subject);
        updatePlaceHolder($placeholders, $this->message);
        $this->recipient = $email;

        // Send email
        return $this->sendEmail();
    }
}
