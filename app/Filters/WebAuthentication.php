<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class WebAuthentication implements FilterInterface
{
    /**
     * Handles redirection if the user is not logged in.
     * This runs before the controller is executed.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session(); // Use session() helper

        // Check if the user is logged in; if not, redirect to the login page
        if (!$session->get('logged_in_apps')) {
            return redirect()->to(base_url('auth'));
        }
    }

    /**
     * Modify response headers after the controller has executed.
     * No redirect should be done here.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $session = session(); // Use session() helper

        // Set cache-control headers only if the user is logged in
        if ($session->get('logged_in_apps')) {
            $response->setCache([
                'no-store' => true,
                'no-cache' => true,
                'must-revalidate' => true,
                'post-check' => 0,
                'pre-check' => 0
            ]);
            $response->setHeader('Pragma', 'no-cache');
            $response->setHeader('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
            // $response->setHeader('Content-Security-Policy', "default-src 'self'; script-src 'self'; object-src 'none'; base-uri 'self';");
        }
    }
}
