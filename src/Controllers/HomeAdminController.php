<?php

namespace IkamiUsr\Controllers;

use App\Http\Controllers\Controller;
use IkamiAdm\Models\SistemEl;
use IkamiAdm\Models\Status;
use IkamiAdm\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeAdminController extends Controller
{
    public function index()
    {
    	$user = User::find(auth()->id());

    	$sektor = $user->sektor()->first();

    	$asesmen_semua = $sektor->asesmen()->currentStatus([Status::MASUK, Status::TERJADWAL, Status::BERLANGSUNG, Status::SELESAI])->count();
    	
    	$asesmen_masuk = $sektor->asesmen()->currentStatus(Status::MASUK)->count();

    	$asesmen_terjadwal = $sektor->asesmen()->currentStatus(Status::TERJADWAL)->count();

        $asesmen_berlangsung = $sektor->asesmen()->currentStatus(Status::BERLANGSUNG)->count();

    	$asesmen_selesai = $sektor->asesmen()->currentStatus(Status::SELESAI)->count();
    	
    	return view('ikami-usr::admin.home', compact('sektor', 'asesmen_semua', 'asesmen_masuk', 'asesmen_terjadwal', 'asesmen_berlangsung', 'asesmen_selesai'));
    }

    public function dokumenVa(SistemEl $sistemEl)
    {
        return response()->file(Storage::path($sistemEl->va()->first()->dok_va));
    }
}
