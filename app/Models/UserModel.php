<?php

namespace App\Models;

use App\Models\FunctionModel;

class UserModel extends FunctionModel
{
    protected $table            = 'user';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'fullname', 'email', 'mobile', 'password', 'otp', 'user_type', 'is_active'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $messageAlias = 'User';
    // Validation
    protected $validationRules = [
        'user_id' => 'permit_empty|integer',
        'fullname' => 'required|max_length[255]',
        'email' => 'required|valid_email|max_length[255]|is_unique[user.email,user_id,{user_id}]',
        'mobile' => 'required|max_length[10]|is_unique[user.mobile,user_id,{user_id}]',
        'password' => 'required|max_length[255]',
        'otp' => 'permit_empty|max_length[6]',
        'user_type' => 'required|in_list[admin,inventory,finance,order,delivery]',
        'is_active' => 'in_list[0,1]'
    ];

    protected $validationMessages = [
        'fullname' => [
            'required' => 'Fullname is required.',
            'max_length' => 'Max 255 characters.',
            'alpha_space' => 'Fullname cannot contain special characters or numbers.'
        ],
        'email' => [
            'required' => 'Email is required.',
            'valid_email' => 'Must be a valid email address.',
            'max_length' => 'Max 255 characters.',
            'is_unique' => 'Email already exists.'
        ],
        'mobile' => [
            'required' => 'Mobile number is required.',
            'max_length' => 'Max 10 characters.',
            'is_unique' => 'Mobile number already exists.'
        ],
        'password' => [
            'required' => 'Password is required.',
            'max_length' => 'Max 255 characters.'
        ],
        'otp' => [
            'max_length' => 'Max 6 characters.'
        ],
        'user_type' => [
            'required' => 'User type is required.',
            'in_list' => 'Invalid user type.'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $passwordField = "password";
    protected $loginFields = ['email', 'mobile'];
    protected $beforeInsert   = ['hashPassword'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['hashPassword'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    
    public function __construct()
    {
        parent::__construct();
    }

    protected function alpha_space(string $str): bool
    {
        return preg_match('/^[a-zA-Z\s]+$/', $str) === 1;
    }
}
