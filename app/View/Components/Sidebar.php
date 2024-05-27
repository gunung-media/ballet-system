<?php

namespace App\View\Components;

use App\Classes\SidebarItem;
use App\Enums\HeroIconEnum;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * @var SidebarItem[] | string
     */
    private array $items = [];

    public function __construct(
        public string $activeMenu,
    ) {
        $this->items = [
            new SidebarItem(title: 'Beranda', url: route('dashboard'), icon: HeroIconEnum::home),
            "Penjualan",
            new SidebarItem(title: 'Kategori', url: route('kategori.index'), icon: HeroIconEnum::home),
            "Kursus",
            new SidebarItem(title: 'Data Siswa', url: route('siswa.index'), icon: HeroIconEnum::home),
        ];
    }

    public function isActive(SidebarItem $item): ?string
    {
        return $item->title === $this->activeMenu ? 'active' : null;
    }

    public function render(): View|Closure|string
    {
        return view('components.sidebar', ['items' => $this->items]);
    }
}
