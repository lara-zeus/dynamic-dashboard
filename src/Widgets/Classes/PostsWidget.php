<?php

namespace LaraZeus\DynamicDashboard\Widgets\Classes;

use Filament\Facades\Filament;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use LaraZeus\DynamicDashboard\Concerns\InteractWithWidgets;
use LaraZeus\DynamicDashboard\Contracts\Widget;

class PostsWidget implements Widget
{
    use InteractWithWidgets;

    public function enabled(): bool
    {
        return class_exists(\LaraZeus\Sky\SkyServiceProvider::class) && Filament::hasPlugin('zeus-sky');
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
                                    ->options(config('zeus-sky.models.Tag')::query()
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
        $posts = config('zeus-sky.models.Post')::query();

        if ($data['category'] !== null) {
            // @phpstan-ignore-next-line
            $category = config('zeus-sky.models.Tag')::where('type', 'category')->find($data['category']);
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
