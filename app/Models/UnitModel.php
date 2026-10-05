<?php

namespace App\Models;

use App\Models\FunctionModel;

class UnitModel extends FunctionModel
{
    protected $table            = 'unit';
    protected $primaryKey       = 'unit_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['unit_id','unit_name'];

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
    protected $messageAlias = 'Unit';
    // Validation
    protected $validationRules = [
        'unit_id' => "permit_empty",
        'unit_name' => 'required|max_length[255]|is_unique[unit.unit_name,unit_id,{unit_id}]',
    ];
    protected $validationMessages = [
        'unit_name' => [
            'required' => 'Unit name is required.',
            'max_length' => 'Unit name must not exceed 255 characters.',
            'alpha_dash' => 'Unit name may only contain alpha-numeric characters, underscores, and dashes.'
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
    }
}
