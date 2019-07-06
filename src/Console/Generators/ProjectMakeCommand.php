<?php

namespace AceLords\Core\Console\Generators;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;

class ProjectMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acelords:make-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new AceLords project under packages';

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $project = strtolower($this->argument('project'));
        $projectPaths = [
            base_path("packages/{$project}/public"),
            base_path("packages/{$project}/resources"),
            base_path("packages/{$project}/src/Config/sidebar.php"),
            base_path("packages/{$project}/src/Config/redis.php"),
            base_path("packages/{$project}/src/Config/logging.php"),
            base_path("packages/{$project}/src/Config/main.php"),
            base_path("packages/{$project}/src/Modules"),
            base_path("packages/{$project}/src/helpers.php"),
        ];

        $projectCommands = [
            // providers 
            "acelords:make-provider ProjectServiceProvider {$project}",
            "acelords:make-provider AuthServiceProvider {$project}",
            "acelords:make-provider EventServiceProvider {$project}",
            "acelords:make-provider HorizonServiceProvider {$project}",
            "acelords:make-provider PackagesServiceProvider {$project}",
            "acelords:make-provider RouteServiceProvider {$project}",
            "acelords:make-provider ComposerServiceProvider {$project}",

            // others
            "acelords:make-controller FrontController {$project}",
        ];


        // execute 

        foreach($projectPaths as $path) {
            $this->line("Creating " . $path . " directory");
            $this->makeDirectory($path);
        }
        
        
        foreach($projectCommands as $comm) {
            $this->line("Running " . $comm . " command");
            $this->call($comm);
        }

        $this->info('Done creating a project');

    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['project', InputArgument::REQUIRED, 'The name of the project'],
        ];
    }
}
