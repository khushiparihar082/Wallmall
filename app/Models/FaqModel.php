<?php

namespace App\Models;

use App\Models\FunctionModel;

class FaqModel extends FunctionModel
{
    protected $table            = 'faq';
    protected $primaryKey       = 'faq_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['faq_id', 'faq_status', 'faq_question', 'faq_answer', 'created_at', 'updated_at'];

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
        'faq_id'   => 'permit_empty',
        'faq_status'   => 'permit_empty|in_list[draft,published]',
        'faq_question' => 'permit_empty',
        'faq_answer'   => 'permit_empty',
    ];

    protected $validationMessages = [
        'faq_status' => [
            'required' => 'The FAQ status is required.',
            'in_list'  => 'The status must be either "draft" or "published".',
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
}
