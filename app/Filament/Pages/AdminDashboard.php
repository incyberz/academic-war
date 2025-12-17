<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class AdminDashboard extends Page
{

    protected static string $view = 'filament.pages.admin-dashboard';

    protected static ?string $navigationGroup = 'Admin Panel';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int $navigationSort = 1;

    public $jumlahMahasiswa;
    public $jumlahDosen;
    public $jumlahCourses;

    public function mount(): void
    {
        $this->jumlahMahasiswa = \App\Models\User::where('role', 'mhs')->count();
        $this->jumlahDosen = \App\Models\User::where('role', 'dosen')->count();
        $this->jumlahCourses = 23;
    }
}
