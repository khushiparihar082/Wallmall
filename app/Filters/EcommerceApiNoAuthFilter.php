<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Traits\CommonTraits;
use DateTime;

class EcommerceApiNoAuthFilter implements FilterInterface
{
    use CommonTraits;

    public function before(RequestInterface $request, $arguments = null)
    {
        $response = service('response');
        if ($request->getMethod() === 'options') {
            // Handle preflight request   
            return $response->setStatusCode(200);
        }
        $session = session();
        $session_data = $session->get();
        if (!isset($session_data['customer_id']) || empty($session_data['customer_id'])) {
            $token = $request->getHeaderLine('Authorization');

            if (!empty($token)) {
                $token = explode(' ', $token)[1];
                $customer_token_exists = $this->getCustomerTokenModel()->where('token', trim($token))->first();
                if (!empty($customer_token_exists)) {
                    $current_date = new DateTime('now');
                    if ($customer_token_exists['expiry'] < $current_date) {
                        $customer_data = $this->checkJwtTokenDecode($token);
                        if (!empty($customer_data)) {
                            $customer_data = (array) $customer_data;
                            $customer_data['token'] = $token;
                            $customer_data['logged_in'] = true;
                            $session->set($customer_data);
                            if (isset($_SESSION['customer_id']) && !empty($_SESSION['customer_id'])) {
                                $result = $this->getCustomerModel()
                                    ->update($_SESSION['customer_id'], ['last_activity_date' => date('Y-m-d H:i:s')]);
                            }
                        }
                    }
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $session = \Config\Services::session();
        $session->destroy();
    }

    protected function checkJwtTokenDecode($jwt)
    {
        try {
            return \Firebase\JWT\JWT::decode($jwt, new \Firebase\JWT\Key($_ENV['JWT_SECRET_KEY'], 'HS256'));
        } catch (\Throwable $th) {
            return null;
        }
    }
}
