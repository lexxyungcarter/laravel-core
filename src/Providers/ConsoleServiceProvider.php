<?php

namespace AceLords\Core\Providers;

use Illuminate\Support\ServiceProvider;

use AceLords\Core\Console\GenerateProductKey;
use AceLords\Core\Console\TestQueue;
use AceLords\Core\Console\FixRoles;
use AceLords\Core\Console\AssetsCommand;
use AceLords\Core\Console\UpdateRedisKey;

// generators
use AceLords\Core\Console\Generators\ChannelMakeCommand;
use AceLords\Core\Console\Generators\ConsoleMakeCommand;
use AceLords\Core\Console\Generators\EventMakeCommand;
use AceLords\Core\Console\Generators\JobMakeCommand;
use AceLords\Core\Console\Generators\ListenerMakeCommand;
use AceLords\Core\Console\Generators\MailMakeCommand;
use AceLords\Core\Console\Generators\ModelMakeCommand;
use AceLords\Core\Console\Generators\NotificationMakeCommand;
use AceLords\Core\Console\Generators\PolicyMakeCommand;
use AceLords\Core\Console\Generators\ProviderMakeCommand;
use AceLords\Core\Console\Generators\RequestMakeCommand;
use AceLords\Core\Console\Generators\ResourceMakeCommand;
use AceLords\Core\Console\Generators\RuleMakeCommand;
use AceLords\Core\Console\Generators\ProjectMakeCommand;

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
     * the available acelords generators
     * 
     * @var array
     */
    protected $generators = [
        ConsoleMakeCommand::class,
        ChannelMakeCommand::class,
        EventMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        MailMakeCommand::class,
        ModelMakeCommand::class,
        NotificationMakeCommand::class,
        PolicyMakeCommand::class,
        ProviderMakeCommand::class,
        RequestMakeCommand::class,
        ResourceMakeCommand::class,
        RuleMakeCommand::class,
        ProjectMakeCommand::class,
    ];


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
        $this->commands($this->generators);
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
