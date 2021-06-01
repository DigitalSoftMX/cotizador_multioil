<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Menu;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = "Administrador";
        $role->description = "Usuarion con nivel de administracion total.";
        $role->save();
        $role->menus()->attach(1);


        $role = new Role();
        $role->name = "Invitado";
        $role->description = "Usuarion con nivel bajo de acceso.";
        $role->save();

        $role = new Role();
        $role->name = "Vendedor";
        $role->description = "Usuario con nivel medio de acceso";
        $role->save();

    }
}
