@extends('ikami-usr::layouts.master')

@section('content_body')
	<div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $sistemEl }}</h3>

            <p><a href="{{ url('/monitoring-sistem-el') }}" class="stretched-link"></a>SISTEM ELEKTRONIK</p>
          </div>
          <div class="icon">
            <i class="fas fa-server"></i>
          </div>
          <a href="{{ url('/monitoring-sistem-el') }}" class="small-box-footer">Terverifikasi <i class="fas fa-check-circle"></i></a>
        </div>
      </div>
      <!-- ./col -->

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $penyedia }}</h3>

            <p>PENYEDIA</p>
          </div>
          <div class="icon">
            <i class="fas fa-building"></i>
          </div>
          <a href="javascript:void(0)" class="small-box-footer">Terverifikasi <i class="fas fa-check-circle"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $pengguna }}</h3>

            <p>PENGGUNA</p>
          </div>
          <div class="icon">
            <i class="fas fa-id-badge"></i>
          </div>
          <a href="javascript:void(0)" class="small-box-footer">Terverifikasi <i class="fas fa-check-circle"></i></a>
        </div>
      </div>
      <!-- ./col -->
      
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ $asesi }}</h3>

            <p>ASESI</p>
          </div>
          <div class="icon">
            <i class="fas fa-address-card"></i>
          </div>
          <a href="javascript:void(0)" class="small-box-footer">Terverifikasi <i class="fas fa-check-circle"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
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
	        <h3 class="widget-user-username">SEKTOR</h3>
	        <h5 class="widget-user-desc">Sistem Elektronik</h5>
	      </div>
	      <div class="card-footer p-0">
	        <ul class="nav flex-column">
	          @foreach($listSektor as $sektor)
	          <li class="nav-item">
	            <a href="javascript:void(0)" class="nav-link">
	              {{ $sektor->nama }} <span class="float-right badge bg-{{ $sektor->badge }}">{{ $sektor->sistem_el_count }}</span>
	            </a>
	          </li>
	          @endforeach
	        </ul>
	      </div>
	    </div>
	    <!-- /.widget-user -->
	  </div>
	  <!-- /.col -->
	  <div class="col-md-4">
	    <!-- Widget: user widget style 1 -->
	    <div class="card card-widget widget-user">
	      <!-- Add the bg color to the header using any of the bg-* classes -->
	      <div class="widget-user-header bg-info">
	        <h3 class="widget-user-username">KATEGORI</h3>
	        <h5 class="widget-user-desc">Sistem Elektronik</h5>
	      </div>
	      <div class="widget-user-image">
	        <img class="img-circle elevation-2" src="{{ asset('uploads/logo-bssn.jpg') }}" alt="User Avatar">
	      </div>
	      <div class="card-footer">
	        <div class="row">
	          <div class="col-sm-4 border-right">
	            <div class="description-block">
	              <h5 class="description-header">{{ $rendah }}</h5>
	              <span class="description-text text-success">RENDAH</span>
	            </div>
	            <!-- /.description-block -->
	          </div>
	          <!-- /.col -->
	          <div class="col-sm-4 border-right">
	            <div class="description-block">
	              <h5 class="description-header">{{ $tinggi }}</h5>
	              <span class="description-text text-warning">TINGGI</span>
	            </div>
	            <!-- /.description-block -->
	          </div>
	          <!-- /.col -->
	          <div class="col-sm-4">
	            <div class="description-block">
	              <h5 class="description-header">{{ $strategis }}</h5>
	              <span class="description-text text-danger">STRATEGIS</span>
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
	  <!-- /.col -->
	  <div class="col-md-5">
        <!-- Widget: user widget style 1 -->
        <div class="card card-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header text-white" style="background: url('uploads/img/photo1.png') center center;">
            <h3 class="widget-user-username text-right">PREDIKAT</h3>
            <h5 class="widget-user-desc text-right">Sistem Elektronik</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" src="{{ asset('uploads/logo-bssn.jpg') }}" alt="User Avatar">
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col border-right">
                <div class="description-block">
                  <h5 class="description-header">{{ $baik }}</h5>
                  <span class="description-text text-success">BAIK</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col border-right">
                <div class="description-block">
                  <h5 class="description-header">{{ $cukupBaik }}</h5>
                  <span class="description-text text-warning">CUKUP BAIK</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col border-right">
                <div class="description-block">
                  <h5 class="description-header">{{ $kerangkaKerjaDasar }}</h5>
                  <span class="description-text text-orange">PEMENUHAN KERANGKA KERJA DASAR</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col">
                <div class="description-block">
                  <h5 class="description-header">{{ $tidakLayak }}</h5>
                  <span class="description-text text-danger">TIDAK LAYAK</span>
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
	</div>
@endsection