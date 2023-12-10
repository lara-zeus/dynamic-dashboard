<?php

namespace LaraZeus\DynamicDashboard\Commands;

use Illuminate\Console\Command;
use LaraZeus\DynamicDashboard\Concerns\CanManipulateFiles;

class ZeusWidgetCommand extends Command
{
    use CanManipulateFiles;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:zeus-widget {name : widget class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom widget for zeus Dynamic Dashboard';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $ClassName = $this->argument('name');

        $this->copyStubToApp('ZeusWidget.php', 'app/Zeus/Widgets/' . $ClassName . 'Widget.php', [
            'namespace' => 'App\\Zeus\\Widgets',
            'class' => $ClassName,
        ]);

        $this->copyStubToApp(
            'ZeusWidget.blade.php',
            'resources/views/vendor/zeus/themes/zeus/dynamic-dashboard/widgets/' . config('zeus.theme') . '/widgets/' . $ClassName . 'Widget.blade.php',
            [
                'class' => $ClassName,
            ]
        );

        $this->info('zeus widget created successfully!');
    }
}
