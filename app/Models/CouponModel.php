<?php

namespace App\Models;

use ApiResponseStatusCode;
use App\Controllers\EmailController;
use App\Controllers\SmsController;
use App\Models\FunctionModel;

class CouponModel extends FunctionModel
{
    protected $table = 'coupon';
    protected $primaryKey = 'coupon_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'coupon_id',
        'coupon_name',
        'coupon_code',
        'min_order_value',
        'max_order_value',
        'coupon_description',
        'coupon_image',
        'coupon_image_alt',
        'coupon_type',
        'coupon_from',
        'coupon_to',
        'calculation_type',
        'coupon_value',
        'repeat_no',
        'max_use_coupon_count',
        'is_active'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;
    protected $messageAlias = "Coupon";
    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'coupon_id' => 'permit_empty',
        'coupon_name' => 'required|max_length[255]',
        'coupon_code' => 'required|alpha_numeric_space|max_length[50]|is_unique[coupon.coupon_code,coupon_id,{coupon_id}]',
        'coupon_description' => 'string|max_length[500]',
        'coupon_image' => 'permit_empty',
        'coupon_image_alt' =>  'permit_empty',
        'coupon_type' => 'required|in_list[ref_coupon,multi_customer_coupon]',
        'coupon_from' => 'permit_empty',
        'coupon_to' => 'permit_empty',
        'calculation_type' => 'in_list[amount,percentage]',
        'coupon_value' => 'required|numeric',
        'repeat_no' => 'integer',
        'min_order_value' => 'numeric',
        'max_order_value' => 'numeric',
        'max_use_coupon_count' => 'integer',
        'is_active' => 'required|in_list[0,1]'
    ];

    // Validation messages for CouponModel
    protected $validationMessages = [
        'coupon_name' => [
            'required' => 'The coupon name field is required.',
            'alpha_space' => 'The coupon name cannot contain special characters or numbers.',
            'max_length' => 'The coupon name cannot exceed 255 characters.',
        ],
        'coupon_code' => [
            'required' => 'The coupon code field is required.',
            'alpha_numeric_space' => 'The coupon code cannot contain special characters.',
            'max_length' => 'The coupon code cannot exceed 50 characters.',
            'is_unique' => 'The coupon code must be unique.',
        ],
        'coupon_description' => [
            'string' => 'The coupon description must be a string.',
            'max_length' => 'The coupon description cannot exceed 500 characters.',
        ],
        'coupon_image' => [
            'valid_url' => 'The coupon image must be a valid URL.',
        ],
        'coupon_image_alt' => [
            'string' => 'The coupon image alt text must be a string.',
            'max_length' => 'The coupon image alt text cannot exceed 255 characters.',
        ],
        'coupon_type' => [
            'required' => 'Please select a coupon type.',
            'in_list' => 'Invalid coupon type selected.',
        ],
        'coupon_from' => [
            'valid_date' => 'Please provide a valid date format for the start date.',
        ],
        'coupon_to' => [
            'valid_date' => 'Please provide a valid date format for the end date.',
        ],
        'calculation_type' => [
            'in_list' => 'Invalid calculation type selected.',
        ],
        'coupon_value' => [
            'required' => 'Please provide a coupon value.',
            'numeric' => 'The coupon value must be a numeric value.',
        ],
        'repeat_no' => [
            'integer' => 'The repeat count must be an integer.',
        ],
        'min_order_value' => [
            'integer' => 'The minimum order value must be an integer.',
        ],
        'max_order_value' => [
            'integer' => 'The maximum order value must be an integer.',
        ],
        'max_use_coupon_count' => [
            'integer' => 'The maximum use count must be an integer.',
        ],
        'is_active' => [
            'required' => 'The Is Active field is required',
        ],
   
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['validateCouponValue'];
    protected $afterInsert = [];
    protected $beforeUpdate = ['validateCouponValue'];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function __construct()
    {
        parent::__construct();
        // Add any custom initialization code if needed
    }

    // Custom validation rules
    protected function alpha_space(string $str): bool
    {
        return preg_match('/^[a-zA-Z\s]+$/', $str) === 1;
    }

    protected function alpha_numeric_space(string $str): bool
    {
        return preg_match('/^[a-zA-Z0-9\s]+$/', $str) === 1;
    }
    /**
     * Generate a refer coupon for the given customer.
     *
     * @param int $customer_id The ID of the customer.
     * @param string $refer_coupon_send_when ['after_registration', 'after_order_placed', 'after_delivered'].
     * @return bool True if coupon is created, false otherwise.
     */
    public function generateReferCoupon(int $refer_to_customer_id, string $refer_coupon_send_when): bool
    {
        // Fetch website settings related to refer coupon
        $websiteProfile = $this->getWebsiteProfileModel()
            ->select('is_refer_coupon_active,refer_coupon_send,refer_coupon_calculation_type, refer_coupon_value, refer_coupon_min_order_value, refer_coupon_max_order_value, refer_coupon_valid_days')
            ->first() ?? [];
        // Exit if refer coupon is not active
        if (empty($websiteProfile['is_refer_coupon_active'])) {
            return false;
        }
        if ($refer_coupon_send_when != $websiteProfile['refer_coupon_send']) {
            return false;
        }
        switch ($refer_coupon_send_when) {
            case 'after_registration':
                break;
            case 'after_order_placed':
                if (!$this->getOrderModel()->countAllResults() == 1) {
                    return false;
                }
                break;
            case 'after_delivered':
                if (!$this->getOrderModel()->countAllResults() == 1) {
                    return false;
                }
                break;

            default:
                # code...
                break;
        }
        // Fetch customer details
        $refer_to_customer_data = $this->getCustomerModel()
            ->where('customer_id', $refer_to_customer_id)
            ->first() ?? [];
        if (empty($refer_to_customer_data['reffer_by_id'])) {
            return false;
        }
        $customerData = $this->getCustomerModel()->find($refer_to_customer_data['reffer_by_id']);

        // Generate coupon details
        $couponCode = uniqid();
        $createdAt = date('Y-m-d H:i:s');
        $expiryDate = date('Y-m-d H:i:s', strtotime("+" . $websiteProfile['refer_coupon_valid_days'] . " days", strtotime($createdAt)));
        $couponValue = $websiteProfile['refer_coupon_value'];
        $calcType = ($websiteProfile['refer_coupon_calculation_type'] == 'percentage') ? '%' : 'Rs';
        $couponValueWithSufix = $couponValue . $calcType;
        $couponDescription = sprintf(
            "Dear %s, use your coupon code %s to get %s off on your next purchase. The coupon is valid for orders between %s and %s. Expires on %s.",
            $customerData['fullname'],
            $couponCode,
            $couponValue . $calcType,
            $websiteProfile['refer_coupon_min_order_value'],
            $websiteProfile['refer_coupon_max_order_value'],
            date('d M Y', strtotime($expiryDate))
        );
        // Prepare coupon data
        $couponData = [
            'coupon_name'        => $customerData['fullname'],
            'coupon_code'        => $couponCode,
            'coupon_description' => $couponDescription,
            'min_order_value'    => $websiteProfile['refer_coupon_min_order_value'],
            'max_order_value'    => $websiteProfile['refer_coupon_max_order_value'],
            'coupon_type'        => 'ref_coupon',
            'coupon_from'        => $createdAt,
            'coupon_to'          => $expiryDate,
            'calculation_type'   => $websiteProfile['refer_coupon_calculation_type'],
            'coupon_value'       => $websiteProfile['refer_coupon_value'],
            'repeat_no'          => 1,
            'max_use_coupon_count' => 1,
            'is_active'          => 1,
        ];

        // Insert coupon record and return status
        $result = $this->getCouponModel()->RecordCreate($couponData)['status'] === ApiResponseStatusCode::CREATED;
        if (!$result) {
            return false;
        } else {
            // Send Refer Coupon On Email
            $EC = new EmailController();
            $EC->ref_coupon($customerData['email'], $customerData['fullname'], $couponCode, $couponValueWithSufix, $websiteProfile['refer_coupon_min_order_value'], $websiteProfile['refer_coupon_max_order_value'], $expiryDate);
            // Send Refer Coupon On SMS
            $SC = new SmsController();
            $SC->ref_coupon($customerData['mobile'], $customerData['fullname'], $couponCode, $couponValueWithSufix, $websiteProfile['refer_coupon_min_order_value'], $websiteProfile['refer_coupon_max_order_value'], $expiryDate);
            return true;
        }
    }

    protected function validateCouponValue(array $data)
    {
        $type  = $data['data']['calculation_type'] ?? null;
        $value = $data['data']['coupon_value'] ?? null;

        if ($type === 'percentage' && $value > 100) {
            throw new \Exception('Coupon value cannot be greater than 100% when calculation type is percentage.');
        }

        return $data;
    }
}
