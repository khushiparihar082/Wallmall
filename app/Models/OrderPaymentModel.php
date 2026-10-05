<?php

namespace App\Models;

use App\Models\FunctionModel;

class OrderPaymentModel extends FunctionModel
{
    protected $table      = 'order_payment';
    protected $primaryKey = 'order_payment_id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'order_payment_id',
        'order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'payment_status',
        'payment_verify',
        'payment_transaction_id',
        'payment_amt',
        'payment_remark',
        'payment_response',
        'order_total',
        'payment_mode'
    ];

    // Validation rules
    protected $validationRules = [
        'order_id' => 'required|integer|is_not_unique[order.order_id]',
        'razorpay_payment_id'  => 'permit_empty',
        'razorpay_signature' => 'permit_empty',
        'payment_status' => 'required',
        'payment_amt' => 'required|decimal',
        'payment_remark' => 'permit_empty|string',
        'order_total'  => 'permit_empty',
        'payment_mode'  => 'permit_empty',
    ];

    // Custom validation messages
    protected $validationMessages = [
        'order_id' => [
            'required' => 'The Order ID is required.',
            'integer' => 'The Order ID must be an integer.',
            'is_not_unique' => 'The Order ID provided does not exist in the order table.',
        ],
        'payment_status' => [
            'required' => 'Payment status is required.',
        ],
        'payment_verify' => [
            'required' => 'Payment verification status is required.',
        ],
        'payment_amt' => [
            'required' => 'Payment amount is required.',
            'decimal' => 'Payment amount must be a decimal value.',
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
}
