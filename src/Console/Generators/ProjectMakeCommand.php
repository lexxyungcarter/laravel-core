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
    protected $signature = 'acelords:make-project {project}';

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

        $projectDir = [
            base_path("packages/{$project}/public/dummy.txt"),
            base_path("packages/{$project}/resources/dummy.txt"),
            base_path("packages/{$project}/src/Config/dummy.txt"),
            base_path("packages/{$project}/src/Modules/dummy.txt"),
        ];

        $projectFiles = [
            ['file' => base_path("packages/{$project}/src/Config/sidebar.php"), 'stub' => 'sidebar.stub'],
            ['file' => base_path("packages/{$project}/src/Config/redis.php"), 'stub' => 'redis.stub'],
            ['file' => base_path("packages/{$project}/src/Config/logging.php"), 'stub' => 'logging.stub'],
            ['file' => base_path("packages/{$project}/src/Config/main.php"), 'stub' => 'main.stub'],
            ['file' => base_path("packages/{$project}/src/helpers.php"), 'stub' => 'helpers.stub'],
            ['file' => base_path("packages/{$project}/composer.json"), 'stub' => 'composer.json.stub'],
            ['file' => base_path("packages/{$project}/babel.config.js"), 'stub' => 'babel.config.stub'],
            ['file' => base_path("packages/{$project}/.gitignore"), 'stub' => '.gitignore.stub'],
            ['file' => base_path("packages/{$project}/package.json"), 'stub' => 'package.json.stub'],
            ['file' => base_path("packages/{$project}/webpack.config.js"), 'stub' => 'webpack.config.stub'],
            ['file' => base_path("packages/{$project}/webpack.mix.js"), 'stub' => 'webpack.mix.stub'],
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

        foreach($projectDir as $path) {
            $this->line("Creating directory: " . $path);
            $this->makeDirectory($path);
        }
        
        foreach($projectFiles as $path) {
            if($this->alreadyExists($path['file'])) 
            {
                $this->error("{$path['file']} already exists!");
            } 
            else {
                $this->makeDirectory($path['file']);
    
                $stubName = $path['stub'];
    
                $stub = __DIR__ . "/stubs/project/{$stubName}";
                $this->line('$stub', $stub);
    
                $this->files->put($path['file'], $this->buildClass($stub));
            }

        }
        
        foreach($projectCommands as $comm) {
            $this->line("Running " . $comm . " command");
            $commExp = explode(' ', $comm);
            $this->call($commExp[0], [
                'name' => $commExp[1], 
                'project' => $commExp[2]]);
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
     * Determine if the class already exists.
     *
     * @param  string  $rawName
     * @return bool
     */
    protected function alreadyExists($path)
    {
        return $this->files->exists($path);
    }


    /**
     * Build the class with the given name.
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($stub)
    {
        $stub = $this->files->get($stub);

        return $this->replaceNamespace($stub);
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string $stub
     */
    protected function replaceNamespace(&$stub)
    {
        $project = ucwords(strtolower($this->argument('project')));

        $stub = str_replace(
            [
                'DummyAceLordsProjectName',
                'DummyLowerCaseAceLordsProjectName',
            ],
            [
                $project,
                strtolower($project),
            ],
            $stub
        );

        return $stub;
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
