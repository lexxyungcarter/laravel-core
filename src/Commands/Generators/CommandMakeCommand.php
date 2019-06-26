<?php

namespace AceLords\Core\Commands\Generators;

use Illuminate\Support\Str;
use AceLords\Core\Support\Config\GenerateConfigReader;
use AceLords\Core\Support\Stub;
use AceLords\Core\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CommandMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument name.
     *
     * @var string
     */
    protected $argumentName = 'name';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'acelords:make-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new Artisan command for the specified acelords project.';

    public function getDefaultNamespace() : string
    {
        return config('acelords_generator.command.path', 'Console');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the command.'],
            ['project', InputArgument::OPTIONAL, 'The name of project which will be used.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['command', null, InputOption::VALUE_OPTIONAL, 'The terminal command that should be assigned.', null],
        ];
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $project = $this->argument('module');

        return (new Stub('/command.stub', [
            'COMMAND_NAME' => $this->getCommandName(),
            'NAMESPACE'    => $this->getClassNamespace($project),
            'CLASS'        => $this->getClass(),
        ]))->render();
    }

    /**
     * @return string
     */
    private function getCommandName()
    {
        return $this->option('command') ?: 'command:name';
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $commandPath = GenerateConfigReader::read('command');

        return $path . $commandPath->getPath() . '/' . $this->getFileName() . '.php';
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return Str::studly($this->argument('name'));
    }
}
