<?php

namespace Database\Seeders\users\typeUser;

use App\Models\User\TypeUser\TypeUser;
use Illuminate\Database\Seeder;

class TypeUserSeed extends Seeder
{
    #Elegir entre entorno de desarrollo o producción
    public function run()
    {
        $this->runDataDefault();
        if (env('APP_ENV') === 'local') {
            $this->runDataFake();
        }
    }

    public function runDataDefault()
    {

        $data = [
            ['name' => 'Administrador'],
            ['name' => 'Personal call center']
        ];

        TypeUser::insert($data);
    }

    public function runDataFake()
    {
    }
}
