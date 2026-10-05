<?php

namespace App\Models;

use App\Models\FunctionModel;

class SubscriptionModel extends FunctionModel
{
    protected $table            = 'subscriptions';
    protected $primaryKey       = 'subscriptions_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['subscriptions_id', 'subscription_name', 'subscription_plan_detail', 'maintannace_duration_month', 'maintanance_duration_charges', 'per_order_commission', 'subscription_image'];

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

    // Validation
    protected $validationRules      = [
        'subscriptions_id' => 'permit_empty',
        'subscription_name' => 'required|max_length[255]',
        'subscription_plan_detail' => 'required',
        'maintannace_duration_month' => 'required|integer',
        'maintanance_duration_charges' => 'required|decimal',
        'per_order_commission' => 'required|decimal',
        'subscription_image' => 'permit_empty|max_length[255]',
    ];

    protected $validationMessages   = [
        'subscription_name' => [
            'required' => 'The subscription name is required.',
            'max_length' => 'The subscription name must not exceed 255 characters.',
        ],
        'subscription_plan_detail' => [
            'required' => 'The subscription plan detail is required.',
        ],
        'maintannace_duration_month' => [
            'required' => 'The maintenance duration in months is required.',
            'integer' => 'The maintenance duration must be an integer value.',
        ],
        'maintanance_duration_charges' => [
            'required' => 'The maintenance duration charges are required.',
            'decimal' => 'The maintenance duration charges must be a decimal value.',
        ],
        'per_order_commission' => [
            'required' => 'The per order commission is required.',
            'decimal' => 'The per order commission must be a decimal value.',
        ],
        'subscription_image' => [
            'required' => 'The subscription image is required.',
            'max_length' => 'The subscription image path must not exceed 255 characters.',
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
    }
}
