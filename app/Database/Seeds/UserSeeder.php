<?php

namespace App\Database\Seeds;

use ApiResponseStatusCode;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        $userData = [
            'fullname'   => 'Khushi Parihar',
            'email'      => 'digitalk082@gmail.com',
            'mobile'     => '7974822832',
            'password'   => password_hash('1234', PASSWORD_DEFAULT),
            'user_type'  => 'admin',
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //Template Data
       $response = $userModel->RecordCreate($userData);
    }
}
