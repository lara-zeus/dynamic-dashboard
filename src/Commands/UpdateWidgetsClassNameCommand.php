<?php

namespace LaraZeus\DynamicDashboard\Commands;

use Illuminate\Console\Command;
use LaraZeus\DynamicDashboard\Models\Layout;

class UpdateWidgetsClassNameCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-dashboard:update-class';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'upgrade all widgets classes in db to v3';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $getLayouts = Layout::get();
        if ($getLayouts->isNotEmpty()) {
            foreach ($getLayouts as $item) {
                $widgets = $item->widgets;
                foreach ($item->widgets as $colm => $widgetColumn) {
                    $newitems = [];
                    foreach ($widgetColumn as $widget) {
                        $widget['data']['widget'] = str_replace(
                            'LaraZeus\Rain',
                            'LaraZeus\DynamicDashboard',
                            $widget['data']['widget']
                        );
                        $newitems[] = $widget;
                    }
                    $widgets[$colm] = $newitems;
                }

                $item->widgets = $widgets;
                $item->save();
            }
        }
    }
}
