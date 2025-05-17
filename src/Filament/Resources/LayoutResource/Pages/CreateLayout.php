<?php

namespace LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource\Pages;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use LaraZeus\DynamicDashboard\DynamicDashboardPlugin;
use LaraZeus\DynamicDashboard\Facades\DynamicDashboard;
use LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource;
use LaraZeus\DynamicDashboard\Models\Layout;

/**
 * @property \stdClass $mainWidgetForm.
 */
class CreateLayout extends Page
{
    protected static string $resource = LayoutResource::class;

    protected string $view = 'zeus::filament.pages.builder';

    public Layout $dashLayout;

    public array $widgetsData;

    public function mount(?int $record = null): void
    {
        if ($record === null) {
            $layoutModel = DynamicDashboardPlugin::get()->getModel('Layout');
            $this->dashLayout = new $layoutModel;
            foreach (DynamicDashboardPlugin::get()->getModel('Columns')::all() as $column) {
                $this->{'widgetsFrom' . $column->key}->fill([
                    'widgetsData.' . $column->key => [],
                ]);
                // @phpstan-ignore-next-line
                $this->mainWidgetForm->fill([
                    'layout_title' => '',
                    'layout_slug' => '',
                ]);
            }
        } else {
            $this->dashLayout = DynamicDashboardPlugin::get()->getModel('Layout')::findOrFail($record);

            $allWidgets = $this->dashLayout->widgets;
            foreach (DynamicDashboardPlugin::get()->getModel('Columns')::all() as $column) {
                if (isset($allWidgets[$column->key])) {
                    $widgetsItems = (new Collection($allWidgets[$column->key]))->sortBy('data.sort')->toArray();
                    $this->{'widgetsFrom' . $column->key}->fill([
                        'widgetsData.' . $column->key => $widgetsItems,
                    ]);
                } else {
                    $this->{'widgetsFrom' . $column->key}->fill([
                        'widgetsData.' . $column->key => '',
                    ]);
                }
            }

            // @phpstan-ignore-next-line
            $this->mainWidgetForm->fill([
                'layout_title' => $this->dashLayout->layout_title,
                'layout_slug' => $this->dashLayout->layout_slug,
            ]);

            $columns = DynamicDashboardPlugin::get()->getModel('Columns')::all();

            foreach ($columns as $column) {
                $this->{'widgetsFrom' . $column->key}
                    ->fill([
                        'widgetsData.' . $column->key => $this->dashLayout->widgets[$column->key],
                    ]);
            }

        }
    }

    protected function getFormModel(): Layout
    {
        return $this->dashLayout;
    }

    public function getTitle(): string
    {
        return __('create dashboard');
    }

    protected function getBlocksForms(string $key): array
    {
        return [
            Builder::make('widgetsData.' . $key)
                ->reorderableWithButtons()
                ->label('')
                ->collapsed()
                ->collapsible()
                ->cloneable()
                ->reorderableWithButtons(false)
                ->addActionLabel(__('add dashboard'))
                ->blocks(DynamicDashboard::available()),
        ];
    }

    public function mainComponents(): array
    {
        return [
            Fieldset::make('mainComponents')
                ->label(__('Title & Slug'))
                ->schema([
                    TextInput::make('layout_title')
                        ->label(__('dashboard title'))
                        ->live(onBlur: true)
                        ->required()
                        ->afterStateUpdated(function (Set $set, $state) {
                            if ($this->dashLayout->id !== null) {
                                return;
                            }

                            $set('layout_slug', Str::slug($state));
                        }),
                    TextInput::make('layout_slug')
                        ->required()
                        ->label(__('slug')),
                ]),
        ];
    }

    protected function getForms(): array
    {
        $forms = [];

        $forms['mainWidgetForm'] = $this->makeForm()
            ->statePath('widgetsData')
            ->schema($this->mainComponents());

        $columns = DynamicDashboardPlugin::get()->getModel('Columns')::all();

        foreach ($columns as $column) {
            $forms['widgetsFrom' . $column->key] = $this->makeForm()
                ->schema($this->getBlocksForms($column->key));
        }

        return $forms;
    }

    public function submit(): Application | Redirector | \Illuminate\Contracts\Foundation\Application | RedirectResponse
    {
        $widgetsData = [];

        foreach (DynamicDashboardPlugin::get()->getModel('Columns')::all() as $layout) {
            $widgetsData[$layout->key] = $this->{'widgetsFrom' . $layout->key}->getState()['widgetsData'][$layout->key];
        }

        // @phpstan-ignore-next-line
        $this->dashLayout->layout_title = $this->mainWidgetForm->getState()['layout_title'];
        // @phpstan-ignore-next-line
        $this->dashLayout->layout_slug = $this->mainWidgetForm->getState()['layout_slug'];
        $this->dashLayout->widgets = $widgetsData;
        $this->dashLayout->user_id = auth()->user()->id;
        $this->dashLayout->save();

        Notification::make()
            ->title(__('saved successfully'))
            ->success()
            ->send();

        return redirect(self::getResource()::getUrl('edit', ['record' => $this->dashLayout]));
    }
}
