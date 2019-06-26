<?php

namespace AceLords\Core\Commands;

use Illuminate\Console\Command;

class AssetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acelords:publish-assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-publish the AceLords Website assets';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $project = $this->argument('module');
        $tag = "acelords-{$project}-assets";

        $this->call('vendor:publish', [
            '--tag' => $tag,
            '--force' => true,
        ]);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['project', InputArgument::OPTIONAL, 'The name of project which will be used.'],
        ];
    }
}
