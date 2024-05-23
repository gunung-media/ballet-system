<?php

namespace App\Classes;

use App\Enums\HeroIconEnum;

class SidebarItem
{
    public string $title;
    public string $url;
    public HeroIconEnum $icon;

    public function __construct(string $title, HeroIconEnum $icon, string $url)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->url = $url;
    }
}
