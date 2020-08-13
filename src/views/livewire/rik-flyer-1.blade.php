@if($uAsesmen->terevaluasiSemua())
	@if(!$daftarKonfirmasi->isEmpty() && $daftarKonfirmasi->where('informasi.confirmed', true)->count() < $daftarKonfirmasi->count())
		<div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-info"></i> Onsite Assessment</h5>
        
      <small>Terdapat </small>
      <span class="badge bg-warning">{{ $daftarKonfirmasi->count() - $daftarKonfirmasi->where('informasi.confirmed', true)->count() }}/{{ $daftarKonfirmasi->count() }}</span> 
      <small>
		   pertanyaan yang memerlukan pengecekan secara langsung di lapangan. <a wire:click="loadCekLapangan" href="javascript:void(0)">Periksa</a>
      </small>
        
      <div wire:loading wire:target="loadCekLapangan">
        <div class="spinner-border spinner-border-sm text-warning" role="status">
  			  <span class="sr-only">Loading...</span>
  			</div>
      </div>
    </div>
	 @elseif(is_null($uAsesmen->berita_acara))
		<div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-info"></i> Unggah Dokumen</h5>
      <small>
        Tautan penutupan asesmen ini akan tersedia setelah dokumen-dokumen terkait telah diunggah.
      </small>
    </div>
   @elseif(!$uAsesmen->selesai)
    <div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-info"></i> Penutupan</h5>
      <small>
        Silakan klik tautan berikut untuk menutup asesmen ini. 
        <a onclick="confirm('{{ __('Apakah Anda sudah yakin?') }}') || event.stopImmediatePropagation()" wire:click="tutupAsesmen" href="javascript:void(0)">Tutup</a>
      </small>
    </div>
	 @else
		<div class="alert alert-primary alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-certificate"></i> Selesai!</h5>
      <small>
        Terima kasih atas partisipasi Anda.
      </small>
    </div>
	@endif
@endif