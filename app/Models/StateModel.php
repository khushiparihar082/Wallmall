<?php

namespace App\Models;

use App\Models\FunctionModel;

class StateModel extends FunctionModel
{
    protected $table            = 'state';
    protected $primaryKey       = 'state_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['state_id','state_name', 'state_code', 'country_id', 'short_name', 'created_at', 'updated_at'];

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
    protected $messageAlias = 'State';
    // Validation
    protected $validationRules = [
        'state_id' => 'permit_empty',
        'state_name' => 'required|max_length[255]|is_unique[state_name,state_id,{state_id}]',
        'state_code' => 'max_length[3]',
        'country_id' => 'required|is_not_unique[country.country_id]',
        'short_name' => 'max_length[120]',
    ];
    protected $validationMessages   = [
        "state_name"=>[
            "required" => "State Name Required",
            "is_unique" => "Name Already Exist",
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
        $this->addParentJoin('country_id',$this->getCountryModel(),'left',['country_name','phonecode as "country_code"']);
    }
}
