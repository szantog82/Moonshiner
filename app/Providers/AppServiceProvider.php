<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        if (file_exists(storage_path('special_deals.json'))) {
            $deals = json_decode(file_get_contents(storage_path('special_deals.json')), true);
            config([
                "deals" => $deals
            ]);
        }
    }
}
