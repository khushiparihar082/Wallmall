<?php

namespace App\Models;

use App\Models\FunctionModel;
use App\Traits\CommonTraits;
class OfferItemModel extends FunctionModel
{
    use CommonTraits;
    protected $table            = 'offer_item';
    protected $primaryKey       = 'offer_item_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['offer_item_id', 'offer_id', 'product_id'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];
    protected $messageAlias = "OfferItem";
    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'offer_item_id'    => 'permit_empty',
        'offer_id'    => 'required|integer|is_not_unique[offer.offer_id]',
        'product_id'  => 'required|integer|is_not_unique[product.product_id]',
    ];

    protected $validationMessages = [
        'offer_id' => [
            'required' => 'The offer ID is required.',
            'integer'  => 'The offer ID must be an integer.'
        ],
        'product_id' => [
            'required' => 'The variant ID is required.',
            'integer'  => 'The variant ID must be an integer.'
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
        $this->addParentJoin('offer_id', $this->getOfferModel(), 'left', ['offer_name','offer_discount']);
        $this->addParentJoin('product_id', $this->getProductModel(), 'left', ['product_name']);
    }
}
