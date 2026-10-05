<?php

namespace App\Models;

use App\Models\FunctionModel;

class ColorModel extends FunctionModel
{
    protected $table            = 'color';
    protected $primaryKey       = 'color_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['color_id', 'color_name', 'color_code', 'color_alt_text', 'color_image'];

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
        'color_id' => "permit_empty",
        'color_name' => 'required|max_length[255]|is_unique[color.color_name,color_id,{color_id}]',
        'color_code' => 'required',
        'color_image' => 'permit_empty',
        'color_alt_text' => 'permit_empty',
    ];

    protected $validationMessages = [
        'color_name' => [
            'required' => 'color name is required.',
            'max_length' => 'color name must not exceed 255 characters.',
            'is_unique' => 'The color name already exists.',
            'alpha_space' => 'The Color name cannot contain special characters or numbers.'

        ],
        'color_code' => [
            'required' => 'color name is required.'
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
    protected $messageAlias = "Color";
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
    // Custom validation rules
    protected function alpha_space(string $str): bool
    {
        return preg_match('/^[a-zA-Z\s]+$/', $str) === 1;
    }
}
