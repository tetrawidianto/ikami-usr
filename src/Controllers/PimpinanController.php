<?php

namespace IkamiUsr\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use IkamiAdm\Models\Asesi;
use IkamiAdm\Models\Asesmen;
use IkamiAdm\Models\Pengguna;
use IkamiAdm\Models\Penyedia;
use IkamiAdm\Models\Sektor;
use IkamiAdm\Models\SistemEl;

class PimpinanController extends Controller
{
    public function index()
    {
    	$penyedia = Penyedia::currentStatus('diterima')->count();
    	$pengguna = Pengguna::currentStatus('diterima')->count();
    	$sistemEl = SistemEl::currentStatus('diterima')->count();
    	$asesi = Asesi::currentStatus('diterima')->count();

    	// $asesmen = Asesmen::currentStatus('selesai')->get();

    	// $rendah = $asesmen->where('kategori_sistem_el_id', 1)->count();
    	// $tinggi = $asesmen->where('kategori_sistem_el_id', 2)->count();
    	// $strategis = $asesmen->where('kategori_sistem_el_id', 3)->count();

    	// $tidakLayak = $asesmen->where('opini_id', 1)->count();
    	// $kerangkaKerjaDasar = $asesmen->where('opini_id', 2)->count();
    	// $cukupBaik = $asesmen->where('opini_id', 3)->count();
    	// $baik = $asesmen->where('opini_id', 4)->count();

        $listSistemEl = SistemEl::with('latestDa')->get();

        $rendah = $listSistemEl->where('kategori_sistem_el_id', 1)->count();
        $tinggi = $listSistemEl->where('kategori_sistem_el_id', 2)->count();
        $strategis = $listSistemEl->where('kategori_sistem_el_id', 3)->count();

        $tidakLayak = $listSistemEl->where('opini_id', 1)->count();
        $kerangkaKerjaDasar = $listSistemEl->where('opini_id', 2)->count();
        $cukupBaik = $listSistemEl->where('opini_id', 3)->count();
        $baik = $listSistemEl->where('opini_id', 4)->count();

    	$listSektor = Sektor::withCount('sistemEl')->get();
    	
        return view('ikami-usr::pimpinan.home', compact('listSektor', 'penyedia', 'pengguna', 'sistemEl', 'asesi', 'rendah', 'tinggi', 'strategis', 'tidakLayak', 'kerangkaKerjaDasar', 'cukupBaik', 'baik'));
    }

}