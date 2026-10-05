<?php

namespace App\Models;

use App\Models\FunctionModel;

class OrderLogModel extends FunctionModel
{
    protected $table      = 'order_log';
    protected $primaryKey = 'order_log_id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'order_log_id',
        'order_id',
        'order_status',
        'log_remark',
    ];

    // Validation rules
    protected $validationRules = [
        'order_log_id' => 'permit_empty|string',
        'order_id' => 'required|integer|is_not_unique[order.order_id]',
        'order_status' => 'required|string|max_length[255]',
        'log_remark' => 'permit_empty|string',
    ];

    // Custom validation messages
    protected $validationMessages = [
        'order_id' => [
            'required' => 'The Order ID is required.',
            'integer' => 'The Order ID must be an integer.',
            'is_not_unique' => 'The Order ID provided does not exist in the order table.',
        ],
        'order_status' => [
            'required' => 'Order status is required.',
            'string' => 'Order status must be a valid string.',
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
