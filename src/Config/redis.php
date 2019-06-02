<?php

$redisExtras = [
    'domains', 'organisations', 'themes', 'configurations',
];

$autoloadedExtras = config('acelords_redis_autoload.extras') ?? [];

return [
    /*
    |--------------------------------------------------------------------------
    | Redis Configuration
    |--------------------------------------------------------------------------
    |
    | This option controls redis
    |
    |
    */

    /*
     * Redis prefix to facilitate searches on a module and creation of database builder
     * For example, within redis configuration templates, we execute the method DB::table(settings_*)
     * Prefix is appended to items store within the redis server
     */
    'prefix' => 'settings',

    'keys' => config('acelords_redis_autoload.keys'),

    'extras' => array_merge($redisExtras, $autoloadedExtras),

    'models' => config('acelords_redis_autoload.models'),

    /*
    * Attached to redis in order to identify and distinguish the application
    */
    'application_prefix' => env('REDIS_PREFIX', 'acelords_webapps_'),
];