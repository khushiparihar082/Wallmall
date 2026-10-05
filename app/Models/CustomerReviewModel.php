<?php

namespace App\Models;

use App\Models\FunctionModel;

class CustomerReviewModel extends FunctionModel
{
    protected $table            = 'customer_review';
    protected $primaryKey       = 'customer_review_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'customer_review_id', 'customer_id', 'product_id', 'variant_id', 'customer_rating', 'customer_review', 'customer_review_image1', 'customer_alt_text1',
        'customer_review_image2', 'customer_alt_text2',
        'customer_review_image3', 'customer_alt_text3',
        'customer_review_image4', 'customer_alt_text4',
        'customer_review_status'
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
        'customer_review_id' => 'permit_empty',
        'customer_id'         => 'required|integer|is_not_unique[customer.customer_id]',
        'product_id'    => 'required|integer|is_not_unique[product.product_id]',
        'variant_id'    => 'required|integer|is_not_unique[product_variant.variant_id]',
        'customer_rating'         => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        'customer_review'         => 'permit_empty',
        'customer_review_image1'  => 'permit_empty',
        'customer_alt_text1'      => 'permit_empty',
        'customer_review_image2'  => 'permit_empty',
        'customer_alt_text2'      => 'permit_empty',
        'customer_review_image3'  => 'permit_empty',
        'customer_alt_text3'      => 'permit_empty',
        'customer_review_image4'  => 'permit_empty',
        'customer_alt_text4'      => 'permit_empty',
        'customer_review_status'  => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'customer_id' => [
            'required' => 'The Customer ID is required.',
            'integer'  => 'The Customer ID must be an integer.',
        ],
        'customer_review_status' => [
            'required' => 'Review status is required.',
        ],
        'product_id' => [
            'required' => 'The Product ID is required.',
            'integer'  => 'The Product ID must be an integer.',
        ],
        'variant_id' => [
            'required' => 'The Variant ID is required.',
            'integer'  => 'The Variant ID must be an integer.',
        ],
        'customer_rating' => [
            'required'              => 'The Customer Rating is required.',
            'integer'               => 'The Customer Rating must be an integer.',
            'greater_than_equal_to' => 'The Customer Rating must be at least 1.',
            'less_than_equal_to'    => 'The Customer Rating must not exceed 5.',
        ],
        'customer_review' => [
            'required' => 'The Customer Review is required.',
            'string'   => 'The Customer Review must be a valid string.',
        ],
    
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
    protected $messageAlias = "Review";
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
        $this->addParentJoin('customer_id', $this->getCustomerModel(), 'left', ['fullname']);
        $this->addParentJoin('product_id', $this->getProductModel(), 'left', ['product_name']);
        $this->addParentJoin('variant_id', $this->getProductVariantModel(), 'left', ['variant_name']);
    }
}
