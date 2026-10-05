<?php

namespace App\Controllers;

use ApiResponseStatusCode;
use App\Controllers\BaseController;
use App\Traits\CommonTraits;
use CodeIgniter\HTTP\ResponseInterface;
use Razorpay\Api\Api;

class RazorpayController extends BaseController
{
    use CommonTraits;
    protected $third_party_data_array = [];
    protected $integration_data_array = [];
    public $integration_validation_errors = [];
    protected $api_key = null;
    protected $api_secret_key = null;
    protected $api;
    protected $website_profile;
    protected $razorpay_customer_id;
    protected $customer_data;
    public $is_active = false;
    public $mode = 'production';
    public $razorpay_options = [];
    public $order_data = [];
    public function __construct()
    {
        $this->website_profile = $this->getWebsiteProfileModel()->first();
        $this->third_party_data_array = $this->getThirdPartyIntegrationModel()->getIntegrationDataByType('rozorpay');
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
            if ($this->response['status'] == ApiResponseStatusCode::OK) {
                $this->api_key = $this->integration_data_array['api_key'];
                $this->api_secret_key = $this->integration_data_array['api_secret_key'];
                $this->api = new Api($this->api_key, $this->api_secret_key);
                $this->razorpay_options = [
                    'key' => $this->api_key,
                    'image' => base_url($this->website_profile['firm_logo_url']),
                    'name' => $this->website_profile['firm_name'],
                    'theme' => [
                        'color' => '#0f7369'
                    ]
                ];
            } else {
                return;
            }
        }
    }
    public function validate_integration_fields()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            "api_key" => "required",
            "api_secret_key" => "required",
        ]);

        if (!$validation->run($this->integration_data_array)) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::VALIDATION_FAILED, 'Razorpay Integration Validation Failed', [], $validation->getErrors());
        } else {
            $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'Razorpay Integration Valid');
        }
    }
    public function createCustomer($customer_id)
    {
        try {
            $cm = $this->getCustomerModel();
            $this->customer_data = $cm->find($customer_id);
            $this->razorpay_customer_id = $this->customer_data['razorpay_customer_id'] ?? null;
            if (empty($this->razorpay_customer_id)) {
                $customerData = array(
                    'name' => $this->customer_data['fullname'],
                    'contact' => $this->customer_data['mobile'],
                    'email' => $this->customer_data['email'],
                    'fail_existing' => 0,
                    'notes' => [
                        "customer_id" => $this->customer_data['customer_id']
                    ]
                );
                $customer = $this->api->customer->create($customerData);
                $customer_razorpay_data = ['razorpay_customer_id' => $customer->id];
                $cm->RecordUpdate($customer_razorpay_data, $customer_id);
                $this->razorpay_customer_id = $customer->id;
                $this->response = formatCommonResponse(ApiResponseStatusCode::CREATED, 'Customer Create successfully');
                return $this->razorpay_customer_id;
            } else {
                $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'Customer Already Exiest');
                $this->razorpay_customer_id;
            }
        } catch (\Exception $e) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
            return null;
        }
    }
    public function fetchCustomerData(string $customerId): array|null
    {
        try {
            $customer = $this->api->customer->fetch($customerId);
            $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'Customer Data Fetch');
            return $customer;
        } catch (\Exception $e) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
            return null;
        }
    }
    public function editCustomerData(string $customerId, array $data): bool|null
    {
        try {
            $customer = $this->api->customer->fetch($customerId);
            $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'Customer Edit successfully');
            $customer->edit($data);
            return true;
        } catch (\Exception $e) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, 'Customer Edit Unsuccessfully');
            return null;
        }
    }
    public function createOrder(float $amount, $receipt, array $notes = [])
    {
        // Convert rupees to paise safely
        $amountInPaise = (int) round($amount * 100);
        $this->order_data = array(
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'receipt' => (string) $receipt,
            'customer_id' => $this->razorpay_customer_id,
            'notes' => $notes
        );
        try {
            $order = $this->api->order->create($this->order_data);
            if ($order->status == 'created') {
                $this->order_data['razorpay_order_id'] = $order->id;
                $this->order_data['order_id'] = $receipt;
                $this->order_data['fullname'] = $this->customer_data['fullname'];
                $this->order_data['email'] = $this->customer_data['email'];
                $this->order_data['mobile'] = $this->customer_data['mobile'];
                $order_data = ['order_id' => $receipt, 'razorpay_order_id' => $order->id];
                $this->getOrderModel()->RecordUpdate($order_data, $receipt);
                $forFrontendPaymentRequiredData = ['razorpay_options' => $this->razorpay_options, 'order_data' => $this->order_data];
                $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'Order Create successfully');
                return $forFrontendPaymentRequiredData;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
            return null;
        }
    }
    public function createCODOrder(float $amount, $receipt, array $notes = [], array $data = [])
    {
        // 🟢 Don't convert to paise for COD
        $this->order_data = [
            'amount' => $amount, // keep as rupees
            'currency' => 'INR',
            'receipt' => (string) $receipt,
            'customer_id' => $this->razorpay_customer_id,
            'notes' => $notes,
            'payment_mode' => $data['payment_mode'],
            'order_total' => $data['order_total'],
        ];

        try {
            // Optionally: create dummy Razorpay order for tracking
            $order = $this->api->order->create([
                'amount' => $amount * 100, // Razorpay still needs paise internally
                'currency' => 'INR',
                'receipt' => (string) $receipt,
                'notes' => $notes
            ]);

            if ($order->status == 'created') {
                $this->order_data['razorpay_order_id'] = $order->id;
                $this->order_data['order_id'] = $receipt;
                $this->order_data['fullname'] = $this->customer_data['fullname'];
                $this->order_data['email'] = $this->customer_data['email'];
                $this->order_data['mobile'] = $this->customer_data['mobile'];

                // Update order table with Razorpay ID
                $update_data = [
                    'order_id' => $receipt,
                    'razorpay_order_id' => $order->id
                ];
                $this->getOrderModel()->RecordUpdate($update_data, $receipt);

                $frontendData = [
                    'razorpay_options' => $this->razorpay_options,
                    'order_data' => $this->order_data
                ];

                $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'COD Order Created Successfully');
                return $frontendData;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
            return null;
        }
    }


    public function fetchOrderData(string $orderId): array|null
    {
        try {
            $order = $this->api->order->fetch($orderId);
            $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'Fetch Order Data successfully');
            return $order->toArray();
        } catch (\Exception $e) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
            return null;
        }
    }
    public function updateOrderData(string $orderId, array $data): bool
    {
        try {
            $order = $this->api->order->fetch($orderId);
            $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'Order Update successfully');
            $order->edit($data);
            return true;
        } catch (\Exception $e) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
            return false;
        }
    }
    public function fetchPaymentByOrderId(string $orderId): array|null
    {
        try {
            $order = $this->api->order->fetch($orderId);
            $payments = $order->payments();
            $paymentData = [];

            foreach ($payments['items'] as $payment) {
                $paymentData[] = $this->api->payment->fetch($payment['id'])->toArray();
            }
            $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'Fetch Payment by OrderId');
            return $paymentData;
        } catch (\Exception $e) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
            return null;
        }
    }
    public function paymentVerify(string $paymentId, string $orderId, string $signature): bool
    {
        try {
            $attributes = array(
                'razorpay_payment_id' => $paymentId,
                'razorpay_order_id' => $orderId,
                'razorpay_signature' => $signature
            );
            $this->api->utility->verifyPaymentSignature($attributes);
            $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'Payment Verify Successfully');
            return true;
        } catch (\Exception $e) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
            return false;
        }
    }
    public function paymentNormalRefund(string $paymentId, float $amount): bool
    {
        try {
            $refund = $this->api->payment->refund($paymentId, array('amount' => $amount));

            if ($refund['status'] === 'processed') {
                $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'Payment Refund processed successfully');
                return true;
            } else {
                $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, 'Payment Refund not processed');
                return false;
            }
        } catch (\Exception $e) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
            return false;
        }
    }

    public function paymentInstantRefund(string $paymentId, float $amount): bool
    {
        try {
            $refund = $this->api->payment->refund($paymentId, array('amount' => $amount, 'speed' => 'optimum'));

            if ($refund['status'] === 'processed') {
                $this->response = formatCommonResponse(ApiResponseStatusCode::OK, 'Payment Instant refund processed successfully');
                return true;
            } else {
                $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, 'Payment Instant refund not processed');
                return false;
            }
        } catch (\Exception $e) {
            $this->response = formatCommonResponse(ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
            return false;
        }
    }

    public function createReturnRefund(
        string $razorpay_payment_id,
        float $refundAmount,
        float $returnShippingCharge
    ) {
        try {
            if ($refundAmount <= 0) {
                throw new \Exception('Invalid refund amount');
            }

            $refundAmountInPaise = (int) round($refundAmount * 100);

            $refund = $this->api->payment
                ->fetch($razorpay_payment_id)
                ->refund([
                    'amount' => $refundAmountInPaise,
                    'notes' => [
                        'reason' => 'Order Returned',
                        'return_shipping_charge' => $returnShippingCharge
                    ]
                ]);

            if (empty($refund->id)) {
                throw new \Exception('Refund creation failed');
            }

            return [
                'refund_id'     => $refund->id,
                'refund_amount' => $refundAmount,
                'status'        => $refund->status
            ];
        } catch (\Exception $e) {
            log_message('error', 'Razorpay Refund Error: ' . $e->getMessage());
            return null;
        }
    }
}
