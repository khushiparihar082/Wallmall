<?php

namespace App\Models;

use App\Models\FunctionModel;

class ContactUsModel extends FunctionModel
{
    protected $table            = 'contact_us';
    protected $primaryKey       = 'contact_us_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'contact_us_id',
        'fullname',
        'email',
        'mobile',
        'message',
        'order_inquiry',
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
    protected $messageAlias = "ContacUs";
    // Validation
    protected $validationRules = [
        'contact_us_id'       => 'permit_empty',
        'fullname'      => 'required',
        'email'         => 'valid_email|is_unique[contact_us.email]',
        'mobile'        => 'permit_empty|is_unique[contact_us.mobile]|max_length[10]',
        'message'       => 'permit_empty',
        'order_inquiry' => 'in_list[business,product_quality,other,order_specific]',
    ];

    protected $validationMessages = [
        'fullname' => [
            'required' => 'Full name is required.',
            'max_length' => 'Full name cannot exceed 255 characters.',
        ],
        'email' => [
            'valid_email' => 'Please enter a valid email address.',
            'is_unique'   => 'This email address is already taken.',
        ],
        'mobile' => [
            'is_unique'   => 'This mobile number is already taken.',
            'max_length' => 'Mobile number cannot exceed 10 digits.',
        ],
        'order_inquiry' => [
            'in_list' => 'Select a valid order inquiry type.',
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
