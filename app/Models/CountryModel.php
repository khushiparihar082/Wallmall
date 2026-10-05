<?php

namespace App\Models;

use App\Models\FunctionModel;

class CountryModel extends FunctionModel
{
    protected $table            = 'country';
    protected $primaryKey       = 'country_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['country_id','country_name', 'alias', 'short_name', 'phonecode', 'currency', 'currency_name', 'currency_symbol', 'region', 'created_at', 'updated_at'];

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
    protected $messageAlias = 'Country';
 

    // Validation
    protected $validationRules = [
        'country_id'=>'permit_empty',
        'country_name' => 'required|max_length[100]|is_unique[country_name,country_id,{country_id}]',
        'alias' => 'max_length[3]',
        'short_name' => 'max_length[2]',
        'phonecode' => 'max_length[255]',
        'currency' => 'max_length[255]',
        'currency_name' => 'max_length[255]',
        'currency_symbol' => 'max_length[255]',
        'region' => 'max_length[255]',
    ];
    protected $validationMessages   = [];
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
    public function getTableName(){
        return $this->table;
    }
}
