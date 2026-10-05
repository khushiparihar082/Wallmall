<?php

namespace App\Database\Seeds;

use ApiResponseStatusCode;
use CodeIgniter\Database\Seeder;
use App\Models\ThirdPartyIntegrationModel;

class ThirdPartyIntegrationSeeder extends Seeder
{
    public function run()
    {
        $tpim = new ThirdPartyIntegrationModel();
        $Integration_data = [];
        // Email Integration
        $Integration_data[] = [
            "third_party_integration_id" => 1,
            "third_party_integration_heading" => "Email Integration",
            "third_party_integration_type" => "email",
            "third_party_integration_image" => "email-setting.png",
            "third_party_integration_is_production" => 0,
            "third_party_integration_is_active" => 1,
        ];
        // Sms Integration
        $Integration_data[] = [
            "third_party_integration_id" => 2,
            "third_party_integration_heading" => "Sms Integration",
            "third_party_integration_type" => "sms",
            "third_party_integration_image" => "sms-setting.png",
            "third_party_integration_is_production" => 0,
            "third_party_integration_is_active" => 1,
        ];
        // Firebase Integration
        $Integration_data[] = [
            "third_party_integration_id" => 3,
            "third_party_integration_heading" => "Google Firebase Integration",
            "third_party_integration_type" => "firebase",
            "third_party_integration_image" => "firebase-setting.png",
            "third_party_integration_is_production" => 0,
            "third_party_integration_is_active" => 1,
        ];
        // Google OAuth Integration
        $Integration_data[] = [
            "third_party_integration_id" => 4,
            "third_party_integration_heading" => "Google OAuth Integration",
            "third_party_integration_type" => "googleoauth",
            "third_party_integration_image" => "googleoauth-setting.png",
            "third_party_integration_is_production" => 0,
            "third_party_integration_is_active" => 1,
        ];
        // Rozor Pay Integration
        $Integration_data[] = [
            "third_party_integration_id" => 5,
            "third_party_integration_heading" => "RozorPay Integration",
            "third_party_integration_type" => "rozorpay",
            "third_party_integration_image" => "rozorpay-setting.png",
            "third_party_integration_is_production" => 0,
            "third_party_integration_is_active" => 1,
        ];
        // ShipRocket Integration
        $Integration_data[] = [
            "third_party_integration_id" => 6,
            "third_party_integration_heading" => "ShipRocket Integration",
            "third_party_integration_type" => "shiprocket",
            "third_party_integration_image" => "shiprocket-setting.png",
            "third_party_integration_is_production" => 0,
            "third_party_integration_is_active" => 1,
        ];
        foreach ($Integration_data as $key => $value) {
            $data = $tpim->find($value['third_party_integration_id']);
            if (empty($data)) {
                $response = $tpim->RecordCreate($value);
                if ($response['status'] != ApiResponseStatusCode::CREATED) {
                    print_r($response);
                    break;
                }
            }
        }
    }
}
