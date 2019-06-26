<?php 

/*
|--------------------------------------------------------------------------
| Generator path
|--------------------------------------------------------------------------
| Customise the paths where the folders will be generated.
| Set the generate key to false to not generate that folder
*/
return [
    'config' => ['path' => 'Config', 'generate' => true],
    'command' => ['path' => 'Console', 'generate' => true],
    'migration' => ['path' => 'Database/Migrations', 'generate' => true],
    'seeder' => ['path' => 'Database/Seeders', 'generate' => true],
    'factory' => ['path' => 'Database/factories', 'generate' => true],
    'model' => ['path' => 'Entities', 'generate' => true],
    'controller' => ['path' => 'Http/Controllers', 'generate' => true],
    'filter' => ['path' => 'Http/Middleware', 'generate' => true],
    'request' => ['path' => 'Http/Requests', 'generate' => true],
    'provider' => ['path' => 'Providers', 'generate' => true],
    'assets' => ['path' => 'Resources/assets', 'generate' => true],
    'lang' => ['path' => 'Resources/lang', 'generate' => true],
    'views' => ['path' => 'Resources/views', 'generate' => true],
    'test' => ['path' => 'Tests', 'generate' => true],
    'repository' => ['path' => 'Repositories', 'generate' => false],
    'event' => ['path' => 'Events', 'generate' => false],
    'listener' => ['path' => 'Listeners', 'generate' => false],
    'policies' => ['path' => 'Policies', 'generate' => false],
    'rules' => ['path' => 'Rules', 'generate' => false],
    'jobs' => ['path' => 'Jobs', 'generate' => false],
    'mails' => ['path' => 'Mail', 'generate' => false],
    'notifications' => ['path' => 'Notifications', 'generate' => false],
    'resource' => ['path' => 'Transformers', 'generate' => false],
];