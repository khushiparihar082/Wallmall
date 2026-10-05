<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
  public function login()
  {
    $username = get_cookie('username');
    $rememberme = (!empty($username)) ? true : false;
    $data = ['username' => $username, 'rememberme' => $rememberme];
    return view('AdminPanelNew/pages/Auth/login', $data);
  }
  public function logout()
  {
    // Clear Session and Redirect to Login Page
    session()->destroy();
    return $this->response->redirect(route_to('admin_login_page'));
  }
  public function forgetPassword()
  {
  
    return view('AdminPanelNew/pages/Auth/forget_password');
  }
}
