<?php

namespace LaraZeus\Rain\Filament\Resources\LayoutResource\Pages;

use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use LaraZeus\Rain\Facades\Rain;
use LaraZeus\Rain\Filament\Resources\LayoutResource;
use LaraZeus\Rain\Models\Layout;

/**
 * @property \stdClass $widgetsFromMain.
 */
class CreateLayout extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string $resource = LayoutResource::class;

    protected static string $view = 'zeus::filament.pages.layouts';

    public Layout $rainLayout;

    protected function getFormModel(): Layout
    {
        return $this->rainLayout;
    }

    public function getTitle(): string
    {
        if ($this->rainLayout->id === null) {
            return __('create layout');
        }

        return __('edit layout');
    }

    public function mount(int $record = null): void
    {
        if ($record === null) {
            $layoutModel = config('zeus-rain.models.layout');
            $this->rainLayout = new $layoutModel;
            foreach (config('zeus-rain.models.columns')::all() as $column) {
                $this->{'widgetsFrom' . $column->key}->fill([
                    $column->key => '',
                ]);
                $this->{'widgetsFromMain'}->fill([
                    'layout_title' => '',
                    'layout_slug' => '',
                ]);
            }
        } else {
            $this->rainLayout = config('zeus-rain.models.layout')::findOrFail($record);

            $allWidgets = $this->rainLayout->widgets;
            foreach (config('zeus-rain.models.columns')::all() as $column) {
                if (isset($allWidgets[$column->key])) {
                    $widgetsItems = (new Collection($allWidgets[$column->key]))->sortBy('data.sort')->toArray();
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
                'layout_title' => $this->rainLayout->layout_title,
                'layout_slug' => $this->rainLayout->layout_slug,
            ]);
        }
    }

    protected function getBlocksForms(string $key): array
    {
        return [
            Builder::make($key)
                ->reorderableWithButtons()
                ->label('')
                ->collapsed()
                ->collapsible()
                ->cloneable()
                ->addActionLabel(__('add layout'))
                ->blocks(Rain::available()),
        ];
    }

    public function mainComponents(): array
    {
        return [
            Fieldset::make('mainComponents')
                ->label(__('Title & Slug'))
                ->schema([
                    TextInput::make('rainLayout.layout_title')
                        ->label(__('layout title'))
                        ->reactive()
                        ->required()
                        ->afterStateUpdated(function (Forms\Set $set, $state) {
                            if ($this->rainLayout->id !== null) {
                                return;
                            }

                            $set('rainLayout.layout_slug', Str::slug($state));
                        }),
                    TextInput::make('rainLayout.layout_slug')
                        ->required()
                        ->label(__('slug')),
                ]),
        ];
    }

    protected function getForms(): array
    {
        $forms = [];

        $forms['widgetsFromMain'] = $this->makeForm()->schema($this->mainComponents());

        foreach (config('zeus-rain.models.columns')::all() as $layout) {
            $forms['widgetsFrom' . $layout->key] = $this->makeForm()
                ->schema($this->getBlocksForms($layout->key));
        }

        return $forms;
    }

    public function submit()
    {
        $widgetsData = [];

        foreach (config('zeus-rain.models.columns')::all() as $layout) {
            $widgetsData[$layout->key] = $this->{'widgetsFrom' . $layout->key}->getState()[$layout->key];
        }

        $this->rainLayout->layout_title = $this->{'widgetsFromMain'}->getState()['rainLayout']['layout_title'];
        $this->rainLayout->layout_slug = $this->{'widgetsFromMain'}->getState()['rainLayout']['layout_slug'];
        $this->rainLayout->widgets = $widgetsData;
        $this->rainLayout->user_id = auth()->user()->id;
        $this->rainLayout->save();

        Notification::make()
            ->title(__('saved successfully'))
            ->success()
            ->send();

        return redirect($this->getResource()::getUrl('edit', ['record' => $this->rainLayout]));
    }

    protected function getActions(): array
    {
        return [
            Action::make('view')
                ->visible($this->rainLayout->id !== null)
                ->label(__('View'))
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->tooltip(__('view form'))
                ->color('warning')
                ->url(fn () => route('landing-page', $this->rainLayout->layout_slug))
                ->openUrlInNewTab(),
        ];
    }
}
