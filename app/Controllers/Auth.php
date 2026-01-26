<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\System;

class Auth extends BaseController
{
    protected $session;
    protected $usuarioModel;

    public function __construct()
    {
        // $this->myrequest = service('request');
        $this->session = session();
        $this->usuarioModel = new UserModel();
    }

    public function index()
    {
        $system = new System();
        $auth = config('Auth');
        return view('auth/login', ['logo' => $system->logo, 'systemName' => $system->name,'authDriver' => $auth->driver]);
    }

    public function logar()
    {
        $auth  = config('Auth');
        $login = trim($this->request->getPost('login'));
        $senha = (string) $this->request->getPost('senha');

        if ($login === '' || $senha === '') {
            return redirect()->back()
                ->with('error', 'Informe usuário e senha.');
        }

        // LDAP
        if ($auth->driver === 'ldap') {

            if (!$this->loginViaLdap($login, $senha, $auth)) {
                return redirect()->back()
                    ->with('error', 'Usuário ou senha inválidos.');
            }

            // procura usuário local
            $usuario = $this->usuarioModel
                ->where('matricula', $login)
                ->first();

            // cria se não existir
            if (!$usuario) {
                $this->usuarioModel->insert([
                    'matricula' => $login,
                    'cpf'       => $login,
                    'nome'      => $login,
                    'email'     => null,
                    'permissao' => 'usuario',
                    'ativo'     => 1
                ]);

                $usuario = $this->usuarioModel
                    ->where('matricula', $login)
                    ->first();
            }
        }

        // DATABASE
        if ($auth->driver === 'database') {

            $usuario = $this->usuarioModel
                ->where($auth->loginField, $login)
                ->first();

            if (!$usuario || empty($usuario['senha'])) {
                return redirect()->back()
                    ->with('error', 'Usuário ou senha inválidos.');
            }

            if (!password_verify($senha, $usuario['senha'])) {
                return redirect()->back()
                    ->with('error', 'Usuário ou senha inválidos.');
            }
        }

        // LOGIN OK
        $this->session->set([
            'id_usuario' => $usuario['id'],
            'nome'       => $usuario['nome'],
            'permissao'  => $usuario['permissao'],
            'Logado'     => true
        ]);

        return redirect()->to('/dashboard');
    }


    private function loginViaLdap(string $login, string $senha, $auth): bool
    {
        if (empty($auth->ldap['host']) || empty($auth->ldap['domain'])) {
            log_message('error', 'Config LDAP incompleta');
            return false;
        }

        $conn = ldap_connect($auth->ldap['host']);
        if (!$conn) {
            log_message('error', 'Falha ao conectar no LDAP');
            return false;
        }

        ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);

        //$usuario = $auth->ldap['domain'] . '\\' . $login;
        $usuario = $login . '@' .$auth->ldap['domain'];

        if (@ldap_bind($conn, $usuario, $senha)) {
            ldap_unbind($conn);
            return true;
        }

        ldap_unbind($conn);
        return false;
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/');
    }
}
