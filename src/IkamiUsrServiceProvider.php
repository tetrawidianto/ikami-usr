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
        $this->publishes([
            __DIR__.'/public/uploads/logo-bssn.jpg' => public_path('uploads/logo-bssn.jpg'),
            __DIR__.'/public/uploads/img/photo1.png' => public_path('uploads/img/photo1.png'),
            __DIR__.'/config/adminlte.php' => config_path('adminlte.php'),
            __DIR__.'/views/auth/auth-page.blade.php' => resource_path('views/vendor/adminlte/auth/auth-page.blade.php'),
            __DIR__.'/views/master.blade.php' => resource_path('views/vendor/adminlte/master.blade.php'),
            __DIR__.'/views/partials/navbar/navbar.blade.php' => resource_path('views/vendor/adminlte/partials/navbar/navbar.blade.php'),
            __DIR__.'/views/partials/sidebar/menu-item-link.blade.php' => resource_path('views/vendor/adminlte/partials/sidebar/menu-item-link.blade.php'),
            __DIR__.'/js/bootstrap.js' => resource_path('js/bootstrap.js'),
            __DIR__.'/sass/app.scss' => resource_path('sass/app.scss'),
            __DIR__.'/webpack.mix.js' => base_path('webpack.mix.js'),
            __DIR__.'/routes/web.php' => base_path('routes/web.php'),
        ], 'ikami-usr');

        Route::group($this->appRoute(), function () {
            $this->loadRoutesFrom(__DIR__.'/routes/app.php');
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
        Livewire::component('monitoring-da', \IkamiUsr\Livewire\MonitoringDa::class);
        Livewire::component('monitoring-va', \IkamiUsr\Livewire\MonitoringVa::class);
        Livewire::component('monitoring-da-sidebar', \IkamiUsr\Livewire\MonitoringDaSidebar::class);
        Livewire::component('desktop-assessment', \IkamiUsr\Livewire\DesktopAssessment::class);
        Livewire::component('rik-asesmen', \IkamiUsr\Livewire\RikAsesmen::class);
        Livewire::component('monitoring-sistem-el', \IkamiUsr\Livewire\MonitoringSistemEl::class);
    }

    private function appRoute()
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