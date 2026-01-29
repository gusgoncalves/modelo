<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_BR');

        $db = \Config\Database::connect();
        $builder = $db->table('usuarios');

        $total = 22000;
        $batchSize = 200;

        $data = [];

        for ($i = 1; $i <= $total; $i++) {

            $data[] = [
                'nome'       => $faker->name(),
                'cpf'        => $faker->numerify('###########'),
                'matricula'  => $faker->unique()->numerify('############'),
                'email'      => $faker->unique()->safeEmail(),
                'senha'      => password_hash('123456', PASSWORD_DEFAULT),
                'ativo'      => 1,
            ];

            if ($i % $batchSize === 0) {
                $builder->insertBatch($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            $builder->insertBatch($data);
        }

        echo "✅ $total usuários inseridos com insertBatch.\n";
    }
}
