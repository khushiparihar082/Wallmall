<?php

namespace App\Models;
use App\Models\FunctionModel;

class CustomerAddressModel extends FunctionModel
{
    protected $table            = 'customer_address';
    protected $primaryKey       = 'customer_address_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['customer_address_id', 'customer_id', 'customer_country_id', 'customer_state_id', 'customer_city_id', 'customer_addresses', 'customer_pincode', 'address_type'];

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
    protected $messageAlias = "Address";
    // Validation
    // Validation
    protected $validationRules = [
        'customer_address_id' => 'permit_empty',
        'customer_id'         => 'required|integer|is_not_unique[customer.customer_id]',
        'customer_country_id' => 'required|integer|is_not_unique[country.country_id]',
        'customer_state_id'   => 'required|integer|is_not_unique[state.state_id]',
        'customer_city_id'    => 'required|integer|is_not_unique[city.city_id]',
        'customer_addresses'  => 'required|max_length[255]',
        'customer_pincode'    => 'required',
        'address_type'        => 'required|in_list[office,home,other]',
    ];

    protected $validationMessages = [
        'customer_id' => [
            'required' => 'Customer ID is required.',
        ],
        'customer_country_id' => [
            'required' => 'Country ID is required.',
        ],
        'customer_state_id' => [
            'required' => 'State ID is required.',
        ],
        'customer_city_id' => [
            'required' => 'City ID is required.',
        ],
        'customer_addresses' => [
            'required'   => 'Address is required.',
            'max_length' => 'Address cannot exceed 255 characters.',
        ],
        'customer_pincode' => [
            'required'   => 'Pincode is required.',
            'max_length' => 'Pincode cannot exceed 10 characters.',
        ],
        'address_type' => [
            'required' => 'Address type is required.',
            'in_list'  => 'Address type must be one of: office, home, other.',
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
    }
}
