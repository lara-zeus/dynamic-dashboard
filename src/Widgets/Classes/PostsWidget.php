<?php

namespace LaraZeus\Rain\Widgets\Classes;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use LaraZeus\Rain\Widgets\Widget;

class PostsWidget extends Widget implements \LaraZeus\Rain\Contracts\Widget
{
    public function enabled(): bool
    {
        return class_exists(\LaraZeus\Sky\SkyServiceProvider::class);
    }

    public function form(): Builder\Block
    {
        return Builder\Block::make('posts')
            ->label(__('Posts'))
            ->schema([
                Tabs::make('posts_tabs')
                    ->schema([
                        Tabs\Tab::make('posts')
                            ->label(__('Posts'))
                            ->schema([
                                TextInput::make('limit')
                                    ->numeric()
                                    ->default(5),
                                Select::make('orderBy')
                                    ->options([
                                        'id' => __('id'),
                                        'created_at' => __('created at'),
                                        'published_at' => __('published at'),
                                    ])
                                    ->default('id'),
                                Select::make('orderDir')
                                    ->label(__('order direction'))
                                    ->options([
                                        'asc' => __('asc'),
                                        'desc' => __('desc'),
                                    ])
                                    ->default('desc'),

                                Select::make('category')
                                    // @phpstan-ignore-next-line
                                    ->options(\LaraZeus\Sky\SkyPlugin::get()->getModel('Tag')::query()
                                        ->withType('category')
                                        ->pluck('name', 'id')),

                                Toggle::make('show_thumbnail')->label(__('show thumbnail')),
                                Toggle::make('show_description')->label(__('show description')),
                            ]),
                        $this->defaultOptionsTab(),
                    ]),
            ]);
    }

    public function viewData(array $data): array
    {
        // @phpstan-ignore-next-line
        $posts = \LaraZeus\Sky\SkyPlugin::get()->getModel('Post')::query();

        if ($data['category'] !== null) {
            // @phpstan-ignore-next-line
            $category = \LaraZeus\Sky\SkyPlugin::get()->getModel('Tag')::where('type', 'category')->find($data['category']);
            if ($category !== null) {
                $posts = $category->postsPublished();
            }
        }

        $posts->when($data['limit'], function ($q) use ($data) {
            return $q->take($data['limit']);
        });
        $posts->when($data['orderBy'], function ($q) use ($data) {
            return $q->orderBy($data['orderBy'], $data['orderDir']);
        });

        return [
            'posts' => $posts->get(),
        ];
    }
}
