<?php

namespace AceLords\Core\Console;

use Illuminate\Console\Command;

class ClearRedis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acelords:clear-redis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'AceLords command to clear redis';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // extras
        foreach(config('acelords_redis.extras') as $key)
        {
            if(is_array($key) {
                redis()->del($key['table']);
            } else {
                redis()->del($key);
            }
        }

        // models
        foreach(config('acelords_redis.models') as $key)
        {
            redis()->del($key);
        }

        // sidebar
        redis()->del('sidebar');
        redis()->del('sudo_sidebar');

        $this->info("$key cleared! Refresh the page");
    }
}
