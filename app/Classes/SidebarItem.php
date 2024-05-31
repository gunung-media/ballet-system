<?php

namespace App\Classes;

use App\Enums\IconEnum;

class SidebarItem
{
    public string $title;
    public string $url;
    public IconEnum $icon;

    public function __construct(string $title, IconEnum $icon, string $url)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->url = $url;
    }
}
