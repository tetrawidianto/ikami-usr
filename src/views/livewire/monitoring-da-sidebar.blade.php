<div>
	<div class="card">
		<div class="card-header">
			<div class="card-title">
				Penjadwalan
				
				@if($isTerjadwal)
					@if(!$isEdit)
						<a wire:loading.remove wire:target="ubahPenjadwalan,batalUbahPenjadwalan" wire:click="ubahPenjadwalan" href="javascript:void(0)"><small><i>(Ubah)</i></small></a>
					@else
						<a wire:loading.remove wire:target="batalUbahPenjadwalan,ubahPenjadwalan" wire:click="batalUbahPenjadwalan" href="javascript:void(0)"><small><i>(Batal)</i></small></a>
					@endif
					<div wire:loading wire:target="ubahPenjadwalan,batalUbahPenjadwalan" class="spinner-border spinner-border-sm text-primary" role="status">
					  <span class="sr-only">Loading...</span>
					</div>
				@endif
			
			</div>
			<div class="card-tools">
				<button wire:click="closeSidebar" type="button" class="btn btn-tool" data-widget="control-sidebar"><i class="fas fa-times"></i>
                  </button>
			</div>
		</div>
		<div class="card-body p-2">
		
			<div @if(!$isTerjadwal || $isTerjadwal && $isEdit) style="display: none;" @endif>
				<div class="form-group">
					<label class="control-label">Tanggal:</label>
					<div class="form-control-static">{{ !$model ?: !$model->jadwal ?: $model->jadwal->toDateString() }}</div>
				</div>
				<div class="form-group">
					<label class="control-label">Waktu:</label>
					<div class="form-control-static">{{ !$model ?: !$model->waktu ?: $model->jadwal->format('H:i') }}</div>
				</div>
				<div class="form-group">
					<label class="control-label">Tempat:</label>
					<div class="form-control-static"><a href="{{ $model ? $model->location : '#' }}" target="_blank">{{ !$model ?: $model->tempat }}</a></div>
				</div>
				
				<div class="form-group">
					<label class="control-label">Asesor:</label>
					<div class="form-control-static">
						@if($model && $model->asesor)
						<ul>
							@foreach($model->asesor as $asesor)
							<li>{{ $asesor->name }}</li>
							@endforeach
						</ul>
						@endif
					</div>
				</div>
			</div>
				
			<div @if($isTerjadwal) style="display: none;" @endif>
				<form wire:submit.prevent="tambahJadwal">
					<div class="form-group">
						<div class="input-group">
	                    <div class="input-group-prepend">
	                      <span class="input-group-text">
	                        <i class="far fa-calendar-alt"></i>
	                      </span>
	                    </div>
	                    <input wire:model="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror">
	                  	</div>
						@error('tanggal') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
					</div>
					<div class="form-group">
						<div class="input-group">
	                    <div class="input-group-prepend">
	                      <span class="input-group-text"><i class="far fa-clock"></i></span>
	                    </div>
	                    <input wire:model="waktu" type="time" class="form-control @error('waktu') is-invalid @enderror">
	                  	</div>
						@error('waktu') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
					</div>
					<div class="form-group">
						{{-- <label class="control-label">Tempat:</label> --}}
						<textarea wire:model="tempat" rows="2" class="form-control @error('tempat') is-invalid @enderror" placeholder="Tempat:"></textarea>
						@error('tempat') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
					</div>
					<div class="form-group">
						{{-- <label class="control-label">Tempat:</label> --}}
						<input wire:model="location" type="text" class="form-control @error('location') is-invalid @enderror" placeholder="Tautan lokasi:">
						@error('location') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
					</div>
					<div class="form-group">
						<label class="control-label">Asesor:</label>
						<div wire:ignore wire:key="first">
						<select class="form-control select2 @error('asesor') is-invalid @enderror" multiple>
							{{-- <option ></option> --}}
							@foreach($listAsesor as $asesor)
							<option value="{{ $asesor->id }}">{{ $asesor->name }}</option>
							@endforeach
						</select>
						</div>
						@error('asesor') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
					</div>
					<button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				</form>
			</div>
			
			<div @if(!$isTerjadwal || $isTerjadwal && !$isEdit) style="display: none;" @endif>
				<form wire:submit.prevent="ubahJadwal">
					<div class="form-group">
						<div class="input-group">
	                    <div class="input-group-prepend">
	                      <span class="input-group-text">
	                        <i class="far fa-calendar-alt"></i>
	                      </span>
	                    </div>
	                    <input wire:model="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror">
	                  	</div>
						@error('tanggal') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
					</div>
					<div class="form-group">
						<div class="input-group">
	                    <div class="input-group-prepend">
	                      <span class="input-group-text"><i class="far fa-clock"></i></span>
	                    </div>
	                    <input wire:model="waktu" type="time" class="form-control @error('waktu') is-invalid @enderror">
	                  	</div>
						@error('waktu') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
					</div>
					<div class="form-group">
						{{-- <label class="control-label">Tempat:</label> --}}
						<textarea wire:model="tempat" rows="2" class="form-control @error('tempat') is-invalid @enderror" placeholder="Tempat:"></textarea>
						@error('tempat') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
					</div>
					<div class="form-group">
						{{-- <label class="control-label">Tempat:</label> --}}
						<input wire:model="location" type="text" class="form-control @error('location') is-invalid @enderror" placeholder="Tautan lokasi:">
						@error('location') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
					</div>
					<div class="form-group">
						<label class="control-label">Asesor:</label>
						<div wire:ignore wire:key="second">
						<select class="form-control select2 @error('asesor') is-invalid @enderror" multiple>
							{{-- <option ></option> --}}
							@foreach($listAsesor as $asesor)
							<option value="{{ $asesor->id }}">{{ $asesor->name }}</option>
							@endforeach
						</select>
						</div>
						@error('asesor') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
					</div>
					<button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				</form>
			</div>

		</div>
	</div>
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
	  
      	$('.select2').on('change', function (e) {
        	@this.set('asesor', $(this).val());
      	})

    	window.livewire.on('selectAsesor', (selected) => {
	    	$('.select2').val(JSON.parse(selected)).trigger('change')
		});

		window.livewire.on('clearAsesor', (selected) => {
	    	$('.select2').val(null).trigger('change')
		});
	</script>
@endpush