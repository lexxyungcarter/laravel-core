<?php

namespace AceLords\Core\Providers;

use Illuminate\Support\ServiceProvider;
use AceLords\Core\Library\SiteConstants;
use AceLords\Core\Library\Traits\BladeSidebarGenerator;

class ComposerServiceProvider extends ServiceProvider
{
    use BladeSidebarGenerator;
    
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        \View::composer(
            [
                '*',
            ],
        
            function ($view) {
                $view->with((new SiteConstants())->data());
            });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['blade.compiler']->directive('acelordsSidebar', function ($group) {
            return $this->generateSidebar(doe());
        });
    }
}
