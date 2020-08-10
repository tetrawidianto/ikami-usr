<div class="row">
  <div class="col-12 col-md-6">
    <div class="info-box">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-server"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Sistem El
	@if($uAsesmen->terkunci)
	<i class="fas fa-lock text-danger float-right"></i>
	@else
	<i class="fas fa-unlock text-success float-right"></i>
	@endif
        </span>
        <span class="info-box-number">
          {{ $asesmen->sistemEl->nama }} 
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-md-6">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-cog"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Versi</span>
        <span class="info-box-number">{{ $asesmen->versi->kode }} <small class="text-secondary"><i>{{ $asesmen->jadwal->toDateString() }}</i></small></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>