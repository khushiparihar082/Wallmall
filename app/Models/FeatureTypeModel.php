<?php

namespace App\Models;

use App\Models\FunctionModel;

class FeatureTypeModel extends FunctionModel
{
    protected $table            = 'feature_type';
    protected $primaryKey       = 'feature_type_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['feature_type_id', 'feature_type_seo_title', 'feature_type_alt_text', 'feature_type_name', 'feature_type_image', 'feature_type_description', 'is_active', 'file', 'feature_type_seo_description', 'feature_type_seo_keyword'];

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
    protected $messageAlias = 'Feature_type';

    // Validation
    protected $validationRules = [
        'feature_type_id' => 'permit_empty',
        'feature_type_name' => 'required|max_length[255]|is_unique[feature_type.feature_type_name,feature_type_id,{feature_type_id}]',
        'feature_type_description' => 'permit_empty',
        'feature_type_seo_description' => 'permit_empty|max_length[170]',
        'feature_type_seo_keyword' => 'permit_empty',
        'feature_type_seo_title' => 'permit_empty|max_length[60]',
        'feature_type_image' => 'permit_empty',
        'feature_type_alt_text' => 'permit_empty',
        'is_active' => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'feature_type_name' => [
            'required' => 'Feature type name is required.',
            'max_length' => 'Max 255 characters.',
            'alpha_space' => 'The Feature Type name cannot contain special characters or numbers.'

        ],
        'feature_type_seo_description' => [
            'max_length' => 'Max 120 characters.'
        ],
        'feature_type_seo_keyword' => [
            'max_length' => 'Max 120 characters.'
        ],
        'feature_type_seo_title' => [
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
    // Custom validation rules

    public function __construct()
    {
        parent::__construct();
    }
    protected function alpha_space(string $str): bool
    {
        return preg_match('/^[a-zA-Z\s]+$/', $str) === 1;
    }
}
