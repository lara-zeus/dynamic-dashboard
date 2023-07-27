<?php

namespace LaraZeus\Rain;

trait Configuration
{
    /**
     * set the default path for the layout page.
     */
    protected string $rainPrefix = 'Rain';

    /**
     * the middleware you want to apply on all the blogs routes
     * for example if you want to make your blog for users only, add the middleware 'auth'.
     */
    protected array $rainMiddleware = ['web'];

    /**
     * customize the models
     */
    protected string $layoutModel = \LaraZeus\Rain\Models\Layout::class;

    protected string $columnsModel = \LaraZeus\Rain\Models\Columns::class;

    /**
     * set the default upload options for departments logo.
     */
    protected string $uploadDisk = 'public';

    protected string $uploadDirectory = 'layouts';

    protected string $navigationGroupLabel = 'Rain';

    protected string $defaultLayout = 'Rain';

    public function rainPrefix(string $prefix): static
    {
        $this->rainPrefix = $prefix;

        return $this;
    }

    public function getRainPrefix(): string
    {
        return $this->rainPrefix;
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

    public function layoutModel(string $model): static
    {
        $this->layoutModel = $model;

        return $this;
    }

    public function getLayoutModel(): string
    {
        return $this->layoutModel;
    }

    public function columnsModel(string $model): static
    {
        $this->columnsModel = $model;

        return $this;
    }

    public function getColumnsModel(): string
    {
        return $this->columnsModel;
    }

    public function uploadDisk(string $disk): static
    {
        $this->uploadDisk = $disk;

        return $this;
    }

    public function getUploadDisk(): string
    {
        return $this->uploadDisk;
    }

    public function uploadDirectory(string $dir): static
    {
        $this->uploadDirectory = $dir;

        return $this;
    }

    public function getUploadDirectory(): string
    {
        return $this->uploadDirectory;
    }

    public function navigationGroupLabel(string $lable): static
    {
        $this->navigationGroupLabel = $lable;

        return $this;
    }

    public function getNavigationGroupLabel(): string
    {
        return $this->navigationGroupLabel;
    }

    public function defaultLayout(string $layout): static
    {
        $this->defaultLayout = $layout;

        return $this;
    }

    public function getDefaultLayout(): string
    {
        return $this->defaultLayout;
    }
}
