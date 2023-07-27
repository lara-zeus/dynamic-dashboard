<?php

namespace LaraZeus\Rain\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use LaraZeus\Rain\Filament\Resources\LayoutResource\Pages;
use LaraZeus\Rain\RainPlugin;

class LayoutResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-cloud';

    protected static ?int $navigationSort = 20;

    public static function getModel(): string
    {
        return RainPlugin::get()->getLayoutModel();
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
                        ->label(__('View Layout'))
                        ->icon('heroicon-o-arrow-top-right-on-square')
                        ->tooltip(__('view Layout'))
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
            'create' => Pages\CreateLayout::route('/create'),
            'edit' => Pages\CreateLayout::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('Layout');
    }

    public static function getPluralLabel(): string
    {
        return __('Layouts');
    }

    public static function getNavigationLabel(): string
    {
        return __('Layouts');
    }

    public static function getNavigationGroup(): ?string
    {
        return RainPlugin::get()->getNavigationGroupLabel();
    }
}
