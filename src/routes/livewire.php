<?php 

use Illuminate\Support\Facades\Route;

Route::group(['layout' => 'ikami-usr::layouts.master', 'section' => 'content_body', 'middleware' => 'role:pengguna'], function() {
	Route::livewire('/sistem-el', 'sistem-el');
	Route::livewire('/asesmen', 'asesmen');
});

Route::group(['layout' => 'ikami-usr::layouts.master', 'section' => 'content_body', 'middleware' => 'role:verifikator'], function() {
	Route::livewire('/ver-penyedia', 'verifikasi');
	Route::livewire('/ver-pengguna', 'verifikasi');
	Route::livewire('/ver-sistem-el', 'verifikasi');
	Route::livewire('/ver-asesi', 'verifikasi');
});

Route::group(['layout' => 'ikami-usr::layouts.master', 'section' => 'content_body', 'middleware' => 'role:admin'], function() {
	Route::livewire('/monitoring-da', 'monitoring-da');
	Route::livewire('/monitoring-va', 'monitoring-va');
});

Route::group(['layout' => 'ikami-usr::layouts.master', 'section' => 'content_body', 'middleware' => 'role:asesor'], function() {
	Route::livewire('/desktop-assessment', 'desktop-assessment');

});

Route::group(['layout' => 'ikami-usr::layouts.master', 'section' => 'content_body', 'middleware' => 'role:pimpinan'], function() {
	Route::livewire('/monitoring-sistem-el', 'monitoring-sistem-el');

});