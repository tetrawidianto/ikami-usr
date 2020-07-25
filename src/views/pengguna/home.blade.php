@extends('ikami-usr::layouts.master')

@section('content_body')
  <div class="callout callout-info">
    <h5>Selamat Datang <small><b>{{ $user->name }}</b></small>!</h5>

    <p>Anda mewakili instansi/perusahaan: <b>{{ strtoupper($user->pengguna->penyedia->nama) }}</b> <small>(<i>{{ $user->pengguna->penyedia->nama_panjang }}</i>)</small></p>
  </div>

	<div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success" style="transform: rotate(0);">
          <div class="inner">
            <h3>{{ $user->sistemEl->count() }}</h3>

            <p><a href="{{ url('sistem-el') }}" class="stretched-link text-white">{{ __('Sistem Elektronik') }}</a></p>
          </div>
          <div class="icon">
            <i class="fas fa-server"></i>
          </div>
          <a href="{{ url('sistem-el') }}" class="small-box-footer stretched-link">{{ __('Masuk') }} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-primary" style="transform: rotate(0);">
          <div class="inner">
            <h3>{{ $user->asesmen->count() }}</h3>

            <p><a href="{{ url('asesmen') }}" class="stretched-link text-white">{{ __('Asesmen') }}</a></p>
          </div>
          <div class="icon">
            <i class="fas fa-check"></i>
          </div>
          <a href="{{ url('asesmen') }}" class="small-box-footer stretched-link">{{ __('Masuk') }} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      
    </div>
@endsection