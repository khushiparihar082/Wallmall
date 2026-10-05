<?php

namespace App\Models;

use App\Models\FunctionModel;

class FormSubmissionsModel extends FunctionModel
{
    protected $table = 'form_submissions';
    protected $primaryKey = 'form_submissions_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'form_submissions_id',
        'form_type', 'name', 'email', 'mobile', 'message', 
        'attachment_blob', 'attachment_url','product_id' ,'status','status_remark'
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
    protected $validationRules = ['form_submissions_id',
        'form_type' => 'required|in_list[contact_us,sales,support,career]',
        'status' => 'required|in_list[pending,partial_pending,resolved,status_remark]',
        'name' => 'required|string|max_length[255]',
        'email' => 'required|valid_email|max_length[255]',
        'mobile' => 'permit_empty|string|max_length[15]',
        'message' => 'required|string',
        'attachment_url' => 'permit_empty|string|max_length[255]',
        'product_id' => 'required|integer|is_not_unique[product.product_id]',
    ];

    protected $validationMessages = [
        'form_type' => [
            'required' => 'Form type is required',
            'in_list' => 'Form type must be one of: contact_us, sales, support, career'
        ],
        'name' => [
            'required' => 'Name is required',
            'string' => 'Name must be a valid string',
            'max_length' => 'Name cannot exceed 255 characters'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please provide a valid email address',
            'max_length' => 'Email cannot exceed 255 characters'
        ],
        'mobile' => [
            'string' => 'Mobile number must be a valid string',
            'max_length' => 'Mobile number cannot exceed 15 characters'
        ],
        'message' => [
            'string' => 'Message must be a valid string'
        ],
        'attachment_url' => [
            'string' => 'Attachment URL must be a valid string',
            'max_length' => 'Attachment URL cannot exceed 255 characters'
        ],
        'product_id' => [
            'integer' => 'Product or service ID must be a valid integer',
            'max_length' => 'Product or service ID cannot exceed 11 characters'
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
        $this->addParentJoin('product_id', $this->getProductModel(), 'left', ['product_name']);
    }
}
