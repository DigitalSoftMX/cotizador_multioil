<?php

use Illuminate\Database\Seeder;
use App\Menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = Menu::create(['name_modulo' => 'dashboard', 'desplegable' => 0, 'ruta' => 'home', 'id_role' => 1, 'icono' => 'dashboard']);
        $menu->roles()->attach([1, 2, 3]);
        $menu = Menu::create(['name_modulo' => 'Usuarios', 'desplegable' => 0, 'ruta' => 'users', 'id_role' => 1, 'icono' => 'perm_identity']);
        $menu->roles()->attach([1]);
        $menu = Menu::create(['name_modulo' => 'Empresas', 'desplegable' => 0, 'ruta' => 'companies', 'id_role' => 1, 'icono' => 'domain']);
        $menu->roles()->attach([1]);
        $menu = Menu::create(['name_modulo' => 'Terminales', 'desplegable' => 0, 'ruta' => 'terminals', 'id_role' => 1, 'icono' => 'local_gas_station']);
        $menu->roles()->attach([1]);
        $menu = Menu::create(['name_modulo' => 'Fee', 'desplegable' => 0, 'ruta' => 'fits', 'id_role' => 1, 'icono' => 'import_export']);
        $menu->roles()->attach([1]);
        $menu = Menu::create(['name_modulo' => 'Captura de precios', 'desplegable' => 0, 'ruta' => 'prices', 'id_role' => 1, 'icono' => 'paid']);
        $menu->roles()->attach([1]);
        $menu = Menu::create(['name_modulo' => 'Crea un pedido', 'desplegable' => 0, 'ruta' => 'orders', 'id_role' => 1, 'icono' => 'local_atm']);
        $menu->roles()->attach([1, 2]);
        $menu = Menu::create(['name_modulo' => 'Validación de pedidos', 'desplegable' => 0, 'ruta' => 'validations', 'id_role' => 1, 'icono' => 'fact_check']);
        $menu->roles()->attach([1, 2]);
        $menu = Menu::create(['name_modulo' => 'Pedido Semanal', 'desplegable' => 0, 'ruta' => 'pedidos', 'id_role' => 1, 'icono' => 'paid']);
        $menu->roles()->attach([1, 2]);
        $menu = Menu::create(['name_modulo' => 'Validacion P semanal', 'desplegable' => 0, 'ruta' => 'validacion', 'id_role' => 1, 'icono' => 'paid']);
        $menu->roles()->attach([1, 2]);
        $menu = Menu::create(['name_modulo' => 'Flete', 'desplegable' => 0, 'ruta' => 'levels', 'id_role' => 1, 'icono' => 'local_atm']);
        $menu->roles()->attach([1, 2, 3]);
        $menu = Menu::create(['name_modulo' => 'Estado de cuenta', 'desplegable' => 0, 'ruta' => 'getshopping', 'id_role' => 1, 'icono' => 'article']);
        $menu->roles()->attach([1, 2, 3]);
    }
}
