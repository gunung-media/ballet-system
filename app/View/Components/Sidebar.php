<?php

namespace App\View\Components;

use App\Classes\SidebarItem;
use App\Enums\IconEnum;
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
            new SidebarItem(title: 'Beranda', url: route('dashboard'), icon: IconEnum::home),
            new SidebarItem(title: 'Logout', url: route('employee.logout'), icon: IconEnum::logout),
        ];
        if (!auth('employee')->check()) {
            $this->items = [
                new SidebarItem(title: 'Beranda', url: route('dashboard'), icon: IconEnum::home),
                // "Penjualan",
                // new SidebarItem(title: 'Kategori', url: route('kategori.index'), icon: IconEnum::tag),
                // new SidebarItem(title: 'Data Barang', url: route('kategori.index'), icon: IconEnum::wrenchScrewdriver),
                // new SidebarItem(title: 'Penjualan', url: route('kategori.index'), icon: IconEnum::sale),
                // "Penyewaan",
                // new SidebarItem(title: 'Inventori', url: route('dashboard'), icon: IconEnum::home),
                // new SidebarItem(title: 'Transaksi Penyewaan', url: route('dashboard'), icon: IconEnum::sale),
                new SidebarItem(title: 'Data Staf', url: route('guru.index'), icon: IconEnum::users),
                "Kursus",
                new SidebarItem(title: 'Data Kelas', url: route('kelas.index'), icon: IconEnum::home),
                new SidebarItem(title: 'Data Siswa', url: route('siswa.index'), icon: IconEnum::users),
                new SidebarItem(title: 'Data Presensi', url: route('absence.index'), icon: IconEnum::home),
                new SidebarItem(title: 'Pembayaran Reguler', url: route('spp.index'), icon: IconEnum::home),
                "Lain-Lain",
                new SidebarItem(title: 'Panduan', url: route('auth.login'), icon: IconEnum::book),
                new SidebarItem(title: 'Logout', url: route('auth.logout'), icon: IconEnum::logout),
            ];
        }
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
