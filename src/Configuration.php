<?php

namespace LaraZeus\Rain;

use Closure;

trait Configuration
{
    /**
     * set the default path for the layout page.
     */
    protected Closure | string $rainPrefix = 'rain';

    /**
     * the middleware you want to apply on the layout page routes
     */
    protected array $rainMiddleware = ['web'];

    /**
     * you can overwrite any model and use your own
     */
    protected array $rainModels = [
        'Layout' => \LaraZeus\Rain\Models\Layout::class,
        'Columns' => \LaraZeus\Rain\Models\Columns::class,
    ];

    /**
     * set the default upload options.
     */
    protected Closure | string $uploadDisk = 'public';

    protected Closure | string $uploadDirectory = 'layouts';

    protected Closure | string $navigationGroupLabel = 'Rain';

    protected Closure | string $defaultLayout = 'new-page';

    public function rainPrefix(Closure | string $prefix): static
    {
        $this->rainPrefix = $prefix;

        return $this;
    }

    public function getRainPrefix(): Closure | string
    {
        return $this->evaluate($this->rainPrefix);
    }

    public function rainMiddleware(array $middleware): static
    {
        $this->rainMiddleware = $middleware;

        return $this;
    }

    public function getMiddleware(): array
    {
        return $this->rainMiddleware;
    }

    public function rainModels(array $models): static
    {
        $this->rainModels = $models;

        return $this;
    }

    public function getRainModels(): array
    {
        return $this->rainModels;
    }

    public static function getModel(string $model): string
    {
        return array_merge(
            (new static())->rainModels,
            (new static())::get()->getRainModels()
        )[$model];
    }

    public function uploadDisk(Closure | string $disk): static
    {
        $this->uploadDisk = $disk;

        return $this;
    }

    public function getUploadDisk(): Closure | string
    {
        return $this->evaluate($this->uploadDisk);
    }

    public function uploadDirectory(Closure | string $dir): static
    {
        $this->uploadDirectory = $dir;

        return $this;
    }

    public function getUploadDirectory(): Closure | string
    {
        return $this->evaluate($this->uploadDirectory);
    }

    public function navigationGroupLabel(Closure | string $lable): static
    {
        $this->navigationGroupLabel = $lable;

        return $this;
    }

    public function getNavigationGroupLabel(): Closure | string
    {
        return $this->evaluate($this->navigationGroupLabel);
    }

    public function defaultLayout(Closure | string $layout): static
    {
        $this->defaultLayout = $layout;

        return $this;
    }

    public function getDefaultLayout(): Closure | string
    {
        return $this->evaluate($this->defaultLayout);
    }
}
