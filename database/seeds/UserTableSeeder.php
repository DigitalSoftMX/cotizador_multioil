<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Administrador',
            'app_name' => 'de',
            'apm_name' => 'prueba',
            'password' => bcrypt('secret'),
            'email' => 'administrador@correo.com',
            'active' => 1,

        ]);
        $user->roles()->attach(1);
    }
}
