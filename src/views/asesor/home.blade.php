@extends('ikami-usr::layouts.master')

@section('content_body')
	<div class="row">
		<div class="col-md-8">
			<div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white" style="background: url('uploads/img/photo1.png') center center;">
                <h3 class="widget-user-username text-right">{{ auth()->user()->name }}</h3>
                <h5 class="widget-user-desc text-right">Asesor</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" src="{{ asset('uploads/logo-bssn.jpg') }}" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-3 border-right">
                    <div class="description-block">
                      <h5 class="description-header">{{ $asesmen_semua }}</h5>
                      <span class="description-text text-primary">Semua</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 border-right">
                    <div class="description-block">
                      <h5 class="description-header">{{ $asesmen_terjadwal }}</h5>
                      <span class="description-text text-warning">Terjadwal</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 border-right">
                    <div class="description-block">
                      <h5 class="description-header">{{ $asesmen_berlangsung }}</h5>
                      <span class="description-text text-info">Berlangsung</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3">
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
		</div>
	</div>
@endsection