<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // get all data from menu.json file
        view()->composer('*', function ($view) {
        if (empty(Auth::user()->level)) {
            $verticalMenuJson = file_get_contents(base_path('resources/data/menu-data/menuKosong.json'));
        }elseif (Auth::user()->level == 'Admin') {
            $verticalMenuJson = file_get_contents(base_path('resources/data/menu-data/menu_admin.json'));
        }elseif (Auth::user()->level == 'Super Admin'){
            $verticalMenuJson = file_get_contents(base_path('resources/data/menu-data/super_admin.json'));
        }
        else{
            $verticalMenuJson = file_get_contents(base_path('resources/data/menu-data/menu_kadept.json'));
        }

            $verticalMenuData = json_decode($verticalMenuJson);
            $horizontalMenuJson = file_get_contents(base_path('resources/data/menu-data/horizontalMenu.json'));
            $horizontalMenuData = json_decode($horizontalMenuJson);
            
            // Share all menuData to all the views
            View::share('menuData', [$verticalMenuData, $horizontalMenuData]);
        });
    }
}
