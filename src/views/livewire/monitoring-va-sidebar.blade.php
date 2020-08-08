<div>
	<div class="card">
		<div class="card-header">
			<div class="card-title">
				@if(!$isVa) Rekam @endif VA 
				@if($isVa)
					@if($isEdit)
						<a wire:loading.remove wire:target="ubahVa,batalUbahVa" wire:click="batalUbahVa" href="javascript:void(0)"><small><i>(Batal)</i></small></a>
					@else
						<a wire:loading.remove wire:target="batalUbahVa,ubahVa" wire:click="ubahVa" href="javascript:void(0)"><small><i>(Ubah)</i></small></a>
					@endif
				@endif
			</div>
			<div class="card-tools">
				<button wire:click="closeSidebar" type="button" class="btn btn-tool" data-widget="control-sidebar"><i class="fas fa-times"></i>
                  </button>
			</div>
		</div>
		<div class="card-body p-2">
			@if($isVa)
				@if($isEdit)
				{{-- Edit VA --}}
				<form wire:submit.prevent="updateVa">
					<div class="form-group">
						<input wire:model="avg_cvss" type="text" class="form-control @error('avg_cvss') is-invalid @enderror" placeholder="Average CVSS Score:">
						@error('avg_cvss') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
					</div>
					<div class="form-group">
						<input wire:model="app_sec" type="text" class="form-control @error('app_sec') is-invalid @enderror" placeholder="App Security Score:">
						@error('app_sec') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
					</div>
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
						<input wire:model="dokumen" type="file" class="form-control-file">
						@error('dokumen') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
						<div wire:loading wire:target="dokumen" class="spinner-border spinner-border-sm text-primary" role="status">
			        		<span class="sr-only">Loading...</span>
			      	  	</div>
					</div>
					<button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				</form>
				@else
				{{-- View VA --}}
				<div class="form-group">
					<label class="control-label">Average CVSS:</label>
					<div class="form-control-static">{{ $avg_cvss }}</div>
				</div>
				<div class="form-group">
					<label class="control-label">App Security:</label>
					<div class="form-control-static">{{ $app_sec }}/100</div>
				</div>
				<div class="form-group">
					<label class="control-label">Tanggal:</label>
					<div class="form-control-static">{{ $tanggal }}</div>
				</div>
				<div class="form-group">
					
					<a href="javascript:void(0)" onclick="window.open('{{ route('dokumen-va', $itemId)  }}', 'dok-va', 'height=800,width=600')">Dokumen VA</a>
				</div>
				@endif
			@else
				{{-- Rekam VA --}}
				<form wire:submit.prevent="tambahVa">
					<div class="form-group">
						<input wire:model="avg_cvss" type="text" class="form-control @error('avg_cvss') is-invalid @enderror" placeholder="Average CVSS Score:">
						@error('avg_cvss') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
					</div>
					<div class="form-group">
						<input wire:model="app_sec" type="text" class="form-control @error('app_sec') is-invalid @enderror" placeholder="App Security Score:">
						@error('app_sec') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
					</div>
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
						<input wire:model="dokumen" type="file" class="form-control-file">
						@error('dokumen') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
						<div wire:loading wire:target="dokumen" class="spinner-border spinner-border-sm text-primary" role="status">
			        		<span class="sr-only">Loading...</span>
			      	  	</div>
					</div>
					<button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				</form>
			@endif
		</div>
	</div>
</div>
