<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();
        if(!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        $required = $arguments[0] ?? null;
        if($required && $session->get('role') !== $required) {
            return redirect()->to('/')->with('error','Akses ditolak');
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
