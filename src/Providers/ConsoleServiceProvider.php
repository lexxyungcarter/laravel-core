<?php

namespace AceLords\Core\Providers;

use Illuminate\Support\ServiceProvider;

use AceLords\Core\Console\GenerateProductKey;
use AceLords\Core\Console\TestQueue;
use AceLords\Core\Console\FixRoles;
use AceLords\Core\Console\AssetsCommand;
use AceLords\Core\Console\UpdateRedisKey;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * The available commands
     *
     * @var array
    */
    protected $commands = [
        GenerateProductKey::class,
        TestQueue::class,
        FixRoles::class,
        AssetsCommand::class,
        UpdateRedisKey::class,
    ];


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * @return array
     */
    public function provides()
    {
        $provides = $this->commands;

        return $provides;
    }
}
