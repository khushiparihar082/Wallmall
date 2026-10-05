<?php

namespace App\Models;

use App\Models\FunctionModel;

class SizeModel extends FunctionModel
{
    protected $table            = 'size';
    protected $primaryKey       = 'size_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['size_id ', 'size_name'];

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
    protected $messageAlias = 'Size';
    // Validation
    protected $validationRules = [
        'size_id' => 'permit_empty',
        'size_name' => 'required|alpha_numeric_space|max_length[255]|is_unique[size.size_name,size_id,{size_id}]',
    ];
    protected $validationMessages = [
        'size_name' => [
            'required' => 'Size name is required.',
            'alpha_numeric_space' => 'The Size cannot contain special characters.',

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
    protected function alpha_numeric_space(string $str): bool
    {
        return preg_match('/^[a-zA-Z0-9\s]+$/', $str) === 1;
    }
}
