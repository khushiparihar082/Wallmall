<?php

namespace App\Models;

use App\Models\FunctionModel;

class CustomerCartModel extends FunctionModel
{
    protected $table            = 'customer_cart';
    protected $primaryKey       = 'customer_cart_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'customer_cart_id', 
        'customer_id', 
        'product_id', 
        'variant_id', 
        // 'size_id', 
        'cart_quantity'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;
    protected $messageAlias = "Cart";
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
        'customer_cart_id' => 'permit_empty',
        'customer_id'         => 'required|integer|is_not_unique[customer.customer_id]',
        'product_id'    => 'required|integer|is_not_unique[product.product_id]',
        'variant_id'    => 'required|integer|is_not_unique[product_variant.variant_id]',
        // 'size_id'       => 'permit_empty|integer|is_not_unique[size.size_id]',
        'cart_quantity' => 'permit_empty|integer',
    ];

    protected $validationMessages = [
        'customer_id' => [
            'required' => 'Customer ID is required.',
            'integer'  => 'Customer ID must be an integer.',
        ],
        'product_id' => [
            'required' => 'Product ID is required.',
            'integer'  => 'Product ID must be an integer.',
        ],
        'variant_id' => [
            'required' => 'Variant ID is required.',
            'integer'  => 'Variant ID must be an integer.',
        ],
        // 'size_id' => [
        //     'required' => 'Size ID is required.',
        //     'integer'  => 'Size ID must be an integer.',
        // ],
        'cart_quantity' => [
            'required'      => 'Cart quantity is required.',
            'integer'       => 'Cart quantity must be an integer.',
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


    // public function __construct()
    // {
    //     parent::__construct();
    // }
    public function __construct()
    {
        parent::__construct();
        $this->addParentJoin('product_id', $this->getProductModel(), 'left', ['product_name']);
        $this->addParentJoin('variant_id', $this->getProductVariantModel(), 'left', ['variant_name']);
    }
}
