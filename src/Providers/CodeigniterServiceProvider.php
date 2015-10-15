<?php
namespace Ci2Lara\Codeigniter_Migration\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CodeigniterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // copy empty (but commented) default to root/config-Directory
        $this->publishes([
            __DIR__ . '/../Config/ci_session_default.php' => config_path('ci_session.php'),
        ]);

        // merge with package-defaults
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/ci_session.php', 'ci_session'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('codeigniter_session', function()
        {
            return new \Ci2Lara\Codeigniter_Migration\Services\CodeigniterService;
        });
    }
}
