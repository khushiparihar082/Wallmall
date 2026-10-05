<?php

namespace App\Models;

use App\Models\FunctionModel;

class CityModel extends FunctionModel
{
    // protected $DBGroup          = 'default';
    protected $table            = 'city';
    protected $primaryKey       = 'city_id';
     protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['city_id', 'city_name', 'country_id', 'state_id', 'created_at', 'updated_at'];

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
    protected $messageAlias = 'City';
 

    // Validation
    protected $validationRules = [
        'city_id' => 'permit_empty',
        'city_name' => 'required|max_length[255]',
        'country_id' => 'required|integer|is_not_unique[country.country_id]',
        'state_id' => 'required|integer|is_not_unique[state.state_id]',
    ];
    protected $validationMessages = [
        'city_name' => [
            'required' => 'City name is required.',
            'max_length' => 'City name must not exceed 255 characters.'
        ],
        'country_id' => [
            'required' => 'Country ID is required.',
            'integer' => 'Country ID must be an integer.',
            'is_not_unique' => 'Selected country does not exist.'
        ],
        'state_id' => [
            'required' => 'State ID is required.',
            'integer' => 'State ID must be an integer.',
            'is_not_unique' => 'Selected state does not exist.'
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
        $this->addParentJoin('state_id',$this->getStateModel(),'left',['state_name','state_code']);
    }
}
