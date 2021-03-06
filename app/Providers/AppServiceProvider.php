<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        date_default_timezone_set('America/Mexico_City');
        view()->composer('*', function ($view) {
            $datos = [];
            if (Auth::check()) {
                $user_rol = Auth::user();
                $roles = DB::table('menu_role')->where('role_id', $user_rol->roles[0]->id)->get();

                foreach ($roles as $rol) {
                    $menus = DB::table('menus')->where('id', $rol->menu_id)->get();
                    array_push($datos, $menus);
                }
                View::share('menus', $datos);
            } else {
                $view->with('menus', null);
            }
        });

        Schema::defaultStringLength(191);
    }
}
