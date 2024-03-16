<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Llamado de clases para la data inicial y/o ficticia de la base de datos
     */
    public function run()
    {
        $this->seedUserRelatedData();
    }

    # Usuarios
    private function seedUserRelatedData()
    {
        $this->call([
            \Database\Seeders\users\typeUser\TypeUserSeed::class,
            \Database\Seeders\users\UserSeed::class,
        ]);
    }
}
