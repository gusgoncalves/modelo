<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class System extends BaseConfig
{
    public string $name;
    public string $logo;

    public function __construct()
    {
        $this->name = env('app.systemName', 'Sistema');
        $this->logo = env('app.systemLogo', 'default-logo.png');
    }
}
