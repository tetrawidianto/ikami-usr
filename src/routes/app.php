<?php 

use Illuminate\Support\Facades\Route;

Route::get('/pengaturan-awal', 'HomeController@pengaturanAwal')->name('pengaturan-awal');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'role:pengguna'], function() {
	Route::get('/asesmen/{asesmen}', 'SaController@index')->name('sa-index');

	Route::get('/ba-pengguna/{asesmen}', 'SaController@previewBeritaAcara')->name('ba-pengguna');
});

Route::group(['middleware' => 'role:verifikator'], function() {
	Route::get('/home-verifikator', 'VerifikasiController@index')->name('home-verifikator');
	Route::get('/ver-ktp/{pengguna}', 'VerifikasiController@showKtp')->name('ver-ktp');
	Route::get('/ver-tanda-pengenal/{pengguna}', 'VerifikasiController@showTandaPengenal')->name('ver-tanda-pengenal');
	Route::get('/ver-surat-tugas/{asesi}', 'VerifikasiController@showSuratTugas')->name('ver-surat-tugas');
});

Route::group(['middleware' => 'role:admin'], function() {
	Route::get('/home-admin', 'HomeAdminController@index')->name('home-admin');
	Route::get('/va/{sistemEl}', 'HomeAdminController@dokumenVa')->name('dokumen-va');
});

Route::group(['middleware' => 'role:asesor'], function() {
	Route::get('/home-asesor', 'DaController@index')->name('da-index');
	Route::get('/da/{asesmen}', 'DaController@show')->name('da-show');
	
	Route::get('/ba-asesor/{asesmen}', 'DaController@previewBeritaAcara')->name('ba-asesor');
});

Route::group(['middleware' => 'role:pimpinan'], function() {
	Route::get('/home-pimpinan', 'HomePimpinanController@index')->name('home-pimpinan');
	
});