<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use ApiResponseStatusCode;
use App\Traits\CommonTraits;
use DateTime;

class EcommerceApiAuthFilter implements FilterInterface
{
    use CommonTraits;
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Set CORS headers to allow API requests from any origin
        $response = service('response');
        if ($_SERVER['REQUEST_METHOD'] == 'options') {
            // Handle preflight request
            return $response->setStatusCode(200);
        }

        $session = session();
        $session_data = $session->get();
        if (!isset($session_data['customer_id']) || empty($session_data['customer_id'])) {
            // Get the Authorization header token
            $token = (array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) ? $_SERVER['HTTP_AUTHORIZATION'] : null;

            if (empty($token)) {
                // If no token, return unauthorized response
                return formatApiResponse($request, $response, ApiResponseStatusCode::UNAUTHORIZED, 'Please Login First', [], ['error' => 'AUTHORIZATION Token Required']);
            } else {
                // Extract the token part from the Authorization header
                $token = explode(' ', $token)[1];
            }
            $customer_token_exists = $this->getCustomerTokenModel()->where('token', trim($token))->first();

            if (empty($customer_token_exists)) {
                return formatApiResponse($request, $response, ApiResponseStatusCode::UNAUTHORIZED, 'Please Login First', [], ['error' => 'AUTHORIZATION Token Not Found In DB']);
            }

            $current_date = new DateTime('now');
            if ($customer_token_exists['expiry'] > $current_date) {
                return formatApiResponse($request, $response, ApiResponseStatusCode::UNAUTHORIZED, 'Please Login First', [], ['error' => 'AUTHORIZATION Token Expired']);
            }

            $customer_data = checkJwtTokenDecode($token, $_ENV['JWT_SECRET_KEY']);

            if (empty($customer_data)) {
                return formatApiResponse($request, $response, ApiResponseStatusCode::UNAUTHORIZED, 'Please Login First', [], ['error' => 'Invalid Token']);
            }

            $customer_data['token'] = $token;
            $customer_data['logged_in'] = true;

            $session->set($customer_data);
            $result = $this->getCustomerModel()
             ->update($_SESSION['customer_id'],['last_activity_date' => date('Y-m-d H:i:s')]);
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
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
