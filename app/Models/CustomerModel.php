<?php

namespace App\Models;

use App\Models\FunctionModel;

class CustomerModel extends FunctionModel
{
    protected $table            = 'customer';
    protected $primaryKey       = 'customer_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['customer_id', 'razorpay_customer_id', 'reffer_code', 'reffer_by_id', 'google_oauth_id', 'fullname', 'email', 'mobile', 'dob', 'password', 'is_active', 'last_activity_date', 'refferal_patner_id', 'is_patner', 'customer_upi_id'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;
    protected $messageAlias = "Customer";
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
        'customer_id' => 'permit_empty',
        'razorpay_customer_id' => 'permit_empty',
        'fullname'    => 'required|string|max_length[255]',
        'email'       => 'required|valid_email|max_length[255]|is_unique[customer.email]',
        'mobile'      => 'required|numeric|max_length[10]|is_unique[customer.mobile]',
        'dob'         => 'permit_empty|valid_date[Y-m-d]',
        'password'    => 'required',
        'is_active'   => 'required|in_list[0,1]',
        'reffer_code'   => 'permit_empty',
        'reffer_by_id'   => 'permit_empty',
        'google_oauth_id'   => 'permit_empty',
        'last_activity_date' => 'permit_empty',
        'refferal_patner_id' => 'permit_empty',
        'is_patner' => 'required|in_list[0,1]',
        'customer_upi_id' => 'permit_empty',
    ];

    protected $validationMessages = [

        'fullname' => [
            'required'   => 'Full name is required.',
            'string'     => 'Full name must be a string.',
            'max_length' => 'Full name cannot exceed 255 characters.',
        ],
        'email' => [
            'required'   => 'Email is required.',
            'valid_email' => 'Please provide a valid email address.',
            'max_length' => 'Email cannot exceed 255 characters.',
            'is_unique'  => 'Email already exists in the system.',
        ],
        'mobile' => [
            'required'   => 'Mobile number is required.',
            'numeric'    => 'Mobile number must be numeric.',
            'max_length' => 'Mobile number cannot exceed 10 digits.',
            'is_unique'  => 'Mobile number already exists in the system.',
        ],
        'dob' => [
            'required'   => 'Date of birth is required.',
            'valid_date' => 'Please provide a valid date in the format YYYY-MM-DD.',
        ],
        'password' => [
            'required'   => 'Password is required.',
            'min_length' => 'Password must be at least 8 characters long.',
        ],
        'is_active' => [
            'required'   => 'Active status is required.',
            'boolean'    => 'Active status must be true or false.',
        ],
        'is_patner' => [
            'required'   => 'E-wallet status is required.',
            'boolean'    => 'E-wallet status must be true or false.',
        ],
       
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $loginFields = ['email', 'mobile'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['hashPassword'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    protected $passwordField = "password";


    public function __construct()
    {
        parent::__construct();
    }
}
