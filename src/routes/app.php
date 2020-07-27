<?php 

use Illuminate\Support\Facades\Route;

Route::get('/pengaturan-awal', 'HomeController@pengaturanAwal')->name('pengaturan-awal');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'role:pengguna'], function() {
	Route::get('/asesmen/{asesmen}', 'AsesmenController@index')->name('asesmen-index');

	Route::get('/berita-acara-pengguna/{asesmen}', 'AsesmenController@previewBeritaAcara')->name('berita-acara-pengguna');
});

Route::group(['middleware' => 'role:verifikator'], function() {
	Route::get('/home-verifikator', 'VerifikasiController@index')->name('home-verifikator');
	Route::get('/ver-ktp/{pengguna}', 'VerifikasiController@showKtp')->name('ver-ktp');
	Route::get('/ver-tanda-pengenal/{pengguna}', 'VerifikasiController@showTandaPengenal')->name('ver-tanda-pengenal');
	Route::get('/ver-surat-tugas/{asesi}', 'VerifikasiController@showSuratTugas')->name('ver-surat-tugas');
});

Route::group(['middleware' => 'role:admin'], function() {
	Route::get('/home-admin', 'PenjadwalanController@index')->name('home-admin');
	
});

Route::group(['middleware' => 'role:asesor'], function() {
	Route::get('/home-asesor', 'AsesorController@index')->name('home-asesor');
	Route::get('/desktop-assessment/{asesmen}', 'AsesorController@show')->name('desktop-assessment-index');
	
	Route::get('/berita-acara-asesor/{asesmen}', 'AsesorController@previewBeritaAcara')->name('berita-acara-asesor');
});

Route::group(['middleware' => 'role:pimpinan'], function() {
	Route::get('/home-pimpinan', 'PimpinanController@index')->name('home-pimpinan');
	
});