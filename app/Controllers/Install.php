<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Install extends BaseController
{
    protected $session;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        //$lock = ROOTPATH . 'public/install.lock';

        $this->session = session();
    }

    public function index()
    {
        // se ainda não fez o check nessa sessão, manda pro check
        if (!$this->session->get('install_checked')) {
            return redirect()->to('/install/check');
        }

        // passou no check, entra na instalação normal
        return view('install/step1_system', [
            'step' => 1,
            'systemName' => 'Instalação',
        ]);
    }
    public function check()
    {
        $checks = [];

        // PHP
        $checks[] = [
            'label' => 'PHP >= 8.1',
            'ok'    => version_compare(PHP_VERSION, '8.1', '>='),
            'value' => PHP_VERSION,
            'required' => true,
        ];

        // Extensões base (quase sempre necessárias)
        $requiredExtensions = [
            'openssl'  => 'OpenSSL (HTTPS/segurança)',
            'curl'     => 'cURL (requisições externas)',
            'intl'     => 'intl (formatação/locale)',
            'mbstring' => 'mbstring (strings UTF-8)',
            'fileinfo' => 'fileinfo (uploads e validações)',
        ];

        foreach ($requiredExtensions as $ext => $label) {
            $checks[] = [
                'label' => "Extensão {$label}",
                'ok'    => extension_loaded($ext),
                'value' => extension_loaded($ext) ? 'OK' : 'Não instalada',
                'required' => true,
            ];
        }

        // Banco: drivers PDO
        $pdoDrivers = class_exists(\PDO::class) ? \PDO::getAvailableDrivers() : [];

        $checks[] = [
            'label' => 'PDO habilitado',
            'ok'    => class_exists(\PDO::class),
            'value' => class_exists(\PDO::class) ? 'OK' : 'Não habilitado',
            'required' => true,
        ];

        $checks[] = [
            'label' => 'PDO MySQL (pdo_mysql)',
            'ok'    => in_array('mysql', $pdoDrivers, true),
            'value' => in_array('mysql', $pdoDrivers, true) ? 'OK' : 'Não instalado',
            'required' => true,
        ];

        $checks[] = [
            'label' => 'PDO PostgreSQL (pdo_pgsql)',
            'ok'    => in_array('pgsql', $pdoDrivers, true),
            'value' => in_array('pgsql', $pdoDrivers, true) ? 'OK' : 'Não instalado',
            'required' => true,
        ];

        // Drivers nativos (não são obrigatórios, mas ajudam)
        $checks[] = [
            'label' => 'MySQLi (opcional)',
            'ok'    => extension_loaded('mysqli'),
            'value' => extension_loaded('mysqli') ? 'OK' : 'Não instalado',
            'required' => false,
        ];

        $checks[] = [
            'label' => 'PgSQL (opcional)',
            'ok'    => extension_loaded('pgsql'),
            'value' => extension_loaded('pgsql') ? 'OK' : 'Não instalado',
            'required' => false,
        ];

        // LDAP (só obrigatório se for usar AD, mas já avisamos aqui)
        $checks[] = [
            'label' => 'LDAP (necessário se usar autenticação AD)',
            'ok'    => extension_loaded('ldap'),
            'value' => extension_loaded('ldap') ? 'OK' : 'Não instalado',
            'required' => false,
        ];

        // Permissões
        $checks[] = [
            'label' => 'Pasta writable/ com permissão de escrita',
            'ok'    => is_writable(WRITEPATH),
            'value' => is_writable(WRITEPATH) ? 'OK' : 'Sem permissão',
            'required' => true,
        ];

        $checks[] = [
            'label' => 'Pasta writable/cache com permissão',
            'ok'    => is_writable(WRITEPATH . 'cache'),
            'value' => is_writable(WRITEPATH . 'cache') ? 'OK' : 'Sem permissão',
            'required' => true,
        ];

        $checks[] = [
            'label' => 'Pasta writable/session com permissão',
            'ok'    => is_writable(WRITEPATH . 'session'),
            'value' => is_writable(WRITEPATH . 'session') ? 'OK' : 'Sem permissão',
            'required' => true,
        ];

        $checks[] = [
            'label' => 'Pasta public/assets/img com permissão',
            'ok'    => is_dir(ROOTPATH . 'public/assets/img') && is_writable(ROOTPATH . 'public/assets/img'),
            'value' => (is_dir(ROOTPATH . 'public/assets/img') && is_writable(ROOTPATH . 'public/assets/img')) ? 'OK' : 'Sem permissão ou não existe',
            'required' => true,
        ];

        // .env
        $envPath = ROOTPATH . '.env';

        $checks[] = [
            'label' => 'Permissão para criar/editar .env',
            'ok'    => (!file_exists($envPath) && is_writable(ROOTPATH)) || (file_exists($envPath) && is_writable($envPath)),
            'value' => file_exists($envPath) ? (is_writable($envPath) ? 'OK' : 'Sem permissão') : 'Será criado',
            'required' => true,
        ];
        
        $canInstall = true;

        foreach ($checks as $c) {
            if ($c['required'] === true && $c['ok'] === false) {
                $canInstall = false;
                break;
            }
        }

        // Resultado final
        $allOk = !in_array(false, array_column($checks, 'ok'), true);

         if ($allOk) {
            $this->session->set('install_checked', true);
        } else {
            $this->session->remove('install_checked');
        }

        return view('install/check', [
            'checks' => $checks,
            'allOk'  => $allOk,
            'canInstall' => $canInstall,
        ]);
    }

    public function system()
    {
        $logoName = null;
        $file = $this->request->getFile('system_logo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $logoName = 'logo_' . time() . '.' . $file->getExtension();
            $file->move(ROOTPATH . 'public/assets/img', $logoName);
        }
        $this->session->set([
            'system_name' => $this->request->getPost('system_name'),
            'system_logo' => $logoName,
            'base_url'    => $this->request->getPost('base_url'),
            'auth_driver' => $this->request->getPost('auth_driver')
        ]);

        return view('install/step2_database');
    }

    public function database()
    {
        $this->session->set($this->request->getPost());
        return view('install/step3_admin');
    }

    public function admin()
    {
        $adminData = [
            'matricula' => $this->request->getPost('matricula'),
            'nome'      => $this->request->getPost('nome'),
            'cpf'       => $this->request->getPost('cpf'),
            'email'     => $this->request->getPost('email'),
            'permissao' => $this->request->getPost('permissao'),
            'senha'     => $this->request->getPost('senha'), // pode ser null
        ];
        file_put_contents(
            WRITEPATH . 'install_admin.json',
            json_encode($adminData, JSON_PRETTY_PRINT)
        );
        $s = $this->session;

        $driver = $s->get('db_driver');
        $port = $driver === 'Postgre' ? 5432 : 3306;

        if ($driver === 'Postgre') {
            $charset  = 'UTF8';
            $collate  = '';
        } else {
            $charset  = 'utf8mb4';
            $collate  = 'utf8mb4_unicode_ci';
        }
        // GERA .env
        $env = <<<ENV

        #--------------------------------------------------------------------
        # ENVIRONMENT
        #--------------------------------------------------------------------

        CI_ENVIRONMENT = development

        #--------------------------------------------------------------------
        # AUTH
        #--------------------------------------------------------------------

        auth.driver = '{$s->get('auth_driver')}'
        auth.ldap.host = 172.16.12.10
        auth.ldap.domain = pmpg.local

        #--------------------------------------------------------------------
        # APP
        #--------------------------------------------------------------------

        app.baseURL = '{$s->get('base_url')}'
        app.appTimezone = 'America/Sao_Paulo'
        app.forceGlobalSecureRequests = false
        app.CSPEnabled = false

        app.systemName = '{$s->get('system_name')}'
        app.systemLogo = '{$s->get('system_logo')}'
        
        #--------------------------------------------------------------------
        # SECURITY
        #--------------------------------------------------------------------

        security.csrfProtection = 'session'
        security.tokenRandomize = true        

        database.default.hostname = '{$s->get('db_host')}'
        database.default.database = '{$s->get('db_name')}'
        database.default.username = '{$s->get('db_user')}'
        database.default.password = '{$s->get('db_pass')}'
        database.default.DBDriver = '{$driver}'
        database.default.port = {$port}
        database.default.charset = {$charset}
        database.default.DBCollat = '{$collate}'
        database.default.pConnect = false
        database.default.DBDebug = true

        #--------------------------------------------------------------------
        # SESSION
        #--------------------------------------------------------------------

        session.driver = 'CodeIgniter\Session\Handlers\FileHandler'
        session.cookieName = ci_session
        session.expiration = 7200
        session.savePath = writable/session
        session.matchIP = false
        session.regenerateDestroy = false
        ENV;

        file_put_contents(ROOTPATH . '.env', trim($env));

        // BLOQUEIA REINSTALAÇÃO
       file_put_contents(ROOTPATH . 'public/install.lock', 'env_created');

        return redirect()->to('/install/run');
    }

    public function run()
    {
        if (!file_exists(ROOTPATH . '.env')) {
            die('Arquivo .env não encontrado');
        }
        // garante que o .env existe
        if (!file_exists(ROOTPATH . 'public/install.lock')) {
            return redirect()->to('/install');
        }
        if (file_get_contents(ROOTPATH . 'public/install.lock') !== 'env_created') {
            return redirect()->to('/login');
        }

        // roda migrations
        $migrate = \Config\Services::migrations();
        $migrate->latest();

         // dados do admin salvos antes
        $adminFile = WRITEPATH . 'install_admin.json';

        if (!file_exists($adminFile)) {
            die('Dados do administrador não encontrados.');
        }
        $admin = json_decode(file_get_contents($adminFile), true);
        
        $matricula = !empty($admin['matricula'])
            ? trim($admin['matricula'])
            : trim($admin['cpf']);

        if(!$matricula){
            die('Matricula é obrigatória para usuários LDAP.');
        }

        $db = \Config\Database::connect();
        $authDriver = env('auth.driver');

        $data = [
            'matricula' => $matricula,
            'nome'      => $admin['nome'],
            'cpf'       => $admin['cpf'],
            'email'     => $admin['email'],
            'permissao' => $admin['permissao'],
        ];
        if ($authDriver ==='database'){
            if (empty($admin['senha'])) {
                throw new \RuntimeException('Senha do administrador não informada');
            }
            $data['senha'] = password_hash($admin['senha'],PASSWORD_DEFAULT);
        }

        $db->table('usuarios')->insert($data);
    
        // finaliza instalação
        file_put_contents(ROOTPATH . 'public/install.lock', 'instalado');

        // limpa sessão
        unlink($adminFile);

        return redirect()->to('/install/success');
    }

    public function success()
    {
        return view('install/success');
    }
}
