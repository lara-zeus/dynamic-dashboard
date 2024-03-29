<?php

namespace LaraZeus\DynamicDashboard\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use LaraZeus\DynamicDashboard\DynamicDashboardPlugin;
use LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource\Pages;

class LayoutResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-cloud';

    protected static ?int $navigationSort = 20;

    public static function shouldRegisterNavigation(): bool
    {
        return ! DynamicDashboardPlugin::get()->isLayoutResourceHidden();
    }

    public static function getModel(): string
    {
        return DynamicDashboardPlugin::get()->getModel('Layout');
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
            ->actions([
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
            'index' => Pages\ListLayout::route('/'),
            'edit' => Pages\EditLayout::route('/{record}/manage'),
            'create' => Pages\CreateLayout::route('/manage'),
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
