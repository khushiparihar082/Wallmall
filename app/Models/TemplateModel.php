<?php

namespace App\Models;

use App\Models\FunctionModel;

class TemplateModel extends FunctionModel
{
    protected $table = 'template';
    protected $primaryKey = 'template_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'template_id',
        'template_type',
        'template_heading',
        'email_send',
        'email_subject',
        'email_cc',
        'email_body',
        'email_attachment',
        'sms_send',
        'sms_template_name',
        'sms_dlt_id',
        'sms_message',
        'template_placeholder',
    ];

    // Validation rules (optional)
    protected $validationRules = [
        'template_id' => 'permit_empty',
        'template_type' => 'required|min_length[3]|is_unique[template.template_type,template_id,{template_id}]',
        'template_heading' => 'required|min_length[3]|is_unique[template.template_heading,template_id,{template_id}]',
        'email_send' => 'required',
        'sms_send' => 'required',
    ];
    protected $booleanFields = ['email_send', 'sms_send', 'email_attachment'];

    // Optional: Soft deletes (if needed)
    protected $useSoftDeletes = false;

    // Optional: Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['updateBooleanFields'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['updateBooleanFields'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    public function __construct()
    {
        parent::__construct();
    }
    public function getTemplateDataByType(string $template_type): array
    {
        return $this->where('template_type', $template_type)->first() ?? [];
    }
}
