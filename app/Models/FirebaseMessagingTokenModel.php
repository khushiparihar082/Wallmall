<?php

namespace App\Models;

use App\Models\FunctionModel;

class FirebaseMessagingTokenModel extends FunctionModel
{
    protected $table            = 'firebase_messaging_tokken';
    protected $primaryKey       = 'firebase_messaging_token_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['firebase_messaging_token_id', 'access_type', 'access_id', 'token'];

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
    protected $validationRules      = [
        'firebase_messaging_token_id' => "permit_empty",
        'access_type' => "required|in_list[user,customer,other]",
        'access_id' => "required",
        'token' => "required|is_unique[firebase_messaging_tokken.token,firebase_messaging_token_id,{firebase_messaging_token_id}]",
    ];
    protected $validationMessages   = [];
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
