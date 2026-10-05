<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Traits\CommonTraits;
use CodeIgniter\HTTP\ResponseInterface;

class OAuthController extends BaseController
{
    use CommonTraits;
    protected $third_party_data_array = [];
    protected $integration_data_array = [];
    public $is_active = false;
    public $mode = 'testing';
    public $integration_validation_errors = [];
    public function __construct()
    {
        $this->third_party_data_array = $this->getThirdPartyIntegrationModel()->getIntegrationDataByType('email');
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
            // "customer_id" => "required",
            // "customer_cart_ids" => "required"
        ]);

        // Run validation
        if (!$validation->run($this->integration_data_array)) {
            $this->integration_validation_errors = $validation->getErrors();
        }
    }
    public function index() {}
}
