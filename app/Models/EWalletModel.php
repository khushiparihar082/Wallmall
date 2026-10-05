<?php

namespace App\Models;

use CodeIgniter\Model;

class EWalletModel extends FunctionModel
{
    protected $table            = 'e_wallet';
    protected $primaryKey       = 'e_wallet_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'e_wallet_id',
        'customer_type',
        'customer_id',
        'order_id',
        'e_wallet_percentage',
        'order_amount',
        'e_wallet_amount',
        'is_wallet_active'
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
    protected $validationRules = [
        'customer_type'       => 'required|in_list[self,patner,parent_patner]',
        'customer_id'         => 'required|integer',
        'order_id'            => 'required|integer',
        'e_wallet_percentage' => 'permit_empty|numeric',
        'order_amount'        => 'permit_empty|numeric',
        'e_wallet_amount'     => 'permit_empty|numeric',
        'is_wallet_active'    => 'permit_empty|in_list[0,1]',
    ];

    protected $validationMessages = [
        'customer_type' => [
            'required' => 'Customer type is required.',
            'in_list'  => 'Customer type must be one of: self, patner, parent_patner.',
        ],

        'customer_id' => [
            'required' => 'Customer ID is required.',
            'integer'  => 'Customer ID must be a valid number.',
        ],

        'order_id' => [
            'required' => 'Order ID is required.',
            'integer'  => 'Order ID must be a valid number.',
        ],

        'e_wallet_percentage' => [
            'numeric' => 'E-Wallet percentage must be numeric value.',
        ],

        'order_amount' => [
            'numeric' => 'Order amount must be numeric value.',
        ],

        'e_wallet_amount' => [
            'numeric' => 'E-Wallet amount must be numeric value.',
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

    public function __construct()
    {
        parent::__construct();
        $this->addParentJoin('order_id', $this->getOrderModel(), 'left', ['order_name']);
        $this->addParentJoin('customer_id', $this->getCustomerModel(), 'left', ['fullname']);
    }
}
