<div>
	@if(session()->has('message'))
		<div class="alert alert-success alert-dismissible">
	      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	      <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
	      <small>Data telah tersimpan.</small>
	    </div>
    @endif
	
	@if($uPenyedia && $uPenyedia->status == IkamiAdm\Models\Status::MENUNGGU)
	    <div class="alert alert-info alert-dismissible">
	      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	      <h5><i class="icon fas fa-info"></i> Mohon menunggu!</h5>
	      <small>Kami sedang melakukan verifikasi data penyedia yang Anda kirimkan. 
	      	<a wire:click="$refresh" wire:loading.remove wire:target="$refresh" href="javascript:void(0)">Periksa pembaruan</a> 
	      	<div wire:loading wire:target="$refresh" class="spinner-border spinner-border-sm text-primary" role="status">
			  <span class="sr-only">Loading...</span>
			</div>
	      </small>
	    </div>
    @endif

    @if($uPenyedia && $uPenyedia->status == IkamiAdm\Models\Status::DITOLAK)
	    <div class="alert alert-warning alert-dismissible">
	      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	      <h5><i class="icon fas fa-exclamation-triangle"></i> Mohon perhatian!</h5>
	      <small>Penyedia belum dapat kami terima dengan alasan: <b>{{ $uPenyedia->status()->reason }}</b>. @if(!$isKoreksiPenyedia) <a wire:click="bukaKoreksiPenyedia" href="javascript:void(0)">Koreksi</a> @endif
			<div wire:loading wire:target="bukaKoreksiPenyedia" class="spinner-border spinner-border-sm text-primary" role="status">
			  <span class="sr-only">Loading...</span>
			</div>
	      </small> 
	    </div>
    @endif

    @if($uPengguna && $uPengguna->status == IkamiAdm\Models\Status::MENUNGGU)
	    <div class="alert alert-info alert-dismissible">
	      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	      <h5><i class="icon fas fa-info"></i> Mohon menunggu!</h5>
	      <small>Kami sedang melakukan verifikasi data pengguna yang Anda kirimkan. 
	      	<a wire:click="$refresh" wire:loading.remove wire:target="$refresh" href="javascript:void(0)">Periksa pembaruan</a> 
	      	<div wire:loading wire:target="$refresh" class="spinner-border spinner-border-sm text-primary" role="status">
			  <span class="sr-only">Loading...</span>
			</div>
	      </small>
	    </div>
    @endif

    @if($uPengguna && $uPengguna->status == IkamiAdm\Models\Status::DITOLAK)
	    <div class="alert alert-warning alert-dismissible">
	      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	      <h5><i class="icon fas fa-exclamation-triangle"></i> Mohon perhatian!</h5>
	      <small>Akun Anda belum dapat kami aktifkan dengan alasan: <b>{{ $uPengguna->status()->reason }}</b>. @if(!$isKoreksiPengguna) <a wire:click="bukaKoreksiPengguna" href="javascript:void(0)">Koreksi</a> @endif
			<div wire:loading wire:target="bukaKoreksiPengguna" class="spinner-border spinner-border-sm text-primary" role="status">
			  <span class="sr-only">Loading...</span>
			</div>
	      </small> 
	    </div>
    @endif

    @if($uPengguna && $uPengguna->status == IkamiAdm\Models\Status::DITERIMA)
		<div class="alert alert-success alert-dismissible">
	      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	      <h5><i class="icon fas fa-check"></i> Selamat!</h5>
	      <small>Akun Anda telah aktif. <a href="javascript:void(0)" onclick="window.location.reload()">Muat ulang</a></small>
	    </div>
    @endif

	@if(is_null($uPenyedia) && is_null($uPengguna))
	<form wire:submit.prevent="inisiasi">
		<div class="form-group">
	        <div class="custom-control custom-switch custom-switch-off-warning custom-switch-on-success">
	          <input wire:model="aktivasi" type="checkbox" class="custom-control-input" id="modeSwitch">
	          <label class="custom-control-label" for="modeSwitch">{{ __('Mode') }} {{ $aktivasi ? 'Aktivasi' : 'Registrasi' }}</label>
	          
	          <div wire:loading wire:target="aktivasi" class="spinner-border spinner-border-sm text-primary" role="status">
            	<span class="sr-only">Loading...</span>
          	  </div>
	        </div>
		    
      	</div>
		
      	<div class="form-group" @if(!$aktivasi) style="display: none;" @endif>
      		<label class="control-label">Pilih Instansi/Perusahaan:</label>
      		
      		<div wire:ignore wire:key="first">
      			<select id="penyedia-terpilih-select2" class="form-control select2 @error('namaSingkat') is-invalid @enderror">
	      			<option></option>
	      			@foreach($daftarPenyedia as $penyedia)
	      				<option value="{{ $penyedia->id }}">{{ $penyedia->nama }}</option>
	      			@endforeach
	      		</select>
      		</div>
      		
			@error('penyediaTerpilih') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
		</div>

		@if(!$aktivasi)

		<div class="form-group">
			<input wire:model="nama" type="text" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Singkat Instansi/Perusahaan">
			@error('nama') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
		</div>
		<div class="form-group">
			<input wire:model="namaPanjang" type="text" class="form-control @error('namaPanjang') is-invalid @enderror" placeholder="Nama Panjang Instansi/Perusahaan">
			@error('namaPanjang') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
		</div>
		<div class="form-group">
			<textarea wire:model="alamat" nrows="2" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat"></textarea>
			@error('alamat') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
		</div>
		<div class="form-group">
			<input wire:model="website" type="text" class="form-control @error('website') is-invalid @enderror" placeholder="Website">
			@error('website') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
		</div>
		<div class="form-group">
			<input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
			@error('email') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
		</div>
		<div class="form-group">
			<input wire:model="nomorTelepon" type="text" class="form-control @error('nomorTelepon') is-invalid @enderror" placeholder="Telepon">
			@error('nomorTelepon') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
		</div>

		@endif
		
		<hr>

		<div class="form-group">
			<label class="control-label">KTP:</label>
      		<input wire:model="ktp" type="file" class="form-control-file">
      		@error('ktp') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
      		<div wire:loading wire:target="ktp" class="spinner-border spinner-border-sm text-primary" role="status">
        		<span class="sr-only">Loading...</span>
      	  	</div>
      	</div>
		
      	<div class="form-group">
      		<label class="control-label">Tanda Pengenal Instansi/Perusahaan:</label>
      		<input wire:model="tandaPengenal" type="file" class="form-control-file">
      		@error('tandaPengenal') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
      		<div wire:loading wire:target="tandaPengenal" class="spinner-border spinner-border-sm text-primary" role="status">
        		<span class="sr-only">Loading...</span>
      	  	</div>
      	</div>

  		<button wire:loading.attr="disabled" wire:target="aktivasi,ktp,tandaPengenal" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
  	</form>

  	@elseif($uPenyedia && $uPenyedia->status == IkamiAdm\Models\Status::DITOLAK && $isKoreksiPenyedia)
		<form wire:submit.prevent="koreksiPenyedia">
			<div class="form-group">
				<input wire:model="nama" type="text" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Singkat Instansi/Perusahaan">
				@error('nama') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
			</div>
			<div class="form-group">
				<input wire:model="namaPanjang" type="text" class="form-control @error('namaPanjang') is-invalid @enderror" placeholder="Nama Panjang Instansi/Perusahaan">
				@error('namaPanjang') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
			</div>
			<div class="form-group">
				<textarea wire:model="alamat" nrows="2" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat"></textarea>
				@error('alamat') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
			</div>
			<div class="form-group">
				<input wire:model="website" type="text" class="form-control @error('website') is-invalid @enderror" placeholder="Website">
				@error('website') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
			</div>
			<div class="form-group">
				<input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
				@error('email') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
			</div>
			<div class="form-group">
				<input wire:model="nomorTelepon" type="text" class="form-control @error('nomorTelepon') is-invalid @enderror" placeholder="Telepon">
				@error('nomorTelepon') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
			</div>

	  		<button wire:loading.attr="disabled" wire:target="aktivasi,ktp,tandaPengenal" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
	  	</form>

  	@elseif($uPengguna && $uPengguna->status == IkamiAdm\Models\Status::DITOLAK && $isKoreksiPengguna)
		<form wire:submit.prevent="koreksiPengguna">
			<div class="form-group">
				<label class="control-label">Pilih Instansi/Perusahaan:</label>
	      		<select wire:model="penyediaTerpilih" class="form-control @error('namaSingkat') is-invalid @enderror" disabled>
	      			<option></option>
	      			@foreach($daftarPenyedia as $penyedia)
	      				
	      				<option value="{{ $penyedia->id }}">{{ $penyedia->nama }}</option>
	      			@endforeach
	      		</select>
				@error('penyediaTerpilih') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
			</div>
			
			<div class="form-group">
				<label class="control-label">KTP:</label>
	      		<input wire:model="ktp" type="file" class="form-control-file">
	      		@error('ktp') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
	      		<div wire:loading wire:target="ktp" class="spinner-border spinner-border-sm text-primary" role="status">
	        		<span class="sr-only">Loading...</span>
	      	  	</div>
	      	</div>
			
	      	<div class="form-group">
	      		<label class="control-label">Tanda Pengenal Instansi/Perusahaan:</label>
	      		<input wire:model="tandaPengenal" type="file" class="form-control-file">
	      		@error('tandaPengenal') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
	      		<div wire:loading wire:target="tandaPengenal" class="spinner-border spinner-border-sm text-primary" role="status">
	        		<span class="sr-only">Loading...</span>
	      	  	</div>
	      	</div>

	  		<button wire:loading.attr="disabled" wire:target="aktivasi,ktp,tandaPengenal" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
		</form>
  	@endif
</div>

@push('js')
	<script>
	  $(document).ready(function() {
	  	$('.select2').select2({
	        theme: 'bootstrap4',
	        width: "100%",
	        placeholder: "",
	        allowClear: true,
	      })
	  })
	  
      $('#penyedia-terpilih-select2').on('change', function (e) {
          @this.set('penyediaTerpilih', e.target.value);
      })
	</script>
@endpush