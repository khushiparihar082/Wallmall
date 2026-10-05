<?php

namespace App\Models;

use App\Models\FunctionModel;

class BlogPostModel extends FunctionModel
{
    protected $table = 'blog';
    protected $primaryKey = 'blog_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'blog_id',
        'blog_views_count',
        'blog_likes_count',
        'blog_title',
        'blog_short_content',
        'blog_author_name',
        'blog_long_content',
        'published_at',
        'blog_featured_image',
        'blog_status',
        'user_id',
        'blog_seo_title',
        'blog_seo_keyword',
        'blog_seo_description',
        'blog_alt_text'
    ];
    protected $messageAlias = "Blog";

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
        'blog_id' => 'permit_empty|integer',
        'blog_title' => 'required|max_length[255]|is_unique[blog.blog_title,blog_id,{blog_id}]',
        'blog_author_name' => 'permit_empty|max_length[255]',
        'blog_short_content' => 'permit_empty|string',
        'blog_long_content' => 'permit_empty|string',
        'blog_featured_image' => 'permit_empty|string|max_length[255]',
        'blog_status' => 'required|in_list[draft,published]',
        'user_id' => 'permit_empty|integer|is_not_unique[user.user_id]',
        'blog_views_count' => 'permit_empty',
        'published_at' => 'permit_empty',
        'blog_likes_count' => 'permit_empty',
        'blog_seo_title' => "permit_empty|max_length[60]",
        'blog_seo_keyword' => "permit_empty",
        'blog_seo_description' => "permit_empty|max_length[170]",
        'blog_alt_text' => 'permit_empty',
    ];

    protected $validationMessages = [
        'blog_author_name' => [
            'alpha_space' => 'Blog Author Names cannot contain special characters or numbers.'
        ],
        'blog_seo_title' => [
            'alpha_space' => 'Blog Meta tage cannot contain special characters or numbers.'
        ],
        'blog_title' => [
            'required' => 'Headline is required',
            'alpha_space' => 'Fullname cannot contain special characters or numbers.',
            'max_length' => 'Headline cannot exceed 255 characters',
            'is_unique' => 'This Headline is already taken'
        ],
        'blog_short_content' => [
            'required' => 'Short content is required',
            'string' => 'Short content must be a valid string'
        ],
        'blog_long_content' => [
            'required' => 'Long content is required',
            'string' => 'Long content must be a valid string'
        ],
        'blog_featured_image' => [
            'string' => 'Featured image must be a valid string',
            'max_length' => 'Featured image URL cannot exceed 255 characters'
        ],
        'blog_status' => [
            'required' => 'Status is required',
            'in_list' => 'Status must be either draft or published'
        ],
        'user_id' => [
            'required' => 'User ID is required',
            'integer' => 'User ID must be a valid integer'
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
        $this->addParentJoin('user_id', $this->getUserModel(), 'left', ['fullname']);
    }
    protected function alpha_space(string $str): bool
    {
        return preg_match('/^[a-zA-Z\s]+$/', $str) === 1;
    }
}
