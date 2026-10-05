<?php

namespace App\Controllers;

use ApiResponseStatusCode;
use App\Controllers\BaseController;
use App\Traits\CommonTraits;
use CodeIgniter\HTTP\ResponseInterface;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Config\Services;

class FirebaseController extends BaseController
{
    use CommonTraits;

    protected $third_party_data_array = [];
    protected $integration_data_array = [];
    protected $firm_name = 'TheHillMen';
    protected $support_contact = 'TheHillMen';
    public $is_active = false;
    public $mode = 'production';
    public $response = [];
    protected $service_account_credentials;
    protected $acces_tokken;
    protected $firebase_message_send_url;
    protected $headers = [];
    protected $website_profile_data = [];
    protected $firm_logo_url;
    protected $firm_email;
    protected $firm_mobile;
    protected $firm_address;

    public function __construct()
    {

        // Fetch third-party Firebase integration data
        $this->third_party_data_array = $this->getThirdPartyIntegrationModel()->getIntegrationDataByType('firebase');

        // Validate Firebase integration status
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
            if ($this->response['status'] == ApiResponseStatusCode::OK) {
                $this->website_profile_data =  $this->getWebsiteProfileModel()->first() ?? [];
                $this->firm_name = $this->website_profile_data['firm_name'];
                $this->firm_logo_url = base_url($this->website_profile_data['firm_logo_url']);
                $this->firm_email = $this->website_profile_data['contact_email'];
                $this->firm_mobile = $this->website_profile_data['contact_mobile'];
                $this->firm_address = $this->website_profile_data['firm_address'];
            }
            $this->service_account_credentials = new ServiceAccountCredentials('https://www.googleapis.com/auth/firebase.messaging', json_decode($this->integration_data_array['firebase_service_account_private_key'], true));
            $tokken = $this->service_account_credentials->fetchAuthToken(HttpHandlerFactory::build());
            if (isset($tokken['access_token'])) {
                $this->acces_tokken = $tokken['access_token'];
            } else {
                $this->response = formatCommonResponse(ApiResponseStatusCode::INTERNAL_SERVER_ERROR, 'Failed to fetch Firebase access token');
                $this->is_active = false;
                return;
            }
            $this->firebase_message_send_url = "https://fcm.googleapis.com/v1/projects/" . $this->integration_data_array['firebase_project_number'] . "/messages:send";

            $this->headers = [
                'Authorization' => 'Bearer ' . $this->acces_tokken,
                'Content-Type' => 'application/json'
            ];
        }
    }

    private function setDisabledResponse()
    {
        $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, 'Firebase Integration is Disabled');
    }
    public function validateIntegrationFields()
    {
        $validation = Services::validation();
        $validation->setRules([
            'firebase_project_number' => 'required',
            'firebase_web_api_key' => 'required',
            'firebase_app_id' => 'required',
            'firebase_config' => 'required',
            'firebase_sender_id' => 'required',
            'firebase_web_push_certificate_key_pair' => 'required',
            'firebase_web_push_certificate_private_key' => 'required',
            'firebase_service_account_private_key' => 'required',
        ]);

        if (!$validation->run($this->integration_data_array)) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::VALIDATION_FAILED, 'Firebase Integration Validation Failed', [], $validation->getErrors());
        } else {
            $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'Firebase Integration Valid');
        }
    }
    public function getFrontendIntregationData()
    {
        return [
            'firebase_config' => $this->integration_data_array['firebase_config'],
            'firebase_web_push_certificate_key_pair' => $this->integration_data_array['firebase_web_push_certificate_key_pair']
        ] ?? [];
    }
    public function sendNotification(string $token, string $title, string $body, string $redirect_url, string $image_url = null,  array $data = []): bool
    {
        $image_url = (empty($image_url)) ? $this->firm_logo_url : $image_url;
        if (!$this->is_active) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, 'Firebase Integration is Disabled');
            return false;
        }

        $message = [];
        $message['message']['token'] = $token;
        $message['message']['webpush']['fcm_options']['link'] = $redirect_url;
        $message['message']['notification']['title'] = $title;
        $message['message']['notification']['body'] = $body;
        $message['message']['notification']['image'] = $image_url ?? "";
        $message['message']['data'] = $data;
        $message['message']['data']['title'] = $title ?? "";
        $message['message']['data']['body'] = $body ?? "";
        $message['message']['data']['url'] = $redirect_url ?? "";
        $message['message']['data']['image'] = $image_url ?? "";

        $response = curlApiRequest($this->firebase_message_send_url, 'POST', $message, $this->headers);
        if (isset($response['status']) && $response['status'] === ApiResponseStatusCode::OK) {
            $this->response =  formatCommonResponse(ApiResponseStatusCode::OK, 'Notification sent successfully');
            return true;
        } else {
            $errorMessage = 'Failed to send notification';
            $errors = isset($response['errors']) ? $response['errors'] : [];

            if (isset($response['message'])) {
                $errorMessage = $response['message'];
            }

            $this->response = formatCommonResponse(ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $errorMessage, [], $errors);
            return true;
        }
    }
    // Add User Token Api
    public function addUserTokenFirebase()
    {
        $data = getRequestData($this->request, 'ARRAY');
        $data['user_id'] = $_SESSION['user_id'] ?? null;
        $validation = Services::validation();
        $validation->setRules([
            'user_id' => 'required',
            'token' => 'required',
        ]);
        if (!$validation->run($data)) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
        }
        $fmtm = $this->getFirebaseMessagingTokenModel();
        $fmt_data = [
            'access_type' => 'user',
            'access_id' => $data['user_id'],
            'token' => $data['token']
        ];
        if (empty($fmtm->where('token', $data['token'])->first())) {
            $fmtm->insert($fmt_data);
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Token Added Successfully');
        } else {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Token Already Exiest');
        }
    }
    // Add Customer Token Api
    public function addCustomerTokenFirebase()
    {
        $data = getRequestData($this->request, 'ARRAY');
        $data['customer_id'] = $_SESSION['customer_id'] ?? null;
        $validation = Services::validation();
        $validation->setRules([
            'customer_id' => 'required',
            'token' => 'required',
        ]);
        if (!$validation->run($data)) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
        }
        $fmtm = $this->getFirebaseMessagingTokenModel();

        $fmt_data = [
            'access_type' => 'customer',
            'access_id'   => $data['customer_id'],
            'token'       => $data['token']
        ];

        $exists = $fmtm
            ->where('token', $data['token'])
            ->countAllResults(true); // builder reset

        if ($exists === 0) {

            $fmtm->insert($fmt_data);

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Token Added Successfully'
            );
        }

        return formatApiResponse(
            $this->request,
            $this->response,
            ApiResponseStatusCode::OK,
            'Token Already Exist'
        );
    }
    // Send Notification To User Function
    public function sendNotificationToUser($user_id, string $title, string $body, string $redirect_url, string $image_url = null,  array $data = []): bool
    {
        $fmtm = $this->getFirebaseMessagingTokenModel();
        $tokens = $fmtm
            ->where('access_type', 'user')
            ->where('access_id', $user_id)
            ->findAll();

        if (empty($tokens)) {
            log_message('error', "No FCM token found for user_id: {$user_id}");
            return false;
        }

        $notificationModel = $this->getFirebaseMessagingNotificationModel();
        $sentSuccessfully = false;

        foreach ($tokens as $tokenRow) {

            $result = $this->sendNotification(
                $tokenRow['token'],
                $title,
                $body,
                $redirect_url,
                $image_url,
                $data
            );

            // ✅ If notification sent successfully
            if ($result === true) {

                $sentSuccessfully = true;

                // 🔥 INSERT INTO firebase_messaging_notification TABLE
                $notificationModel->insert([
                    'access_type' => 'user',
                    'access_id'   => $user_id,
                    'title'       => $title,
                    'image'       => $image_url,
                    'body'        => $body,
                    'url'         => $redirect_url,
                ]);
            } else {
                log_message(
                    'error',
                    'Firebase user notification failed for token: ' . $tokenRow['token']
                );
            }
        }

        return $sentSuccessfully;
    }
    // Sned Notification to Customer Function
    public function sendNotificationToCustomer(
        $customer_id,
        string $title,
        string $body,
        string $redirect_url,
        string $image_url = null,
        array $data = []
    ): bool {

        $fmtm = $this->getFirebaseMessagingTokenModel();
        $notificationModel = $this->getFirebaseMessagingNotificationModel();

        // 1️⃣ Get customer tokens
        $fmt_data = $fmtm
            ->where('access_type', 'customer')
            ->where('access_id', $customer_id)
            ->findAll();

        if (empty($fmt_data)) {
            $this->response = formatCommonResponse(
                ApiResponseStatusCode::BAD_REQUEST,
                'Token Not Found To Send Message'
            );
            return false;
        }

        $sentSuccessfully = false;

        // 2️⃣ Send notification to all tokens
        foreach ($fmt_data as $value) {

            $result = $this->sendNotification(
                $value['token'],
                $title,
                $body,
                $redirect_url,
                $image_url,
                $data
            );

            if ($result === true) {
                $sentSuccessfully = true;
            }
        }

        // 3️⃣ Save notification only if at least one send was successful
        if ($sentSuccessfully) {

            $notificationModel->insert([
                'access_type' => 'customer',
                'access_id'   => $customer_id,
                'title'       => $title,
                'body'        => $body,
                'image'       => $image_url ?? '',
                'url'         => $redirect_url,
                'created_at'  => date('Y-m-d H:i:s')
            ]);

            return true;
        }

        return false;
    }
}
