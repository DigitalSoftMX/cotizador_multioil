<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => "Administrador", 'description' => "Usuarion con nivel de administracion total."]);
        Role::create(['name' => 'Cliente', 'description' => "Usuarion con nivel medio de acceso."]);
        Role::create(['name' => 'Ventas', 'description' => 'Usuario con nivel medio de acceso']);
    }
}
