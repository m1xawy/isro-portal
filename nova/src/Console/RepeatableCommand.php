<?php

namespace Laravel\Nova\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class RepeatableCommand extends GeneratorCommand
{
    use ResolvesStubPath;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nova:repeatable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repeatable class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repeatable';

    /**
     * Execute the console command.
     *
     * @return bool|null
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        parent::handle();
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $resourceName = $this->argument('name');

        /** @var string|null $model */
        $model = $this->option('model');
        $modelNamespace = $this->getModelNamespace();

        if (is_null($model)) {
            $model = $modelNamespace.str_replace('/', '\\', $resourceName);
        } elseif (! Str::startsWith($model, [
            $modelNamespace, '\\',
        ])) {
            $model = $modelNamespace.$model;
        }

        $replace = [
            'DummyFullModel' => $model,
            '{{ namespacedModel }}' => $model,
            '{{namespacedModel}}' => $model,
        ];

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('model')) {
            return $this->resolveStubPath('/stubs/nova/repeatable-model.stub');
        }

        return $this->resolveStubPath('/stubs/nova/repeatable.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Nova\Repeater';
    }

    /**
     * Get the default namespace for the class.
     *
     * @return string
     */
    protected function getModelNamespace()
    {
        $rootNamespace = $this->laravel->getNamespace();

        return is_dir(app_path('Models')) ? $rootNamespace.'Models\\' : $rootNamespace;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_REQUIRED, 'The model class being represented.'],
        ];
    }
}
