<div class="row">
  <div class="col-12 col-md-6">
    <div class="info-box">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-server"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Sistem El</span>
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
        <span class="info-box-number">{{ $asesmen->versi->kode }} <small class="text-secondary"><i>{{ $asesmen->created_at->toDateString() }}</i></small></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>