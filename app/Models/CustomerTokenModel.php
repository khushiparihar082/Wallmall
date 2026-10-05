<?php

namespace App\Models;

use App\Models\FunctionModel;

class CustomerTokenModel extends FunctionModel
{
    protected $table            = 'customer_token';
    protected $primaryKey       = 'token_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['token_id','customer_id','token','expiry','ip_address','device_name'];

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
        'token_id'    => 'permit_empty',
        'customer_id' => 'permit_empty|integer|is_not_unique[customer.customer_id]',
        'token'       => 'required',
        'expiry'      => 'required',
        'ip_address'  => 'required',
        'device_name' => 'required|string|max_length[255]',
    ];

    protected $validationMessages = [
   
        'customer_id' => [
            'required'      => 'Customer ID is required.',
            'max_length'    => 'Customer ID cannot exceed 36 characters.',
        ],
        'token' => [
            'required'   => 'Token is required.',
            'string'     => 'Token must be a string.',
            'max_length' => 'Token cannot exceed 255 characters.',
        ],
        'expiry' => [
            'required'   => 'Expiry date and time is required.',
            'valid_date' => 'Please provide a valid date and time in the format YYYY-MM-DD HH:MM:SS.',
        ],
        'ip_address' => [
            'required' => 'IP address is required.',
        ],
        'device_name' => [
            'required'   => 'Device name is required.',
            'string'     => 'Device name must be a string.',
            'max_length' => 'Device name cannot exceed 255 characters.',
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
