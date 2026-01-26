<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $lock = ROOTPATH . 'public/install.lock';
        $uri  = trim(service('uri')->getPath(), '/'); 

       
        if (!file_exists($lock)) {
            if (!str_starts_with($uri, 'install')) {
                return redirect()->to('/install');
            }
            return null;
        }

        $status = trim(file_get_contents($lock));

       
        if ($status === 'instalado' && str_starts_with($uri, 'install')) {
            return redirect()->to('/');
        }

        
        if ($status === 'instalado') {

            // rotas públicas
            if (
                $uri === '' ||
                $uri === '/' ||
                str_starts_with($uri, 'auth') ||
                str_starts_with($uri, 'assets')
            ) {
                return null;
            }

            if (!session()->get('Logado')) {
                return redirect()->to('/');
            }
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
