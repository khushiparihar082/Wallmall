<?php

namespace App\Models;

use App\Models\FunctionModel;

class CategoryModel extends FunctionModel
{
    protected $table            = 'category';
    protected $primaryKey       = 'category_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['category_id','category_seo_title','category_alt_text', 'category_name', 'category_description', 'category_type_id', 'is_active' ,'category_seo_description','category_image','category_seo_keyword'];

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
    protected $messageAlias = 'Category';

    // Validation
    protected $validationRules = [
        'category_name' => 'required|max_length[255]',
        'category_description' => 'permit_empty',
        'category_seo_description' =>'permit_empty|max_length[170]',
        'category_seo_keyword' =>'permit_empty',
        'category_seo_title' =>'permit_empty|max_length[60]',
        'category_type_id' => 'required|integer|is_not_unique[category_type.category_type_id]',
        'is_active' => 'required|in_list[0,1]',
        'category_image' => 'permit_empty',
        'category_alt_text' => 'permit_empty'
    ];

    protected $validationMessages = [
        'category_name' => [
            'required' => 'Category name is required.',
            'max_length' => 'Max 255 characters.',
            'alpha_space' => 'The Category name cannot contain special characters or numbers.'

        ],
        'category_type_id' => [
            'required' => 'Category type ID is required.',
            'integer' => 'Must be an integer.',
            'is_not_unique' => 'Selected category type does not exist.'
        ],
        'category_seo_description' => [
            'max_length' => 'Max 120 characters.'
        ],
        'category_seo_keyword' => [
            'max_length' => 'Max 120 characters.'
        ],
        'category_seo_title' => [
            'max_length' => 'Max 120 characters.'
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
        $this->addParentJoin('category_type_id',$this->getCategoryTypeModel(),'left',['category_type_name']);
    }
     // Custom validation rules
     protected function alpha_space(string $str): bool
     {
         return preg_match('/^[a-zA-Z\s]+$/', $str) === 1;
     }

}
