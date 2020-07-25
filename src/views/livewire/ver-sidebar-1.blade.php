<div>
	<div class="card">
		<div class="card-header">
			<div class="card-title">
				Persetujuan 

				@if(!$isEdit)
					<a wire:click="ubahStatus" href="javascript:void(0)"><small><i>(Ubah)</i></small></a>
				@else
					<a wire:click="batalUbahStatus" href="javascript:void(0)"><small><i>(Batal)</i></small></a>
				@endif

				<div wire:loading wire:target="ubahStatus,batalUbahStatus" class="spinner-border spinner-border-sm text-primary" role="status">
				  <span class="sr-only">Loading...</span>
				</div>
			</div>
			<div class="card-tools">
				<button wire:click="closeSidebar" type="button" class="btn btn-tool" data-widget="control-sidebar"><i class="fas fa-times"></i>
                  </button>
			</div>
		</div>

		<div class="card-body p-2">
		@if(!$isEdit)
			<div class="form-group">
				<label class="control-label">ID:</label>
				<div class="form-control-static">{{ !$model ?: $model->id }}</div>
			</div>
			<div class="form-group">
				<label class="control-label">Status:</label>
				<div class="form-control-static">
					<span class="badge badge-{{ $model ? $model->status()->badge : 'light' }}">{{ !$model ?: $model->status }}</span>
				</div>
			</div>

			@if($path == 'ver-sistem-el')
			<div class="form-group">
				<label class="control-label">Sektor:</label>
				<div class="form-control-static">{{ $model && $model->sektor ? $model->sektor->nama : '-' }}</div>
			</div>
			@endif
		
		@else

			<form wire:submit.prevent="updateStatus">
				<div class="form-group">
			        <div class="custom-control custom-switch custom-switch-off-success custom-switch-on-danger">
			          <input wire:model="ditolak" type="checkbox" class="custom-control-input" id="modeSwitch">
			          <label class="custom-control-label" for="modeSwitch">{{ $ditolak ? 'Ditolak' : 'Diterima' }}</label>
			          
			          <div wire:loading wire:target="ditolak" class="spinner-border spinner-border-sm text-primary" role="status">
		            	<span class="sr-only">Loading...</span>
		          	  </div>
			        </div>
				    
		      	</div>

		      	@if(!$ditolak && $path == 'ver-sistem-el')
				<div class="form-group">
					<label class="control-label">Pilih Sektor:</label>
					<select wire:model="sektorTerpilih" class="form-control @error('sektorTerpilih') is-invalid @enderror">
						<option ></option>
						@foreach($listSektor as $sektor)
						<option value="{{ $sektor->id }}">{{ $sektor->nama }}</option>
						@endforeach
					</select>
					@error('sektorTerpilih')
						<span class="invalid-feedback d-block">{{ $message }}</span>
					@enderror
				</div>
		      	@endif
				
				@if($ditolak)
					<div class="form-group">
						<textarea wire:model="alasan" rows="2" class="form-control @error('alasan') is-invalid @endif" placeholder="Berikan alasan..."></textarea>
						@error('alasan')
							<span class="invalid-feedback d-block">{{ $message }}</span>
						@enderror
					</div>
				@endif
				
				@if($model && ($model->status == IkamiAdm\Models\Status::DITERIMA && $ditolak || $model->status == IkamiAdm\Models\Status::DITOLAK && !$ditolak || $model->status == IkamiAdm\Models\Status::MENUNGGU))
				<button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				@endif
			</form>
		@endif
		</div>
	</div>
</div>