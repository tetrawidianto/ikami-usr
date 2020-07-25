<?php

namespace IkamiUsr;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class IkamiUsrServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        Route::group($this->webRoute(), function () {
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        });

        Route::group($this->livewireRoute(), function () {
            $this->loadRoutesFrom(__DIR__.'/routes/livewire.php');
        });

        $this->loadViewsFrom(__DIR__.'/views', 'ikami-usr');

        Livewire::component('form-pengaturan-awal', \IkamiUsr\Livewire\FormPengaturanAwal::class);
        Livewire::component('sistem-el', \IkamiUsr\Livewire\SistemEl::class);
        Livewire::component('asesmen', \IkamiUsr\Livewire\Asesmen::class);
        Livewire::component('lak-asesmen', \IkamiUsr\Livewire\LakAsesmen::class);
        Livewire::component('verifikasi', \IkamiUsr\Livewire\Verifikasi::class);
        Livewire::component('ver-sidebar', \IkamiUsr\Livewire\VerSidebar::class);
        Livewire::component('menu-label', \IkamiUsr\Livewire\MenuLabel::class);
        Livewire::component('penjadwalan', \IkamiUsr\Livewire\Penjadwalan::class);
        Livewire::component('penjadwalan-sidebar', \IkamiUsr\Livewire\PenjadwalanSidebar::class);
        Livewire::component('desktop-assessment', \IkamiUsr\Livewire\DesktopAssessment::class);
        Livewire::component('rik-asesmen', \IkamiUsr\Livewire\RikAsesmen::class);
        Livewire::component('monitoring', \IkamiUsr\Livewire\Monitoring::class);
    }

    private function webRoute()
    {
        return [
            'middleware' => ['web', 'auth', 'verified'],
            'namespace'  => 'IkamiUsr\Controllers'
        ];
    }

    private function livewireRoute()
    {
        return [
            'middleware' => ['web', 'auth', 'verified'],
        ];
    }
}