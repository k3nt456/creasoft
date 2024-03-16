<?php

namespace Database\Seeders\users;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class UserSeed extends Seeder
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
    }

    public function runDataFake()
    {

        $now = now();

        $data = [
            [
                'id'                    => '6bd0d9bc-521b-4731-8a42-6c7399f96400',
                'dni'                   => '71530135',
                'username'              => 'kento',
                'name'                  => 'Kent',
                'surname'               => 'Olortigue Jimenez',
                'email'                 => 'kentolortigue@gmail.com',
                'cellphone'             => '959653106',
                'birthdate'             => '1999/07/24',
                'password'              => bcrypt('demo'),
                'encrypted_password'    => Crypt::encryptString('demo'),
                'email_confirmation'    => 1,
                'idtype_user'           => 1,
                'created_at'            => $now
            ],
        ];

        User::insert($data);
    }
}
