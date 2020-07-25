<?php

namespace IkamiUsr\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use IkamiAdm\Models\Asesi;
use IkamiAdm\Models\Pengguna;
use IkamiAdm\Models\Penyedia;
use IkamiAdm\Models\SistemEl;
use IkamiAdm\Models\Status;

class VerifikasiController extends Controller
{
    public function index()
    {
    	$data = [
    		'penyedia' => [
    			'penyedia_all' => Penyedia::count(),
    			'penyedia_diterima' => Penyedia::currentStatus(Status::DITERIMA)->count(),
    			'penyedia_menunggu' => Penyedia::currentStatus(Status::MENUNGGU)->count(),
    			'penyedia_ditolak' => Penyedia::currentStatus(Status::DITOLAK)->count(),
    		],
    		'pengguna' => [
    			'pengguna_all' => Pengguna::count(),
		    	'pengguna_diterima' => Pengguna::currentStatus(Status::DITERIMA)->count(),
		    	'pengguna_menunggu' => Pengguna::currentStatus(Status::MENUNGGU)->count(),
		    	'pengguna_ditolak' => Pengguna::currentStatus(Status::DITOLAK)->count(),
    		],
    		'sistem_el' => [
    			'sistem_el_all' => SistemEl::count(),
		    	'sistem_el_diterima' => SistemEl::currentStatus(Status::DITERIMA)->count(),
		    	'sistem_el_menunggu' => SistemEl::currentStatus(Status::MENUNGGU)->count(),
		    	'sistem_el_ditolak' => SistemEl::currentStatus(Status::DITOLAK)->count(),
    		],
    		'asesi' => [
    			'asesi_all' => Asesi::count(),
		    	'asesi_diterima' => Asesi::currentStatus(Status::DITERIMA)->count(),
		    	'asesi_menunggu' => Asesi::currentStatus(Status::MENUNGGU)->count(),
		    	'asesi_ditolak' => Asesi::currentStatus(Status::DITOLAK)->count(),
    		]
    	];

    	return view('ikami-usr::verifikator.home', compact('data'));
    }

    public function showKtp(Pengguna $pengguna)
    {
        return response()->file(Storage::path($pengguna->ktp));
    }

    public function showTandaPengenal(Pengguna $pengguna)
    {
        return response()->file(Storage::path($pengguna->tanda_pengenal));
    }

    public function showSuratTugas(Asesi $asesi)
    {
        return response()->file(Storage::path($asesi->surat_tugas));
    }
}
