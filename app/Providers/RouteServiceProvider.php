<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    const DEF_NAMESPACE = "App\\Http\\Controllers";
    protected $namespace = self::DEF_NAMESPACE;
    protected $modules = [
        "auth" => self::DEF_NAMESPACE . "\\Auth",
        "home" => self::DEF_NAMESPACE,
        "product" => self::DEF_NAMESPACE,
        "filter" => self::DEF_NAMESPACE,
        "footer" => self::DEF_NAMESPACE,
        "order" => self::DEF_NAMESPACE . "\\Order",
        "admin" => self::DEF_NAMESPACE . "\\Admin",
    ];
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        foreach ($this->modules as $name => $controller_namespace) {
            $this->setApiModuleRoutes($name, $controller_namespace);
        }
        $this->routes(function () {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }
    //Commons

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    protected function setApiModuleRoutes(string $module, string $namespace)
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($namespace)
            ->group(base_path("routes/api-routes/$module.php"));
    }
}
