<?php

namespace App\Models;

use App\Models\FunctionModel;

class CategoryTypeModel extends FunctionModel
{
    protected $table            = 'category_type';
    protected $primaryKey       = 'category_type_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['category_type_id', 'category_type_seo_title', 'category_type_alt_text', 'category_type_name', 'category_type_image', 'category_type_description', 'is_active', 'file', 'category_type_seo_description', 'category_type_seo_keyword','category_type_icon'];

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
    protected $messageAlias = 'Category_type';


    // Validation
    protected $validationRules = [
        'category_type_id' => 'permit_empty',
        'category_type_name' => 'required|max_length[255]|is_unique[category_type.category_type_name,category_type_id,{category_type_id}]',
        'category_type_description' => 'permit_empty',
        'category_type_seo_description' => 'permit_empty|max_length[170]',
        'category_type_seo_keyword' => 'permit_empty',
        'category_type_seo_title' => 'permit_empty|max_length[60]',
        'category_type_image' => 'permit_empty',
        'category_type_alt_text' =>  'permit_empty',
        'is_active' => 'required|in_list[0,1]',
        'category_type_icon' => 'permit_empty'
    ];



    protected $validationMessages = [
        'category_type_name' => [
            'required' => 'Category type name is required.',
            'max_length' => 'Max 255 characters allowed.',
            'alpha_space' => 'The Category name cannot contain special characters or numbers.'
        ],
        'category_type_seo_description' => [
            'max_length' => 'Max 120 characters allowed.'
        ],
        'category_type_seo_keyword' => [
            'max_length' => 'Max 120 characters allowed.'
        ],
        'category_type_seo_title' => [
            'max_length' => 'Max 120 characters allowed.'
        ],
        'is_active' => [
            'required' => 'Is active status is required.',
            'in_list' => 'Must be 0 or 1.'
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
    // Custom validation rules
    protected function alpha_space(string $str): bool
    {
        return preg_match('/^[a-zA-Z\s]+$/', $str) === 1;
    }
}
