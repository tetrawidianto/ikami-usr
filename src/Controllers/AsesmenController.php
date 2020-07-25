<?php

namespace IkamiUsr\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use IkamiAdm\Models\Asesmen;
use IkamiAdm\Models\User;

class AsesmenController extends Controller
{
    public function index(Asesmen $asesmen)
    {
    	$asesmen = User::find(auth()->id())->asesmen()->findOrFail($asesmen->id);

    	$asesmen->load('sistemEl', 'versi');
    	
    	return view('ikami-usr::pengguna.asesmen', compact('asesmen'));
    }

    public function previewBeritaAcara(Asesmen $asesmen)
    {
    	$asesmen = User::find(auth()->id())->asesmen()->findOrFail($asesmen->id);

    	return response()->file(Storage::path($asesmen->berita_acara));
    }
        
}
