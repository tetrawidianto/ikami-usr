@extends('ikami-usr::layouts.master')

@section('content_body')
	<div class="row">
	  <div class="col-md-8">
      <!-- Widget: user widget style 1 -->
      <div class="card card-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-{{ $sektor->badge }}">
          <h3 class="widget-user-username">Sektor {{ $sektor->nama }}</h3>
          <h5 class="widget-user-desc"><small>{{ $sektor->deskripsi }}</small></h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle elevation-2" src="{{ asset('uploads/logo-bssn.jpg') }}" alt="User Avatar">
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col border-right">
              <div class="description-block">
                <h5 class="description-header">{{ $asesmen_semua }}</h5>
                <span class="description-text text-primary">Semua</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col border-right">
              <div class="description-block">
                <h5 class="description-header">{{ $asesmen_masuk }}</h5>
                <span class="description-text text-danger">Masuk</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col border-right">
              <div class="description-block">
                <h5 class="description-header">{{ $asesmen_terjadwal }}</h5>
                <span class="description-text text-warning">Terjadwal</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col border-right">
              <div class="description-block">
                <h5 class="description-header">{{ $asesmen_berlangsung }}</h5>
                <span class="description-text text-info">Berlangsung</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col">
              <div class="description-block">
                <h5 class="description-header">{{ $asesmen_selesai }}</h5>
                <span class="description-text text-success">Selesai</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.widget-user -->
    </div>

    <div class="col-md-4">
    
    </div>
    <!-- /.col -->
	</div>
@endsection