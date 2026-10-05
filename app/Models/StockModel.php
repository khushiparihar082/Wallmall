<?php

namespace App\Models;

use App\Models\FunctionModel;

class StockModel extends FunctionModel
{
    protected $table            = 'stock';
    protected $primaryKey       = 'stock_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['stock_id','variant_id','quantity','created_at'];

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
        'stock_id' => 'permit_empty',
        'variant_id' => 'required|integer|is_not_unique[product_variant.variant_id]',
        'quantity' => 'required|numeric',
    ];
    protected $validationMessages = [
        'quantity' => [
            'required' => 'Quantity is required.'
        ],
        'variant_id' => [
            'required' => 'Variant ID is required.'
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
    protected $messageAlias = "Stock";
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
        $this->addParentJoin('variant_id', $this->getProductVariantModel(), 'left', ['variant_name']);
    }
}
