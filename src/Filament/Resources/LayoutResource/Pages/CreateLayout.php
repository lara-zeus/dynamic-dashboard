<?php

namespace LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource\Pages;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use LaraZeus\DynamicDashboard\DynamicDashboardPlugin;
use LaraZeus\DynamicDashboard\Facades\DynamicDashboard;
use LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource;
use LaraZeus\DynamicDashboard\Models\Layout;
use stdClass;

/**
 * @property mixed $form.
 */
class CreateLayout extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = LayoutResource::class;

    protected string $view = 'zeus::filament.pages.builder';

    public Layout $dashLayout;

    public array $widgetsData;

    public function mount(?int $record = null): void
    {
        if ($record === null) {
            $layoutModel = DynamicDashboardPlugin::get()->getModel('Layout');
            $this->dashLayout = new $layoutModel;
            $this->form->fill([
                'layout_title' => '',
                'layout_slug' => '',
                'widgets' => [],
            ]);
        } else {
            $this->dashLayout = DynamicDashboardPlugin::get()->getModel('Layout')::query()
                ->findOrFail($record);

            $this->form->fill([
                'layout_title' => $this->dashLayout->layout_title,
                'layout_slug' => $this->dashLayout->layout_slug,
                'widgets' => $this->dashLayout->widgets,
            ]);
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

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('widgetsData')
            ->schema(function () {
                $form = $widgetsForm = [];

                $form[] = Fieldset::make('mainComponents')
                    ->columnSpanFull()
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
                    ]);

                // @phpstan-ignore-next-line
                $columns = DynamicDashboardPlugin::get()->getModel('Columns')::cases();
                foreach ($columns as $column) {
                    $widgetsForm[] = Builder::make('widgets.' . $column->value)
                        ->columnSpan($column->span())
                        ->hiddenLabel()
                        ->collapsed()
                        ->collapsible()
                        ->cloneable()
                        ->addActionLabel(__('add dashboard'))
                        ->blocks(DynamicDashboard::available());
                }

                $form[] = Grid::make()
                    ->columns(12)
                    ->schema($widgetsForm);

                return $form;
            });
    }

    public function submit(): Application | Redirector | \Illuminate\Contracts\Foundation\Application | RedirectResponse
    {
        $data = $this->form->getState();

        $this->dashLayout->layout_title = $data['layout_title'];
        $this->dashLayout->layout_slug = $data['layout_slug'];
        $this->dashLayout->widgets = $data['widgets'];
        $this->dashLayout->user_id = auth()->user()->id;
        $this->dashLayout->save();

        Notification::make()
            ->title(__('saved successfully'))
            ->success()
            ->send();

        return redirect(self::getResource()::getUrl('edit', ['record' => $this->dashLayout]));
    }
}
