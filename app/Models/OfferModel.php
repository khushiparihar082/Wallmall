<?php

namespace App\Models;


use App\Models\FunctionModel;

class OfferModel extends FunctionModel
{
    protected $table            = 'offer';
    protected $primaryKey       = 'offer_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['offer_id', 'offer_alt_text', 'offer_name', 'offer_title', 'offer_image', 'offer_type', 'offer_seo_title', 'offer_seo_keyword', 'offer_seo_description', 'offer_from', 'offer_to', 'offer_discount', 'is_active'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];
    protected $messageAlias = "Offer";
    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    // Validation
    protected $validationRules = [
        'offer_id' => 'permit_empty',
        'offer_name' => 'required|max_length[255]',
        'offer_title' => 'required|max_length[255]',
        'offer_image' => 'required',
        'offer_alt_text' => 'permit_empty',
        'offer_type'  => 'required|in_list[festival,season,other,deal_of_the_day]',
        'offer_seo_title'      => "permit_empty|max_length[60]",
        'offer_seo_keyword'    => 'permit_empty',
        'offer_seo_description' => 'permit_empty|max_length[170]',
        'offer_from'           => 'required|valid_date',
        'offer_to'             => 'required|valid_date',
        'offer_discount'       => 'required|numeric',
        'is_active'            => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'offer_name' => [
            'required'   => 'The Offer name is required.',
            'max_length' => 'The Offer name cannot exceed 255 characters.',
            'alpha_space' => 'The Offer name cannot contain special characters or numbers.'
        ],
        'offer_title' => [
            'required'   => 'The Offer title is required.',
            'alpha_space' => 'The Offer Title cannot contain special characters or numbers.',
            'max_length' => 'The Offer title cannot exceed 255 characters.'
        ],
        'offer_image' => [
            'required'   => 'The Offer Image is required.',
            'valid_url' => 'The Offer image must be a valid URL.'
        ],
        'offer_type' => [
            'required' => 'The Offer type is required.',
            'in_list'  => 'The Offer type must be one of: discount, buy_one_get_one, flash_sale.'
        ],
        'offer_seo_title' => [
            'max_length' => 'The Tag title cannot exceed 60 characters.'
        ],
        'offer_seo_keyword' => [
            'max_length' => 'The Meta keyword cannot exceed 70 characters.'
        ],
        'offer_seo_description' => [
            'max_length' => 'The Meta description cannot exceed 155 characters.'
        ],
        'offer_from' => [
            'required'   => 'The Offer start date is required.',
            'valid_date' => 'The Offer start date must be a valid date.'
        ],
        'offer_to' => [
            'required'   => 'The Offer end date is required.',
            'valid_date' => 'The Offer end date must be a valid date.'
        ],
        'offer_discount' => [
            'required'      => 'The Offer discount is required.',
            'numeric'       => 'The Offer discount must be a number.',
        ],
        'is_active' => [
            'required' => 'The active status is required.',
            'in_list'  => 'The active status must be either 0 or 1.'
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

    // Custom validation rules

    public function __construct()
    {
        parent::__construct();
    }
    protected function alpha_space(string $str): bool
    {
        return preg_match('/^[a-zA-Z\s]+$/', $str) === 1;
    }
}
