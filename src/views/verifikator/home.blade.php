@extends('ikami-usr::layouts.master')

@section('content_body')
  <div class="row">
    <div class="col-md-3">
      <!-- Widget: user widget style 2 -->
      <div class="card card-widget widget-user-2">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-primary">
          <div class="widget-user-image">
            <img class="img-circle elevation-2" src="{{ asset('uploads/logo-bssn.jpg') }}" alt="User Avatar">
          </div>
          <!-- /.widget-user-image -->
          <h3 class="widget-user-username">Verifikasi</h3>
          <h5 class="widget-user-desc">Penyedia</h5>
        </div>
        <div class="card-footer p-0">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a href="{{ url('ver-penyedia') }}" class="nav-link text-secondary stretched-link">
                Semua <span class="float-right badge bg-primary">{{ $data['penyedia']['penyedia_all'] }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-secondary">
                Diterima <span class="float-right badge bg-success">{{ $data['penyedia']['penyedia_diterima'] }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-secondary">
                Menunggu <span class="float-right badge bg-warning">{{ $data['penyedia']['penyedia_menunggu'] }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-secondary">
                Ditolak <span class="float-right badge bg-danger">{{ $data['penyedia']['penyedia_ditolak'] }}</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <!-- /.widget-user -->
    </div>
    <!-- /.col -->
    
    <div class="col-md-3">
      <!-- Widget: user widget style 2 -->
      <div class="card card-widget widget-user-2">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-warning">
          <div class="widget-user-image">
            <img class="img-circle elevation-2" src="{{ asset('uploads/logo-bssn.jpg') }}" alt="User Avatar">
          </div>
          <!-- /.widget-user-image -->
          <h3 class="widget-user-username">Verifikasi</h3>
          <h5 class="widget-user-desc">Pengguna</h5>
        </div>
        <div class="card-footer p-0">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a href="{{ url('ver-pengguna') }}" class="nav-link text-secondary stretched-link">
                Semua <span class="float-right badge bg-primary">{{ $data['pengguna']['pengguna_all'] }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-secondary">
                Diterima <span class="float-right badge bg-success">{{ $data['pengguna']['pengguna_diterima'] }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-secondary">
                Menunggu <span class="float-right badge bg-warning">{{ $data['pengguna']['pengguna_menunggu'] }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-secondary">
                Ditolak <span class="float-right badge bg-danger">{{ $data['pengguna']['pengguna_ditolak'] }}</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <!-- /.widget-user -->
    </div>
    <!-- /.col -->

    <div class="col-md-3">
      <!-- Widget: user widget style 2 -->
      <div class="card card-widget widget-user-2">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-success">
          <div class="widget-user-image">
            <img class="img-circle elevation-2" src="{{ asset('uploads/logo-bssn.jpg') }}" alt="User Avatar">
          </div>
          <!-- /.widget-user-image -->
          <h3 class="widget-user-username">Verifikasi</h3>
          <h5 class="widget-user-desc">Sistem El</h5>
        </div>
        <div class="card-footer p-0">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a href="{{ url('ver-sistem-el') }}" class="nav-link text-secondary stretched-link">
                Semua <span class="float-right badge bg-primary">{{ $data['sistem_el']['sistem_el_all'] }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-secondary">
                Diterima <span class="float-right badge bg-success">{{ $data['sistem_el']['sistem_el_diterima'] }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-secondary">
                Menunggu <span class="float-right badge bg-warning">{{ $data['sistem_el']['sistem_el_menunggu'] }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-secondary">
                Ditolak <span class="float-right badge bg-danger">{{ $data['sistem_el']['sistem_el_ditolak'] }}</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <!-- /.widget-user -->
    </div>
    <!-- /.col -->

    <div class="col-md-3">
      <!-- Widget: user widget style 2 -->
      <div class="card card-widget widget-user-2">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-danger">
          <div class="widget-user-image">
            <img class="img-circle elevation-2" src="{{ asset('uploads/logo-bssn.jpg') }}" alt="User Avatar">
          </div>
          <!-- /.widget-user-image -->
          <h3 class="widget-user-username">Verifikasi</h3>
          <h5 class="widget-user-desc">Asesi</h5>
        </div>
        <div class="card-footer p-0">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a href="{{ url('ver-asesi') }}" class="nav-link text-secondary stretched-link">
                Semua <span class="float-right badge bg-primary">{{ $data['asesi']['asesi_all'] }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-secondary">
                Diterima <span class="float-right badge bg-success">{{ $data['asesi']['asesi_diterima'] }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-secondary">
                Menunggu <span class="float-right badge bg-warning">{{ $data['asesi']['asesi_menunggu'] }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-secondary">
                Ditolak <span class="float-right badge bg-danger">{{ $data['asesi']['asesi_ditolak'] }}</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <!-- /.widget-user -->
    </div>
    <!-- /.col -->
  </div>

@endsection