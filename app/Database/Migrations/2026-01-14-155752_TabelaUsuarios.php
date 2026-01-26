<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'=> true,
                'auto_increment' => true,
            ],
            'matricula' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true,
                null
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'cpf' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'unique' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'permissao' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'senha' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                null,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('usuarios');

    }

    public function down()
    {
        $this->forge->dropTable('usuarios', true);
    }
}