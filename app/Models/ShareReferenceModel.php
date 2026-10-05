<?php

namespace App\Models;

use App\Models\FunctionModel;

class ShareReferenceModel extends FunctionModel
{
    protected $table            = 'share_reference';
    protected $primaryKey       = 'share_reference_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['share_reference_id', 'product_id', 'share_by_customer_id', 'customer_search_count', 'source'];


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
        'share_reference_id' => 'permit_empty',
        'product_id'    => 'required|integer|is_not_unique[product.product_id]',
        'share_by_customer_id'    => 'permit_empty|integer|is_not_unique[customer.customer_id]',
        'customer_search_count' => 'integer|permit_empty',
        'source' => 'permit_empty',
    ];
    protected $validationMessages = [
        'product_id' => [
            'required' => 'Product ID is required.',
            'integer'  => 'Product ID must be an integer.',
        ],
        'share_by_customer_id' => [
            'required' => 'Customer ID is required.',
            'integer'  => 'Customer ID must be an integer.',
        ],
        'customer_search_count' => [
            'integer' => 'The maximum use count must be an integer.',
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
