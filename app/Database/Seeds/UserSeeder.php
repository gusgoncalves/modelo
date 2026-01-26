<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
     public function setAdmin(array $data)
    {
        $this->admin = $data;
        return $this;
    }

    public function run()
    {
        if (empty($this->admin)) {
            throw new \RuntimeException('Dados do admin não foram definidos no Seeder.');
        }
       $this->db->table('usuarios')->insert([
            'matricula' => $this->admin['login'],
            'nome'      => $this->admin['nome'],
            'cpf'       => $this->admin['cpf'],
            'email'     => $this->admin['email'],
            'permissao' => $this->admin['permissao'],
            'senha'     => password_hash('123456', PASSWORD_DEFAULT),
        ]);
    }
}
