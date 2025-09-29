<?php

namespace App\Providers;

// use App\Models\BusinessSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    

        $app_debug = env('APP_DEBUG');
        if($app_debug == true){
            DB::listen(function($query) {
                Log::info(
                    $query->sql,
                    $query->bindings,
                    $query->time
                );
            });
        }

        // $settings = BusinessSetting::first();

        // Share with all views
        // View::share('settings', $settings);

        Blade::directive('hasPermission', function ($permission) {
            return "<?php if (checkAdminPermission($permission)) : ?>";
        });
    
        Blade::directive('endHasPermission', function () {
            return "<?php endif; ?>";
        });
    }
}
