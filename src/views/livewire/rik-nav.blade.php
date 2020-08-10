<a wire:click="loadArea(1)" href="javascript:void(0)" class="btn btn-{{ $navLink == 1 && !$isCekLapangan ? 'warning' : 'outline-primary' }} btn-block mb-3">Kategori Sistem El
	<span class="badge bg-{{ $daftarArea->first()->informasi_count == $daftarArea->first()->pertanyaan_count ? 'success' : 'secondary'}} float-right">{{ $daftarArea->first()->informasi_count }}/{{ $daftarArea->first()->pertanyaan_count }}</span>
</a>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Area Utama</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="card-body p-0">
    <ul class="nav nav-pills flex-column">
      @foreach($daftarArea as $area)
        @if($area->id !== 1 && $area->id !== 7)
		      <li class="nav-item">
            <a wire:click="loadArea('{{ $area->id }}')" href="javascript:void(0)" class="nav-link @if($navLink == $area->id && !$isCekLapangan) active @endif">
              <i class="far fa-circle text-{{ $area->badge }}"></i> {{ $area->nama }}
              <span class="badge bg-{{ $area->informasi_count == $area->pertanyaan_count ? 'success' : 'secondary'}} float-right">{{ $area->informasi_count }}/{{ $area->pertanyaan_count }}</span>
            </a>
          </li>
        @endif
      @endforeach
    </ul>
  </div>
  <!-- /.card-body -->
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Suplemen</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="card-body p-0">
    <ul class="nav nav-pills flex-column">
      
      @php
      	$daftarAspek = $daftarArea->where('id',7)->first()->aspek;
      @endphp

      @foreach($daftarAspek as $aspek)
        <li class="nav-item">
          <a wire:click="loadAspek('{{ $aspek->id }}')" href="javascript:void(0)" class="nav-link @if($navLink == $aspek->id + 6 && !$isCekLapangan) active @endif">
            <i class="far fa-circle text-{{ $aspek->badge }}"></i>
            {{ $aspek->nama }}
            <span class="badge bg-{{ $aspek->informasi_count == $aspek->pertanyaan_count ? 'success' : 'secondary'}} float-right">{{ $aspek->informasi_count }}/{{ $aspek->pertanyaan_count }}</span>
          </a>
        </li>
      @endforeach
    </ul>
  </div>
  <!-- /.card-body -->
</div>

@if($uAsesmen->terevaluasiSemua() && !$daftarKonfirmasi->isEmpty())
<div class="card">
	<div class="card-body p-0">
		<ul class="nav nav-pills flex-column">
			<li class="nav-item">
        <a wire:click="loadCekLapangan" href="javascript:void(0)" class="nav-link @if($isCekLapangan) active @endif">
          <i class="far fa-circle text-lime"></i>
          Onsite Assessment
          <span class="badge bg-{{ $daftarKonfirmasi->where('informasi.confirmed', true)->count() == $daftarKonfirmasi->count() ? 'success' : 'secondary'}} float-right">{{ $daftarKonfirmasi->where('informasi.confirmed', true)->count() }}/{{ $daftarKonfirmasi->count() }}</span>
        </a>
      </li>
		</ul>
	</div>
</div>
@endif