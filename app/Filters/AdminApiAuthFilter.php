<?php

namespace App\Filters;

use ApiResponseStatusCode;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Traits\CommonTraits;

class AdminApiAuthFilter implements FilterInterface
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
        //  get Session data
        $response = service('response');
        $session = session();
        $session_data = $session->get();
        if (!isset($session_data['user_id']) || empty($session_data['user_id'])) {
            // get Header Authtication
            $token = (array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) ? $_SERVER['HTTP_AUTHORIZATION'] : null;
            if (empty($token)) {
                // create response instance
                return formatApiResponse($request, $response, ApiResponseStatusCode::UNAUTHORIZED, ' Required', [], ['error' => 'AUTHORIZATION Token Required']);
            }
            $userdata = checkJwtTokenDecode($token, $_ENV['JWT_SECRET_KEY']);
            if (empty($userdata)) {
                return formatApiResponse($request, $response, ApiResponseStatusCode::UNAUTHORIZED, 'Login Required', [], ['error' => 'Invalid AUTHORIZATION Token Required']);
            }
            $userdata['token'] = $token;
            $userdata['logged_in'] = true;
            $session = \Config\Services::session();
            $session->set($userdata);
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
        //
    }
}
