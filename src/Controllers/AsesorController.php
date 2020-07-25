<?php

namespace IkamiUsr\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use IkamiAdm\Models\Asesmen;
use IkamiAdm\Models\User;

class AsesorController extends Controller
{
    public function index()
    {
    	$user = User::find(auth()->id());

        $asesmen_semua = Asesmen::whereHas('asesor', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->currentStatus(['terjadwal', 'berlangsung', 'selesai'])
        ->count();

        $asesmen_terjadwal = Asesmen::whereHas('asesor', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->currentStatus('terjadwal')->count();

        $asesmen_berlangsung = Asesmen::whereHas('asesor', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->currentStatus('berlangsung')->count();

        $asesmen_selesai = Asesmen::whereHas('asesor', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->currentStatus('selesai')->count();

    	return view('ikami-usr::asesor.home', compact('asesmen_semua', 'asesmen_terjadwal', 'asesmen_berlangsung', 'asesmen_selesai'));
    }

    public function show(Asesmen $asesmen)
    {
    	$user = User::find(auth()->id());

    	$asesmen = Asesmen::whereHas('asesor', function($query) use ($user) {
    		$query->where('user_id', $user->id);
    	})->findOrFail($asesmen->id);

        $asesmen->load('sistemEl', 'versi');

    	return view('ikami-usr::asesor.desktop-assessment', compact('asesmen'));
    }

    public function previewBeritaAcara(Asesmen $asesmen)
    {
        $user = User::find(auth()->id());

        $asesmen = Asesmen::whereHas('asesor', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->findOrFail($asesmen->id);

        return response()->file(Storage::path($asesmen->berita_acara));
    }

}
