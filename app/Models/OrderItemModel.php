<?php

namespace App\Models;

use App\Models\FunctionModel;

class OrderItemModel extends FunctionModel
{
    protected $table            = 'order_item';
    protected $primaryKey       = 'order_item_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'order_item_id',
        'customer_id',
        'order_id',
        'product_id',
        'variant_id',
        'size_id',
        'color_id',
        'purches_rate',
        'MRP',
        'order_qty',
        'final_discount',
        'final_rate',
        'coupan_dis_amount',
        'shipping_charges_amount',
        'item_total_amount',
        'gst_per',
        'taxable_amount',
        'gst_amount',
        'return_qty',
        'exchange_qty',
        'refund_amount',
        'return_exchange_image1',
        'return_exchange_image2',
        'return_exchange_image3',
        'return_exchange_image4',
        'created_at',
        'updated_at'
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

    // Validation Rules
    protected $validationRules = [
        'order_item_id' => 'permit_empty',
        'customer_id' => 'required|integer|is_not_unique[customer.customer_id]',
        'order_id' => 'required|integer|is_not_unique[order.order_id]',
        'product_id' => 'required|integer|is_not_unique[product.product_id]',
        'variant_id' => 'required|integer|is_not_unique[product_variant.variant_id]',
        'size_id' => 'permit_empty|integer|is_not_unique[size.size_id]',
        'color_id' => 'required|integer|is_not_unique[color.color_id]',
        'return_qty' => 'permit_empty',
        'exchange_qty' => 'permit_empty',
        'refund_amount' => 'permit_empty',
        'purches_rate' => 'required',
        'mrp' => 'required',
        'order_qty' => 'required|integer',
        'final_discount' => 'permit_empty',
        'final_rate' => 'permit_empty',
        'coupan_dis_amount' => 'permit_empty',
        'shipping_charges_amount' => 'permit_empty',
        'item_total_amount' => 'required',
        'gst_per' => 'permit_empty',
        'taxable_amount' => 'permit_empty',
        'gst_amount' => 'permit_empty',
        'return_exchange_image1' => 'permit_empty',
        'return_exchange_image2' => 'permit_empty',
        'return_exchange_image3' => 'permit_empty',
        'return_exchange_image4' => 'permit_empty',
    ];

    // Validation Messages (optional)
    protected $validationMessages = [
        'customer_id' => [
            'required' => 'Customer ID is required.',
            'integer' => 'Customer ID must be an integer.'
        ],
        'order_id' => [
            'required' => 'Order ID is required.',
            'integer' => 'Order ID must be an integer.'
        ],
        'product_id' => [
            'required' => 'Product ID is required.',
            'integer' => 'Product ID must be an integer.'
        ],
        'variant_id' => [
            'required' => 'Variant ID is required.',
            'integer' => 'Variant ID must be an integer.'
        ],
        'purches_rate' => [
            'required' => 'Purchase rate is required.',
            'decimal' => 'Purchase rate must be a decimal value.'
        ],
        'MRP' => [
            'required' => 'MRP is required.',
            'decimal' => 'MRP must be a decimal value.'
        ],
        'order_qty' => [
            'required' => 'Order quantity is required.',
            'integer' => 'Order quantity must be an integer.'
        ],
        'item_total_amount' => [
            'required' => 'Item total amount is required.',
            'decimal' => 'Item total amount must be a decimal value.'
        ]
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
        $this->addParentJoin('size_id', $this->getSizeModel(), 'left', ['size_name']);
        $this->addParentJoin('color_id', $this->getColorModel(), 'left', ['color_name']);
        $this->addParentJoin('product_id', $this->getProductModel(), 'left', ['product_name', 'is_exchangeable', 'is_recommended', 'is_sponsore', 'is_returnable']);
        $this->addParentJoin('variant_id', $this->getProductVariantModel(), 'left', ['variant_name']);
    }
}
