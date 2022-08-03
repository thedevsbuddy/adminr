<?php

namespace App\Traits;


use Illuminate\Support\Facades\View;

trait HasMetaHead
{
    protected function title(string $metaTitle): static
    {
        View::share('title', $metaTitle);
        return $this;
    }

    protected function description(string $metaDescription): static
    {
        View::share('description', $metaDescription);
        return $this;
    }

    protected function keywords(string $metaKeywords): static
    {
        View::share('keywords', $metaKeywords);
        return $this;
    }

    protected function ogTitle(string $ogTitle): static
    {
        View::share('ogTitle', $ogTitle);
        return $this;
    }

    protected function ogDescription(string $ogDescription): static
    {
        View::share('ogDescription', $ogDescription);
        return $this;
    }

    protected function ogImage(string $ogImage): static
    {
        View::share('ogImage', $ogImage);
        return $this;
    }
}
