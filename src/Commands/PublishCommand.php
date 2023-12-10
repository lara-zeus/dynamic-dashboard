<?php

namespace LaraZeus\DynamicDashboard\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-dashboard:publish {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PublishCommand all Zeus and Dynamic Dashboard components and resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // publish Dynamic Dashboard files
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-dynamic-dashboard-translations', '--force' => (bool) $this->option('force')]);

        // publish Zeus files
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-config', '--force' => (bool) $this->option('force')]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-views', '--force' => (bool) $this->option('force')]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-assets', '--force' => (bool) $this->option('force')]);

        $this->output->success('Zeus and Dynamic Dashboard has been Published successfully');
    }
}
