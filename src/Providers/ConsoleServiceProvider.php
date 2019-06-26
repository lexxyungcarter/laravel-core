<?php

namespace AceLords\Core\Providers;

use Illuminate\Support\ServiceProvider;

use AceLords\Core\Commands\GenerateProductKey;
use AceLords\Core\Commands\TestQueue;
use AceLords\Core\Commands\FixRoles;
use AceLords\Core\Commands\AssetsCommand;

// generators
use AceLords\Core\Commands\Generators\CommandMakeCommand;
use AceLords\Core\Commands\Generators\ControllerMakeCommand;
use AceLords\Core\Commands\Generators\EventMakeCommand;
use AceLords\Core\Commands\Generators\FactoryMakeCommand;
use AceLords\Core\Commands\Generators\JobMakeCommand;
use AceLords\Core\Commands\Generators\ListenerMakeCommand;
use AceLords\Core\Commands\Generators\MailMakeCommand;
use AceLords\Core\Commands\Generators\MiddlewareMakeCommand;
use AceLords\Core\Commands\Generators\ModelMakeCommand;
use AceLords\Core\Commands\Generators\NotificationMakeCommand;
use AceLords\Core\Commands\Generators\PolicyMakeCommand;
use AceLords\Core\Commands\Generators\ProviderMakeCommand;
use AceLords\Core\Commands\Generators\RequestMakeCommand;
use AceLords\Core\Commands\Generators\ResourceMakeCommand;
use AceLords\Core\Commands\Generators\RouteProviderMakeCommand;
use AceLords\Core\Commands\Generators\RuleMakeCommand;
use AceLords\Core\Commands\Generators\SeedCommand;
use AceLords\Core\Commands\Generators\SeedMakeCommand;

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
    ];

    /**
     * the available acelords generators
     * 
     * @var array
     */
    protected $generators = [
        CommandMakeCommand::class,
        ControllerMakeCommand::class,
        EventMakeCommand::class,
        FactoryMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        MailMakeCommand::class,
        MiddlewareMakeCommand::class,
        ModelMakeCommand::class,
        NotificationMakeCommand::class,
        ProviderMakeCommand::class,
        RouteProviderMakeCommand::class,
        PolicyMakeCommand::class,
        RequestMakeCommand::class,
        ResourceMakeCommand::class,
        RuleMakeCommand::class,
        SeedCommand::class,
        SeedMakeCommand::class,
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
