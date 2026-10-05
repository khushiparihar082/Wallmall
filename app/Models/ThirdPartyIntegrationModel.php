<?php

namespace App\Models;

use App\Models\FunctionModel;
use Exception;
use Firebase\JWT\JWT;
use RuntimeException;

class ThirdPartyIntegrationModel extends FunctionModel
{
    protected $table      = 'third_party_integration'; // Table name
    protected $primaryKey = 'third_party_integration_id'; // Primary key
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;


    protected $allowedFields = [
        'third_party_integration_id',
        'third_party_integration_heading',
        'third_party_integration_type',
        'third_party_integration_image',
        'third_party_integration_testing_data',
        'third_party_integration_production_data',
        'third_party_integration_is_production',
        'third_party_integration_is_active',
    ];
    // Validation rules
    protected $validationRules = [
        'third_party_integration_id' => 'permit_empty',
        'third_party_integration_heading' => 'required|is_unique[third_party_integration.third_party_integration_heading,third_party_integration_id,{third_party_integration_id}]|max_length[255]',
        'third_party_integration_type' => 'required|is_unique[third_party_integration.third_party_integration_type,third_party_integration_id,{third_party_integration_id}]|max_length[100]',
        'third_party_integration_image' => 'permit_empty|max_length[255]',
        'third_party_integration_is_production' => 'required',
        'third_party_integration_is_active' => 'required',
    ];

    // Validation messages
    protected $validationMessages = [
        'third_party_integration_heading' => [
            'required' => 'The integration heading is required.',
            'is_unique' => 'This integration heading already exists.',
            'max_length' => 'The heading cannot exceed 255 characters.',
        ],
        'third_party_integration_type' => [
            'required' => 'The integration type is required.',
            'is_unique' => 'This integration type already exists.',
            'max_length' => 'The integration type cannot exceed 100 characters.',
        ],
        'third_party_integration_is_production' => [
            'required' => 'The production flag is required.',
            'in_list' => 'The production flag must be either 0 (false) or 1 (true).',
        ],
        'third_party_integration_is_active' => [
            'required' => 'The active status is required.',
            'in_list' => 'The active status must be either 0 (inactive) or 1 (active).',
        ],
    ];
    protected $booleanFields = ['third_party_integration_is_production', 'third_party_integration_is_active'];
    protected $messageAlias = "Integration Setup";

    // Optional: skip validation if you need
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['updateBooleanFields', 'JwtEncodeThirdPartyInteragationData'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['updateBooleanFields', 'JwtEncodeThirdPartyInteragationData'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function __construct()
    {
        parent::__construct();
    }
    protected function JwtEncodeThirdPartyInteragationData($data)
    {
        // Retrieve JWT secret key from environment variables
        $key = $_ENV['THIRD_PARTY_INTEGRATION_JWT_SECRET_KEY'] ?? "";
        // Check if JWT secret key is set
        if (empty($key)) {
            throw new RuntimeException('THIRD_PARTY_INTEGRATION_JWT_SECRET_KEY not set in ENV');
        }

        // Algorithm for JWT token
        $algorithm = 'HS256';
        if (isset($data['data']['third_party_integration_testing_data'])) {
            try {
                // Generate JWT token
                $token = JWT::encode($data['data']['third_party_integration_testing_data'] ?? [], $key, $algorithm);
                $data['data']['third_party_integration_testing_data'] = $token;
            } catch (Exception $e) {
                // Handle token generation error
                throw new RuntimeException('Error generating JWT token: ' . $e->getMessage());
            }
        }
        if (isset($data['data']['third_party_integration_production_data'])) {
            try {
                // Generate JWT token
                $token = JWT::encode($data['data']['third_party_integration_production_data'] ?? [], $key, $algorithm);
                $data['data']['third_party_integration_production_data'] = $token;
            } catch (Exception $e) {
                // Handle token generation error
                throw new RuntimeException('Error generating JWT token: ' . $e->getMessage());
            }
        }
        return $data;
    }
    public function getIntegrationDataByType(string $third_party_integration_type): array
    {
        $data = $this->where('third_party_integration_type', $third_party_integration_type)->first();
        $data['third_party_integration_testing_data'] = checkJwtTokenDecode($data['third_party_integration_testing_data'], $_ENV['THIRD_PARTY_INTEGRATION_JWT_SECRET_KEY']) ?? [];
        $data['third_party_integration_production_data'] = checkJwtTokenDecode($data['third_party_integration_production_data'], $_ENV['THIRD_PARTY_INTEGRATION_JWT_SECRET_KEY']) ?? [];
        return $data;
    }
    public function getEmailIntegrationFileds()
    {
        return [
            [
                "field_name" => "protocol",
                "field_title" => "",
                "field_label" => "Protocol",
                "field_type" => "select",
                "field_validation" => "required",
                "field_default_value" => "smtp",
                "field_value" => null,
                "field_options" => ['smtp' => 'SMTP', 'mail' => 'MAIL', 'sendmail' => 'SEND MAIL'],
            ],
            [
                "field_name" => "smtp_host",
                "field_title" => "",
                "field_label" => "SMTP Host",
                "field_type" => "text",
                "field_validation" => "required",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "smtp_port",
                "field_title" => "",
                "field_label" => "SMTP Port",
                "field_type" => "number",
                "field_validation" => "required|numeric",
                "field_default_value" => "587",
                "field_value" => null,
            ],
            [
                "field_name" => "sender_name",
                "field_title" => "Sender Name",
                "field_label" => "Sender Name",
                "field_type" => "text",
                "field_validation" => "required",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "smtp_user",
                "field_title" => "",
                "field_label" => "SMTP Username",
                "field_type" => "text",
                "field_validation" => "required",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "smtp_pass",
                "field_title" => "",
                "field_label" => "SMTP Password",
                "field_type" => "password",
                "field_validation" => "required",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "mail_type",
                "field_title" => "",
                "field_label" => "Mail Type",
                "field_type" => "select",
                "field_validation" => "required",
                "field_default_value" => "html",
                "field_value" => null,
                "field_options" => ['html' => 'HTML', 'text' => 'Plain Text'],
            ],
            [
                "field_name" => "smtp_timeout",
                "field_title" => "",
                "field_label" => "SMTP Timeout (in seconds)",
                "field_type" => "number",
                "field_validation" => "required|numeric",
                "field_default_value" => 5,
                "field_value" => null,
            ],
            [
                "field_name" => "smtp_crypto",
                "field_title" => "",
                "field_label" => "SMTP Encryption",
                "field_type" => "select",
                "field_validation" => "required",
                "field_default_value" => "tls",
                "field_value" => null,
                "field_options" => ['' => 'None', 'tls' => 'TLS', 'ssl' => 'SSL'],
            ],
        ];
    }
    public function getRozorpayIntegrationFileds()
    {
        return [
            [
                "field_name" => "api_key",
                "field_title" => "",
                "field_label" => "Api Key",
                "field_type" => "text",
                "field_validation" => "required",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "api_secret_key",
                "field_title" => "",
                "field_label" => "Api Secret Key",
                "field_type" => "password",
                "field_validation" => "required",
                "field_default_value" => "",
                "field_value" => null,
            ],
        ];
    }
    public function getSmsIntegrationFileds()
    {
        return [
            [
                "field_name" => "send_sms_url",
                "field_title" => "
                Placeholders:{{api_key}},{{username}},{{password}},{{sendername}},{{smstype}},{{peid}},{{templateid}},{{message}},{{numbers}}
                Sample Url:http://sms.messageindia.in/v2/sendSMS?username={{username}}&message={{message}}&sendername={{sendername}}&smstype={{smstype}}&numbers={{numbers}}&apikey={{api_key}}&peid={{peid}}&templateid={{templateid}}
                ",
                "field_label" => "Send Sms Url",
                "field_type" => "text",
                "field_validation" => "required",
                "field_default_value" => "http://sms.messageindia.in/v2/sendSMS?username={{username}}&message={{message}}&sendername={{sendername}}&smstype={{smstype}}&numbers={{numbers}}&apikey={{api_key}}&peid={{peid}}&templateid={{templateid}}",
                "field_value" => null,
            ],
            [
                "field_name" => "api_key",
                "field_title" => "",
                "field_label" => "Api Key",
                "field_type" => "text",
                "field_validation" => "",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "username",
                "field_title" => "",
                "field_label" => "Username",
                "field_type" => "text",
                "field_validation" => "",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "password",
                "field_title" => "",
                "field_label" => "Password",
                "field_type" => "password",
                "field_validation" => "",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "sendername",
                "field_title" => "",
                "field_label" => "Sender Name",
                "field_type" => "text",
                "field_validation" => "",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "smstype",
                "field_title" => "",
                "field_label" => "SMS TYPE",
                "field_type" => "text",
                "field_validation" => "required",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "peid",
                "field_title" => "",
                "field_label" => "DLT PEID",
                "field_type" => "text",
                "field_validation" => "required",
                "field_default_value" => "",
                "field_value" => null,
            ],
        ];
    }
    public function getFirebaseIntegrationFileds()
    {
        return [
            [
                "field_name" => "firebase_project_number",
                "field_title" => "Project Setting -> General -> Project Number",
                "field_label" => "Project number",
                "field_type" => "text",
                "field_validation" => "required",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "firebase_web_api_key",
                "field_title" => "Project Setting -> General -> Web API key",
                "field_label" => "Web API key",
                "field_type" => "text",
                "field_validation" => "required",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "firebase_app_id",
                "field_title" => "Project Setting -> General -> Your Apps -> App ID",
                "field_label" => "App ID",
                "field_type" => "text",
                "field_validation" => "required",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "firebase_config",
                "field_title" => "Project Setting -> General -> Your Apps -> SDK setup and configuration -> Config",
                "field_label" => "Firebase Config (JSON) Object",
                "field_type" => "textarea",
                "field_validation" => "required rows='5'",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "firebase_sender_id",
                "field_title" => "Project Setting -> Cloud Messaging -> Firebase Cloud Messaging API (V1) -> Sender ID",
                "field_label" => "Firebase Cloud Messaging API (V1) Sender ID",
                "field_type" => "text",
                "field_validation" => "required",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "firebase_web_push_certificate_key_pair",
                "field_title" => "Project Setting -> Cloud Messaging -> Web configuration -> Web Push certificates",
                "field_label" => "Web Push certificates Key pair",
                "field_type" => "text",
                "field_validation" => "required",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "firebase_web_push_certificate_private_key",
                "field_title" => "Project Setting -> Cloud Messaging -> Web configuration -> Web Push certificates -> Private key",
                "field_label" => "Web Push certificates Private Key",
                "field_type" => "text",
                "field_validation" => "required",
                "field_default_value" => "",
                "field_value" => null,
            ],
            [
                "field_name" => "firebase_service_account_private_key",
                "field_title" => "Project Setting -> Cloud Messaging -> Web configuration -> Web Push certificates -> Private key",
                "field_label" => "Service Account Private Key (JSON) Object",
                "field_type" => "textarea",
                "field_validation" => "required rows='5'",
                "field_default_value" => "",
                "field_value" => null,
            ],
        ];
    }
    // public function getGoogleoauthIntegrationFileds()
    // {
    //     return [
    //         [
    //             "field_name" => "api_key",
    //             "field_title" => "",
    //             "field_label" => "Api Key",
    //             "field_type" => "text",
    //             "field_validation" => "required",
    //             "field_default_value" => "",
    //             "field_value" => null,
    //         ],
    //         [
    //             "field_name" => "api_secret_key",
    //             "field_title" => "",
    //             "field_label" => "Api Secret Key",
    //             "field_type" => "password",
    //             "field_validation" => "required",
    //             "field_default_value" => "",
    //             "field_value" => null,
    //         ],
    //     ];
    // }
}
