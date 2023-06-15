<?php

namespace LaraZeus\Rain\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rain:publish {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PublishCommand all Zeus and Rain components and resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // publish Rain files
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-rain-config', '--force' => (bool) $this->option('force')]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-rain-views', '--force' => (bool) $this->option('force')]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-rain-translations', '--force' => (bool) $this->option('force')]);

        // publish Zeus files
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-config', '--force' => (bool) $this->option('force')]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-views', '--force' => (bool) $this->option('force')]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-assets', '--force' => (bool) $this->option('force')]);

        $this->output->success('Zeus and Rain has been Published successfully');
    }
}
