<?php

namespace LaraZeus\DynamicDashboard;

use Closure;

trait Configuration
{
    /**
     * you can overwrite any model and use your own
     */
    protected array $models = [];

    /**
     * set the default upload options.
     */
    protected Closure | string $defaultLayout = 'new-page';

    protected Closure | string $uploadDisk = 'public';

    protected Closure | string $uploadDirectory = 'layouts';

    protected Closure | string $navigationGroupLabel = 'Dynamic Dashboard';

    protected Closure | bool $hideLayoutResource = false;

    public function models(array $models): static
    {
        $this->models = $models;

        return $this;
    }

    public function getModels(): array
    {
        return $this->models;
    }

    public static function getModel(string $model): string
    {
        return array_merge(
            config('zeus-dynamic-dashboard.models'),
            (new static())::get()->getModels()
        )[$model];
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

    public function hideLayoutResource(Closure | bool $condition = true): static
    {
        $this->hideLayoutResource = $condition;

        return $this;
    }

    public function isLayoutResourceHidden(): Closure | bool
    {
        return $this->evaluate($this->hideLayoutResource);
    }
}
