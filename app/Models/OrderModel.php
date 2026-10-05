<?php

namespace App\Models;

use ApiResponseStatusCode;
use App\Models\FunctionModel;
use InvalidArgumentException;

class OrderModel extends FunctionModel
{
    protected $table      = 'order';
    protected $primaryKey = 'order_id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $messageAlias = "Order";
    protected $allowedFields = [
        'order_id',
        'razorpay_order_id',
        'order_number',
        'order_date',
        'customer_id',
        'purchase_total',
        'mrp_total',
        'variant_dis_total',
        'offer_total_dis',
        'order_coupon_code',
        'coupon_calc_type',
        'coupon_value',
        'coupon_dis_total',
        'shipping_charges_total',
        'roundoff_total',
        'order_total',
        'gst_total',
        'taxable_total',
        'order_remark',
        'order_status',
        'docket_number',
        'order_shipping_company_name',
        'order_delivery_expected_date',
        'order_delivered_date',
        'return_docker_number',
        'return_shipping_company_name',
        'return_delivery_expected_date',
        'return_delivered_date',
        'order_payment_id',
        'payment_mode',
        'billing_address',
        'billing_country_id',
        'billing_state_id',
        'billing_city_id',
        'billing_pincode',
        'receiver_name',
        'receiver_mobile',
        'refund_transaction_id',
        'total_refund_amount',
        'cod_charges_total',
        'remaining_total',
        'order_return_exchange_days',
        'is_order_patner_request',
        'wallet_used_amount',
        'delhivery_waybill',
        'return_shipping_charge',
        'is_return_shipping_charge_agree',
        'status_action_date',
        'status_action_id'
    ];

    // Validation rules
    protected $validationRules = [
        'order_id' => 'permit_empty',
        'razorpay_order_id' => 'permit_empty',
        'refund_transaction_id' => 'permit_empty',
        'total_refund_amount' => 'permit_empty',
        'order_number' => 'permit_empty|string|max_length[255]',
        'order_date' => 'required|valid_date',
        'customer_id' => 'required|integer|is_not_unique[customer.customer_id]',
        'order_payment_id' => 'permit_empty|is_not_unique[order_payment.order_payment_id]',
        'purchase_total' => 'required|decimal',
        'mrp_total' => 'required',
        'variant_dis_total' => 'permit_empty|decimal',
        'offer_total_dis' => 'permit_empty|decimal',
        'order_coupon_code' => 'permit_empty|string|max_length[255]',
        'coupon_calc_type' => 'permit_empty|string|max_length[255]',
        'coupon_value' => 'permit_empty|decimal',
        'coupon_dis_total' => 'permit_empty|decimal',
        'shipping_charges_total' => 'permit_empty|decimal',
        'roundoff_total' => 'permit_empty|decimal',
        'order_total' => 'required|decimal',
        'gst_total' => 'permit_empty|decimal',
        'taxable_total' => 'permit_empty|decimal',
        'order_remark' => 'permit_empty|string',
        'order_status' => 'required|in_list[order_payment_pending,order_payment_processing,order_payment_success,order_payment_fail,order_payment_verified_manual,order_payment_verified_razorpay,order_accepted,order_ready_to_ship,order_shipped,order_exchange_shipped,order_delivered,order_not_delivered,order_exchanged,refund_request,return_request,exchange_request,request_return_rejected,request_exchange_rejected,request_refund_approved,request_return_approved,request_exchange_approved,refund_to_customer,]',
        'docket_number' => 'permit_empty|string|max_length[255]',
        'order_shipping_company_name'   => 'permit_empty',
        'order_delivery_expected_date' => 'permit_empty',
        'order_delivered_date' => 'permit_empty',
        'return_docker_number' => 'permit_empty',
        'return_shipping_company_name' => 'permit_empty',
        'return_delivery_expected_date' => 'permit_empty',
        'return_delivered_date' => 'permit_empty',
        'payment_mode' => 'required|string|max_length[255]',
        'billing_address' => 'required|string',
        'billing_country_id' => 'required|integer|is_not_unique[country.country_id]',
        'billing_state_id' => 'required|integer|is_not_unique[state.state_id]',
        'billing_city_id' => 'required|integer|is_not_unique[city.city_id]',
        'billing_pincode' => 'required|string|max_length[255]',
        'receiver_name' => 'required|string|max_length[255]',
        'receiver_mobile' => 'required|string|max_length[255]',
        'cod_charges_total' => 'permit_empty',
        'remaining_total' => 'permit_empty',
        'order_return_exchange_days' => 'permit_empty|integer',
        'is_order_patner_request' => 'permit_empty',
        'wallet_used_amount' => 'permit_empty',
        'delhivery_waybill' => 'permit_empty',
        'return_shipping_charge' => 'permit_empty',
        'is_return_shipping_charge_agree' => 'permit_empty',
        'status_action_date' => 'permit_empty',
        'status_action_id' => 'permit_empty',
    ];

    // Custom validation messages
    protected $validationMessages = [
        'order_date' => [
            'required' => 'Order date is required.',
            'valid_date' => 'Please provide a valid date for the order.'
        ],
        'customer_id' => [
            'required' => 'Customer ID is required.',
            'integer' => 'Customer ID must be an integer.',
            'is_not_unique' => 'The customer ID does not exist in the customer table.'
        ],
        'order_payment_id' => [
            'required' => 'Order Payment ID is required.',
            'integer' => 'Order Payment ID must be an integer.',
            'is_not_unique' => 'The order payment ID does not exist in the order payment table.'
        ],
        'purchase_total' => [
            'required' => 'Purchase total is required.',
            'decimal' => 'Purchase total must be a decimal value.'
        ],
        'mrp_total' => [
            'required' => 'MRP total is required.',
            'decimal' => 'MRP total must be a decimal value.'
        ],
        'order_total' => [
            'required' => 'Order total is required.',
            'decimal' => 'Order total must be a decimal value.'
        ],
        'order_status' => [
            'required' => 'Order status is required.',
            'string' => 'Order status must be a string.',
            'max_length' => 'Order status cannot exceed 255 characters.'
        ],
        'payment_mode' => [
            'required' => 'Payment mode is required.',
            'string' => 'Payment mode must be a string.',
            'max_length' => 'Payment mode cannot exceed 255 characters.'
        ],
        'billing_address' => [
            'required' => 'Billing address is required.',
            'string' => 'Billing address must be a string.'
        ],
        'billing_country_id' => [
            'required' => 'Billing country ID is required.',
            'integer' => 'Billing country ID must be an integer.',
            'is_not_unique' => 'The billing country ID does not exist in the country table.'
        ],
        'billing_state_id' => [
            'required' => 'Billing state ID is required.',
            'integer' => 'Billing state ID must be an integer.',
            'is_not_unique' => 'The billing state ID does not exist in the state table.'
        ],
        'billing_city_id' => [
            'required' => 'Billing city ID is required.',
            'integer' => 'Billing city ID must be an integer.',
            'is_not_unique' => 'The billing city ID does not exist in the city table.'
        ],
        'billing_pincode' => [
            'required' => 'Billing pincode is required.',
            'string' => 'Billing pincode must be a string.',
            'max_length' => 'Billing pincode cannot exceed 255 characters.'
        ],
        'receiver_name' => [
            'required' => 'Receiver name is required.',
            'string' => 'Receiver name must be a string.',
            'max_length' => 'Receiver name cannot exceed 255 characters.'
        ],
        'receiver_mobile' => [
            'required' => 'Receiver mobile number is required.',
            'string' => 'Receiver mobile number must be a string.',
            'max_length' => 'Receiver mobile number cannot exceed 255 characters.'
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    private $statusAliases = [
        'order_payment_fail' => 'Payment Failed',
        'order_accepted' => 'Order Accepted',
        'order_ready_to_ship' => 'Ready to Ship',
        'order_shipped' => 'Shipped',
        'order_exchange_shipped' => 'Exchange Shipped',
        'order_delivered' => 'Delivered',
        'order_not_delivered' => 'Not Delivered',
        'order_exchanged' => 'Exchanged',
        'refund_request' => 'Refund Requested',
        'return_request' => 'Return Requested',
        'exchange_request' => 'Exchange Requested',
        'request_return_rejected' => 'Return Request Rejected',
        'request_exchange_rejected' => 'Exchange Request Rejected',
        'request_refund_approved' => 'Refund Approved',
        'request_return_approved' => 'Return Approved',
        'request_exchange_approved' => 'Exchange Approved',
        'refund_to_customer' => 'Refund Issued'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->addParentJoin('customer_id', $this->getCustomerModel(), 'left', ['fullname', 'email', 'mobile', 'dob', 'razorpay_customer_id', 'customer_upi_id']);
        $this->addParentJoin('billing_country_id', $this->getCountryModel(), 'left', ['country_name']);
        $this->addParentJoin('billing_state_id', $this->getStateModel(), 'left', ['state_name']);
        $this->addParentJoin('billing_city_id', $this->getCityModel(), 'left', ['city_name']);
    }
    public function GetAllOrdersWithItems($filter = [], $log_required = false, $log_order_status = [])
    {
        try {
            $order_list_resposne = $this->RecordList($filter);
            if ($order_list_resposne['status'] == ApiResponseStatusCode::OK) {
                foreach ($order_list_resposne['data'] as $key => &$order) {
                    $order['items'] = $this->GetOrderItems($order['order_id']);
                    $order['order_status_alias'] = $this->statusAliases[$order['order_status']] ?? 'Unknown Status';
                }
                if ($log_required) {
                    foreach ($order_list_resposne['data'] as $key => &$order) {
                        $ol = $this->getOrderLogModel();
                        if (!empty($log_order_status)) {
                            $ol->whereIn('order_status', $log_order_status);
                        }
                        $ol->where('order_id', $order['order_id']);
                        $logs = $ol->findAll() ?? [];

                        // Add order_status_alias field to each log
                        foreach ($logs as &$log) {
                            $log['order_status_alias'] = $this->statusAliases[$log['order_status']] ?? 'Unknown Status';
                        }
                        $order['logs'] = $logs;
                    }
                }

                return $order_list_resposne['data'];
            } else {
                return [];
            }
        } catch (\Throwable $th) {
            // Handle exception as needed
            return [];
        }
    }

    public function GetOrderItems($order_id)
    {
        $oi = $this->getOrderItemModel();

        return $oi->select("
            order_item.*,
            product.*,
            product_variant.*
        ")
            ->autoJoin()
            ->where('order_item.order_id', $order_id)
            ->findAll() ?? [];
    }

    public function MonthlyOrderSummary($order_status = null, $year = null)
    {
        if (empty($year)) {
            $year = date('Y');
        }
        $this->select('YEAR(order_date) AS year, DATE_FORMAT(order_date, "%b") AS month_name, SUM(order_total) AS total_sales');
        if (!empty($order_status)) {
            $this->where('order_status', $order_status);
        }
        $this->where('YEAR(order_date)', $year);
        $this->groupBy('YEAR(order_date), MONTH(order_date)');
        $this->orderBy('YEAR(order_date)', 'MONTH(order_date)');
        return $this->findAll() ?? [];
    }
    public function PreviousWeekOrderSummary($order_status = null)
    {
        /**
         * STEP 1: Find last completed week range (Mon → Sun)
         */

        // Today
        $today = new \DateTime('today');

        // Find this week's Monday
        $thisMonday = clone $today;
        $thisMonday->modify('monday this week');

        // Previous week Monday & Sunday
        $prevWeekStart = clone $thisMonday;
        $prevWeekStart->modify('-7 days'); // last week Monday

        $prevWeekEnd = clone $prevWeekStart;
        $prevWeekEnd->modify('+6 days'); // last week Sunday

        /**
         * STEP 2: Query
         */
        $this->select("
        YEAR(order_date) AS year,
        WEEK(order_date, 1) AS week_number,
        CONCAT('Week ', WEEK(order_date, 1)) AS week_name,
        COUNT(order_id) AS total_orders,
        SUM(order_total) AS total_sales
    ");

        if (!empty($order_status)) {
            $this->where('order_status', $order_status);
        }

        $this->where('order_date >=', $prevWeekStart->format('Y-m-d 00:00:00'));
        $this->where('order_date <=', $prevWeekEnd->format('Y-m-d 23:59:59'));

        $this->groupBy('YEAR(order_date), WEEK(order_date, 1)');

        return $this->findAll() ?? [];
    }

    public function YearlyOrderSummary($order_status = null)
    {
        $this->select('YEAR(order_date) AS year, SUM(order_total) AS total_sales');

        if (!empty($order_status)) {
            $this->where('order_status', $order_status);
        }

        $this->groupBy('YEAR(order_date)'); // Group by year
        $this->orderBy('YEAR(order_date)'); // Order by year
        return $this->findAll() ?? [];
    }
    public function CurrentWeekOrderSummary($order_status = null)
    {
        $currentYear = date('Y'); // Get the current year
        $currentWeek = date('W'); // Get the current week number

        $this->select('YEAR(order_date) AS year, WEEK(order_date) AS week_number, 
                   DATE_FORMAT(order_date, "%b %d") AS week_name, 
                   SUM(order_total) AS total_sales');

        if (!empty($order_status)) {
            $this->where('order_status', $order_status);
        }

        $this->where('YEAR(order_date)', $currentYear); // Filter by current year
        $this->where('WEEK(order_date)', $currentWeek); // Filter by current week number
        $this->groupBy('YEAR(order_date), WEEK(order_date)'); // Group by year and week
        $this->orderBy('YEAR(order_date)', 'WEEK(order_date)'); // Order by year and week
        return $this->findAll() ?? [];
    }
    public function CurrentMonthOrderSummary($order_status = null, $report_type = 'day_wise')
    {
        $currentYear = date('Y'); // Get the current year
        $currentMonth = date('m'); // Get the current month

        if ($report_type === 'day_wise') {
            // Day-wise summary
            $this->select('YEAR(order_date) AS year, MONTH(order_date) AS month, DAY(order_date) AS day, 
                       DATE_FORMAT(order_date, "%b %d") AS day_name, 
                       SUM(order_total) AS total_sales');

            if (!empty($order_status)) {
                $this->where('order_status', $order_status);
            }

            $this->where('YEAR(order_date)', $currentYear); // Filter by current year
            $this->where('MONTH(order_date)', $currentMonth); // Filter by current month
            $this->groupBy('YEAR(order_date), MONTH(order_date), DAY(order_date)'); // Group by year, month, and day
            $this->orderBy('YEAR(order_date)', 'MONTH(order_date), DAY(order_date)'); // Order by year, month, and day
        } elseif ($report_type === 'week_wise') {
            // Week-wise summary
            $this->select('YEAR(order_date) AS year, MONTH(order_date) AS month, WEEK(order_date) AS week_number, 
                       CONCAT(DATE_FORMAT(STR_TO_DATE(CONCAT(YEAR(order_date), " ", WEEK(order_date)), "%X %V"), "%b %d"), 
                       " - ", DATE_FORMAT(STR_TO_DATE(CONCAT(YEAR(order_date), " ", WEEK(order_date) + 1), "%X %V"), "%b %d")) AS week_name,
                       SUM(order_total) AS total_sales');

            if (!empty($order_status)) {
                $this->where('order_status', $order_status);
            }

            $this->where('YEAR(order_date)', $currentYear); // Filter by current year
            $this->where('MONTH(order_date)', $currentMonth); // Filter by current month
            $this->groupBy('YEAR(order_date), MONTH(order_date), WEEK(order_date)'); // Group by year, month, and week number
            $this->orderBy('YEAR(order_date)', 'MONTH(order_date), WEEK(order_date)'); // Order by year, month, and week number
        } else {
            throw new InvalidArgumentException("Invalid report_type. Valid values are 'day_wise' or 'week_wise'.");
        }

        return $this->findAll() ?? [];
    }
    // public function orderRevenue(){
    //     $overview_data = $this->select('SUM(IFNULL(order.order_total, 0) - IFNULL(order.total_refund_amount, 0)) AS revenue')
    //     ->whereIn('order.order_status', ['refund_to_customer', 'order_delivered', 'order_exchanged'])
    //     ->findAll();


    // return $overview_data;
    // }


}
