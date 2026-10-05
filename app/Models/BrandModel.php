<?php

namespace App\Models;

use App\Models\FunctionModel;

class BrandModel extends FunctionModel
{
    protected $table            = 'brand';
    protected $primaryKey       = 'brand_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['brand_id', 'brand_name', 'brand_seo_title', 'brand_alt_text', 'brand_image', 'brand_description', 'is_active', 'file', 'brand_seo_description', 'brand_seo_keyword'];

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
    protected $messageAlias = 'Brand';

    // Validation
    protected $validationRules = [
        'brand_id' => 'permit_empty',
        'brand_name' => 'required|max_length[255]|is_unique[brand.brand_name,brand_id,{brand_id}]',
        'brand_description' => 'permit_empty',
        'brand_seo_description' => 'permit_empty|max_length[170]',
        'brand_seo_keyword' => 'permit_empty',
        'brand_seo_title' => 'permit_empty|max_length[60]',
        'brand_image' => 'permit_empty',
        'brand_alt_text' => 'permit_empty',
        'is_active' => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'brand_name' => [
            'required' => 'Brand name is required.',
            'max_length' => 'Max 255 characters.',
            'alpha_space' => 'The coupon name cannot contain special characters or numbers.'
        ],
        'brand_description' => [
            'max_length' => 'Max 120 characters.'
        ],
        'brand_seo_description' => [
            'max_length' => 'Max 120 characters.'
        ],
        'brand_seo_keyword' => [
            'max_length' => 'Max 120 characters.'
        ],
        'brand_seo_title' => [
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
    }

    // Custom validation rules
    protected function alpha_space(string $str): bool
    {
        return preg_match('/^[a-zA-Z\s]+$/', $str) === 1;
    }
}
