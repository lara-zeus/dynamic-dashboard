<?php

namespace LaraZeus\DynamicDashboard;

use Closure;

trait Configuration
{
    protected Closure | string $defaultLayout = 'new-page';

    public function setDefaultLayout(Closure | string $layout): static
    {
        $this->defaultLayout = $layout;

        return $this;
    }

    public function getDefaultLayout(): Closure | string
    {
        return $this->evaluate($this->defaultLayout);
    }
}
