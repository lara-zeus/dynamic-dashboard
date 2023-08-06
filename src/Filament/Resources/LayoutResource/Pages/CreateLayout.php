<?php

namespace LaraZeus\Rain\Filament\Resources\LayoutResource\Pages;

use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use LaraZeus\Rain\Facades\Rain;
use LaraZeus\Rain\Filament\Resources\LayoutResource;
use LaraZeus\Rain\Models\Layout;
use LaraZeus\Rain\RainPlugin;

/**
 * @property \stdClass $mainWidgetForm.
 */
class CreateLayout extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string $resource = LayoutResource::class;

    protected static string $view = 'zeus::filament.pages.layouts';

    public Layout $rainLayout;

    public array $widgetsData;

    public function mount(int $record = null): void
    {
        if ($record === null) {
            $layoutModel = RainPlugin::get()->getLayoutModel();
            $this->rainLayout = new $layoutModel();
            foreach (RainPlugin::get()->getColumnsModel()::all() as $column) {
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
            $this->rainLayout = RainPlugin::get()->getLayoutModel()::findOrFail($record);

            $allWidgets = $this->rainLayout->widgets;
            foreach (RainPlugin::get()->getColumnsModel()::all() as $column) {
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
                'layout_title' => $this->rainLayout->layout_title,
                'layout_slug' => $this->rainLayout->layout_slug,
            ]);
        }
    }

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

        $forms['mainWidgetForm'] = $this->makeForm()->schema($this->mainComponents());

        foreach (RainPlugin::get()->getColumnsModel()::all() as $layout) {
            $forms['widgetsFrom' . $layout->key] = $this->makeForm()
                ->schema($this->getBlocksForms($layout->key));
        }

        return $forms;
    }

    public function submit(): Application | Redirector | \Illuminate\Contracts\Foundation\Application | RedirectResponse
    {
        $widgetsData = [];

        foreach (RainPlugin::get()->getColumnsModel()::all() as $layout) {
            $widgetsData[$layout->key] = $this->{'widgetsFrom' . $layout->key}->getState()['widgetsData'][$layout->key];
        }

        // @phpstan-ignore-next-line
        $this->rainLayout->layout_title = $this->mainWidgetForm->getState()['rainLayout']['layout_title'];
        // @phpstan-ignore-next-line
        $this->rainLayout->layout_slug = $this->mainWidgetForm->getState()['rainLayout']['layout_slug'];
        $this->rainLayout->widgets = $widgetsData;
        $this->rainLayout->user_id = auth()->user()->id;
        $this->rainLayout->save();

        Notification::make()
            ->title(__('saved successfully'))
            ->success()
            ->send();

        return redirect($this->getResource()::getUrl('edit', ['record' => $this->rainLayout]));
    }

    protected function getHeaderActions(): array
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
