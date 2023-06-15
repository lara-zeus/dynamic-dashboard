<?php

namespace LaraZeus\Rain\Filament\Resources\LayoutResource\Pages;

use Closure;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;
use LaraZeus\Rain\Filament\Resources\LayoutResource;
use LaraZeus\Rain\Models\Columns;
use LaraZeus\Rain\Models\Widgets;

/**
 * @property \stdClass $widgetsFromMain.
 */
class CreateLayout extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string $resource = LayoutResource::class;

    protected static string $view = 'zeus-rain::filament.pages.layout';

    public Widgets $widget;

    protected function getFormModel(): Widgets
    {
        return $this->widget;
    }

    protected function getTitle(): string|Htmlable
    {
        if ($this->widget->id === null) {
            return __('create layout');
        }

        return __('edit layout');
    }

    public function mount($record = null): void
    {
        if ($record === null) {
            $this->widget = new Widgets();
            foreach (Columns::all() as $column) {
                $this->{'widgetsFrom' . $column->key}->fill([
                    $column->key => '',
                ]);
                $this->{'widgetsFromMain'}->fill([
                    'layout_title' => '',
                    'layout_slug' => '',
                ]);
            }
        } else {
            $this->widget = Widgets::findOrFail($record);

            $allWidgets = $this->widget->widgets;
            foreach (Columns::all() as $column) {
                if (isset($allWidgets[$column->key])) {
                    $widgetsItems = collect($allWidgets[$column->key])->sortBy('data.sort')->toArray();
                    $this->{'widgetsFrom' . $column->key}->fill([
                        $column->key => $widgetsItems,
                    ]);
                } else {
                    $this->{'widgetsFrom' . $column->key}->fill([
                        $column->key => '',
                    ]);
                }
            }
            $this->{'widgetsFromMain'}->fill([
                'layout_title' => $this->widget->layout_title,
                'layout_slug' => $this->widget->layout_slug,
            ]);
        }
    }

    protected function getBlocksForms($key): array
    {
        return [
            Builder::make($key)
                ->reorderableWithButtons()
                ->label('')
                ->collapsed()
                ->collapsible()
                ->cloneable()
                ->createItemButtonLabel(__('add widget'))
                ->blocks(\LaraZeus\Rain\Widgets\Widgets::available()),
        ];
    }

    public function mainComponents(): array
    {
        return [
            Forms\Components\TextInput::make('widget.layout_title')
                ->label(__('title'))
                ->reactive()
                ->afterStateUpdated(function (Closure $set, $state) {
                    if ($this->widget->id !== null) {
                        return;
                    }

                    $set('widget.layout_slug', Str::slug($state));
                }),
            Forms\Components\TextInput::make('widget.layout_slug')->label(__('slug')),
        ];
    }

    protected function getForms(): array
    {
        $forms = [];

        $forms['widgetsFromMain'] = $this->makeForm()
            ->schema($this->mainComponents());

        foreach (Columns::all() as $layout) {
            $forms['widgetsFrom' . $layout->key] = $this->makeForm()
                ->schema($this->getBlocksForms($layout->key));
        }

        return $forms;
    }

    public function submit(): void
    {
        $widgetsData = [];

        foreach (Columns::all() as $layout) {
            $widgetsData[$layout->key] = $this->{'widgetsFrom' . $layout->key}->getState()[$layout->key];
        }

        $this->widget->layout_title = $this->{'widgetsFromMain'}->getState()['widget']['layout_title'];
        $this->widget->layout_slug = $this->{'widgetsFromMain'}->getState()['widget']['layout_slug'];
        $this->widget->widgets = $widgetsData;
        $this->widget->user_id = auth()->user()->id;
        $this->widget->save();

        $this->notify('success', __('saved successfully'));
    }
}
