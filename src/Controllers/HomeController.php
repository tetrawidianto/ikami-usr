<?php

namespace IkamiUsr\Controllers;

use App\Http\Controllers\Controller;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Http\Request;
use IkamiAdm\Models\Status;
use IkamiAdm\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        if(auth()->user()->hasRole('pimpinan'))
        {
            return redirect('/home-pimpinan');
        }

        if(auth()->user()->hasRole('asesor'))
        {
            return redirect('/home-asesor');
        }

        if(auth()->user()->hasRole('verifikator'))
        {
            return redirect('/home-verifikator');
        }

        if(auth()->user()->hasRole('admin'))
        {
            return redirect('/home-admin');
        }

        $user = User::find(auth()->id());

        if(is_null($user->pengguna) || $user->pengguna->status != Status::DITERIMA)
        {
    
            return redirect('/pengaturan-awal');
        }

        $user->load('sistemEl', 'asesmen', 'pengguna.penyedia');

        return view('ikami-usr::pengguna.home', compact('user'));
    }

    public function pengaturanAwal()
    {
        if(auth()->user()->hasAnyRole(Role::pluck('name')->toArray()))
        {
            return redirect('/home');
        }

        return view('ikami-usr::pengaturan-awal');
    }
}
