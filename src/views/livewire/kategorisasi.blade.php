<div class="info-box mb-3">
  <span class="info-box-icon bg-{{ $uAsesmen->kategoriSistemEl->color }} elevation-1"><i class="fas fa-tachometer-alt"></i></span>

  <div class="info-box-content">
    <span class="info-box-text">Kategori</span>
    <span class="info-box-number text-{{ $uAsesmen->kategoriSistemEl->color }}">{{ $uAsesmen->kategoriSistemEl->nama }}</span>
  </div>
  <!-- /.info-box-content -->
</div>
<!-- /.info-box -->

<div class="card">
	<div class="card-header">
		<div class="card-title">
			Skala Kategori
		</div>
	</div>
	<div class="card-body p-1">
		<div class="progress">
  <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{ $uAsesmen->skor*2 }}%" aria-valuenow="{{ $uAsesmen->skor*2 }}" aria-valuemin="0" aria-valuemax="100">{{ $uAsesmen->skor }}</div>
</div>
		<div class="progress">
  <div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Rendah</div>
  <div class="progress-bar bg-warning" role="progressbar" style="width: 38%" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100">Tinggi</div>
  <div class="progress-bar bg-danger" role="progressbar" style="width: 32%" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100">Strategis</div>
</div>
	</div>
</div>

<div class="card">
	<div class="card-header">
		<div class="card-title">
			Tingkat Kematangan
		</div>
	</div>
	<div class="card-body p-2">
		@foreach($uAsesmen->areaUtama as $key => $areaUtama)
		<div class="d-flex justify-content-between align-items-center @if($uAsesmen->areaUtama->count() - 1 != $key) border-bottom @endif mb-3">
          <p class="d-flex flex-column text-left">
            <span class="text-muted"><small>{{ $areaUtama->area->nama }}</small></span>
            <span class="font-weight-bold">
              {{ $areaUtama->skor }}
            </span>
          </p>
          <p class="text-dark text-lg">
            <span class="badge badge-pill badge-{{ $areaUtama->area->badge }}">{{ $areaUtama->kematanganBaru->nama }}</span>
          </p>
        </div>
        @endforeach
	</div>
</div>

<div class="card">
	<div class="card-header">
		<div class="card-title">
			Tingkat Pemenuhan
		</div>
	</div>
	<div class="card-body p-1">
        @foreach($uAsesmen->aspekSuplemen as $aspekSuplemen)
        <div class="progress-group">
          <small>{{ $aspekSuplemen->aspek->nama }}</small>
          <div class="progress progress-sm">
            <div class="progress-bar bg-{{ $aspekSuplemen->aspek->badge }}" style="width: {{ $aspekSuplemen->persentase }}%">{{ $aspekSuplemen->persentase }}%</div>
          </div>
        </div>
        @endforeach
        <!-- /.progress-group -->
	</div>
</div>