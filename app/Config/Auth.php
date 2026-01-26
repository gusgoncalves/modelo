<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Auth extends BaseConfig
{
    public string $driver;
    public string $loginField;
    public array $ldap;

    public function __construct()
    {
        $this->driver = env('auth.driver', 'database');

        $this->loginField = $this->driver === 'ldap' ? 'matricula' :'cpf';
       
        if($this->driver ==='ldap'){
          $this->ldap = [
            'host' => env('auth.ldap.host'),
            'domain' => env('auth.ldap.domain')
          ];
        }
    }
}