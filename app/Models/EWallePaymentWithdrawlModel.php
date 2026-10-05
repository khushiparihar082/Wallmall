<?php

namespace App\Models;

use CodeIgniter\Model;

class EWallePaymentWithdrawlModel extends FunctionModel
{
     protected $table            = 'e_wallet_payment_withdrawals';
    protected $primaryKey       = 'withdraw_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'withdraw_id',
        'customer_id',
        'e_wallet_ids',
        'requested_amount',
        'approved_amount',
        'status',
        'deduction_details',
        'payment_method',
        'transaction_id',
        'remark',

    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
 // Validation
    protected $validationRules = [
        'customer_id'        => 'required',
        'e_wallet_ids'       => 'permit_empty',
        'requested_amount'   => 'required',
        'approved_amount'    => 'permit_empty',
        'status'             => 'required|in_list[pending,approved,rejected,processing,paid,purchased]',
        'deduction_details'  => 'permit_empty',
        'payment_method'     => 'permit_empty',
        'transaction_id'     => 'permit_empty',
        'remark'             => 'required',
    ];

    protected $validationMessages   = [
        'customer_id'        => [
            'required' => 'Customer ID is required',
        ],
        'requested_amount'   => [
            'required' => 'Requested Amount is required',
        ],
        'status'             => [
            'required' => 'Status is required',
            'in_list' => 'Status is not valid'
        ],
        'remark'          => [
            'required' => 'Remark is required',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

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
