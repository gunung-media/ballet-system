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
            new SidebarItem(title: 'Kategori', url: route('kategori.index'), icon: HeroIconEnum::tag),
            new SidebarItem(title: 'Data Barang', url: route('kategori.index'), icon: HeroIconEnum::wrenchScrewdriver),
            new SidebarItem(title: 'Penjualan', url: route('kategori.index'), icon: HeroIconEnum::sale),
            "Penyewaan",
            new SidebarItem(title: 'Inventori', url: route('dashboard'), icon: HeroIconEnum::home),
            new SidebarItem(title: 'Transaksi Penyewaan', url: route('dashboard'), icon: HeroIconEnum::sale),
            "Kursus",
            new SidebarItem(title: 'Data Siswa', url: route('siswa.index'), icon: HeroIconEnum::users),
            new SidebarItem(title: 'Data Guru', url: route('siswa.index'), icon: HeroIconEnum::users),
            new SidebarItem(title: 'Data Kelas', url: route('siswa.index'), icon: HeroIconEnum::home),
            new SidebarItem(title: 'Data Absensi', url: route('siswa.index'), icon: HeroIconEnum::home),
            new SidebarItem(title: 'Pembayaran SPP', url: route('siswa.index'), icon: HeroIconEnum::home),
            "Lain-Lain",
            new SidebarItem(title: 'Data Admin', url: route('sign-in'), icon: HeroIconEnum::users),
            new SidebarItem(title: 'Panduan', url: route('sign-in'), icon: HeroIconEnum::book),
            new SidebarItem(title: 'Logout', url: route('sign-in'), icon: HeroIconEnum::logout),
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
