<?php

namespace LaraZeus\DynamicDashboard\Filament\Resources;

use LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource\Pages\ListLayout;
use LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource\Pages\EditLayout;
use LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource\Pages\CreateLayout;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use LaraZeus\DynamicDashboard\DynamicDashboardPlugin;
use LaraZeus\DynamicDashboard\Facades\DynamicDashboard;
use LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource\Pages;

class LayoutResource extends Resource
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cloud';

    protected static ?int $navigationSort = 20;

    public static function shouldRegisterNavigation(): bool
    {
        return DynamicDashboardPlugin::get()->isResourceVisible(static::class);
    }

    public static function getModel(): string
    {
        return DynamicDashboardPlugin::get()->getModel('Layout');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components(function () {
                $form = $widgetsForm = [];

                $form[] = Fieldset::make('mainComponents')
                    ->columnSpanFull()
                    ->label(__('Title & Slug'))
                    ->schema([
                        TextInput::make('layout_title')
                            ->label(__('dashboard title'))
                            ->live(onBlur: true)
                            ->required()
                            ->afterStateUpdated(function (Set $set, $state, string $context) {
                                if ($context === 'edit') {
                                    return;
                                }

                                $set('layout_slug', Str::slug($state));
                            }),
                        TextInput::make('layout_slug')
                            ->required()
                            ->label(__('slug')),
                    ]);

                // @phpstan-ignore-next-line
                $columns = DynamicDashboardPlugin::get()->getEnum('Columns')::cases();
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
                    ->columnSpanFull()
                    ->columns(12)
                    ->schema($widgetsForm);

                return $form;
            });
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('layout_title')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->label(__('title')),
                TextColumn::make('layout_slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->label(__('slug')),

                ToggleColumn::make('is_active')
                    ->toggleable()
                    ->label(__('is active')),

                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->label(__('user')),
            ])
            ->defaultSort('id', 'desc')
            ->recordActions([
                ActionGroup::make([
                    EditAction::make('edit')
                        ->label(__('Edit')),

                    Action::make('show')
                        ->color('warning')
                        ->label(__('View Dashboard'))
                        ->icon('heroicon-o-arrow-top-right-on-square')
                        ->tooltip(__('view Dashboard'))
                        ->url(fn ($record): string => route('landing-page', $record->layout_slug))
                        ->openUrlInNewTab(),
                    DeleteAction::make('delete')->label(__('Delete')),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLayout::route('/'),
            'edit' => EditLayout::route('/{record}/edit'),
            'create' => CreateLayout::route('/create'),
        ];
    }

    public static function getLabel(): string
    {
        return __('Dashboard');
    }

    public static function getPluralLabel(): string
    {
        return __('Dashboards');
    }

    public static function getNavigationLabel(): string
    {
        return __('Dashboards');
    }

    public static function getNavigationGroup(): ?string
    {
        return DynamicDashboardPlugin::get()->getNavigationGroupLabel();
    }
}
