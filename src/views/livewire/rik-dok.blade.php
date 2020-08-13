@if($uAsesmen->terevaluasiSemua() && ( (!$daftarKonfirmasi->isEmpty() && $daftarKonfirmasi->where('informasi.confirmed', true)->count() == $daftarKonfirmasi->count()) || $daftarKonfirmasi->isEmpty() ))
<div class="card card-primary">
	<div class="card-header">
		<div class="card-title">
			Dokumen Terkait
		</div>
	</div>
	
	@if(!is_null($uAsesmen->berita_acara))
	
	<div class="card-body">
		<ul class="list-group">
		  <li class="list-group-item d-flex justify-content-between align-items-center">
			<a href="javascript:void(0)" onclick="window.open('{{ route('ba-asesor', $uAsesmen->id)  }}', 'ikami-preview', 'height=800,width=600')">Berita Acara</a>
			
			@if(!$uAsesmen->selesai)
			<a wire:loading.remove wire:target="hapusBeritaAcara" wire:click="hapusBeritaAcara" href="javascript:void(0)" class="text-danger">
				<span class="fas fa-times"></span>
			</a>

			<div wire:loading wire:target="hapusBeritaAcara">
		        <div class="spinner-border spinner-border-sm text-primary" role="status">
				  <span class="sr-only">Loading...</span>
				</div>
	        </div>
			@endif
		  </li>
	  	</ul>
	</div>

	@else

	<div class="card-footer">
	  <form wire:submit.prevent="uploadBeritaAcara">
		<div class="form-group">
			<label class="control-label">Berita Acara:</label>
			<input wire:model="beritaAcara" type="file" class="form-control-file @error('beritaAcara') is-invalid @enderror">

			@error('beritaAcara') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror

			<div wire:loading wire:target="beritaAcara">
			    <div class="spinner-border spinner-border-sm text-primary" role="status">
				  <span class="sr-only">Loading...</span>
				</div>
		    </div>
		</div>
		
		<button wire:loading.attr="disabled" wire:target="beritaAcara,uploadBeritaAcara" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
	  </form>
	</div>
	
	@endif
</div>
@endif