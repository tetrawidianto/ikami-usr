<div class="row">
	<div class="col-md-3">
	  
	  @include('ikami-usr::livewire.lak-nav')

	  @include('ikami-usr::livewire.lak-ref')
      
	</div>

	<div class="col-md-6">
		@include('ikami-usr::livewire.lak-header')

        @include('ikami-usr::livewire.lak-flyer-1')

	    <div class="d-flex justify-content-center">
	       	<div wire:loading wire:target="loadAspek,loadArea,periksaKembali,tutupPeriksaKembali">
	        	<div class="spinner-grow text-primary" role="status">
			  		<span class="sr-only">Loading...</span>
				</div>
	        </div>
        </div>

        @php
			$navIndex = $navTarget->informasi->count();
		@endphp
		
		<div wire:loading.remove wire:target="loadAspek,loadArea,periksaKembali,tutupPeriksaKembali">
		@if(!$isRecheck)
		  @if($navIndex < $navTarget->pertanyaan->count())
			
			<h4>{{ $navTarget->nama }} #{{ $navIndex + 1 }}</h4>
			
			<div class="form-group">
				@if($navTarget->pertanyaan[$navIndex]->kematangan)
				<small>Kematangan:</small> <span class="badge badge-danger">{{ $navTarget->pertanyaan[$navIndex]->kematangan->nama }}</span>
				@endif
				@if($navTarget->pertanyaan[$navIndex]->kesiapan)
				<small>Kesiapan:</small> <span class="badge badge-warning">{{ $navTarget->pertanyaan[$navIndex]->kesiapan->nama }}</span>
				@endif
			</div>
			
	        <div class="card card-info">
	        	<div class="card-header">
	        		<div class="card-title">
	        			{{ $navTarget->pertanyaan[$navIndex]->teks }}
	        		</div>
	        	</div>
	        	<div class="card-body">
	        	  <form wire:submit.prevent="jawabPertanyaan('{{ $navTarget->pertanyaan[$navIndex]->id }}', '{{ $navTarget->id }}', '{{ $navTarget->area_id }}')">
		        	  <div class="form-group">
		                @foreach($navTarget->pertanyaan[$navIndex]->pilihan->jawaban as $jawaban)
		                <div class="custom-control custom-radio">
		                  <input wire:model="jawabanId" class="custom-control-input" type="radio" id="customRadio{{ $jawaban->id }}" name="customRadio" value="{{ $jawaban->id }}">
		                  <label for="customRadio{{ $jawaban->id }}" class="custom-control-label">{{ $jawaban->teks }}</label>
		                </div>
		                @endforeach
		                @error('jawabanId') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
		              </div>
		              <button wire:loading.attr="disabled" wire:target="jawabPertanyaan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
	              </form>
	        	</div>
	        </div>
        
          @else
	        @if($uAsesmen->terjawabSemua())
				<div class="alert alert-success alert-dismissible">
		          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		          <h5><i class="icon fas fa-check"></i> Selamat!</h5>
		          <small>Anda telah menyelesaikan asesmen <b>Indeks KAMI</b> secara mandiri. <a wire:click="periksaKembali" href="javascript:void(0)">Periksa kembali</a> area: <b>{{ $navTarget->nama }}</b>.</small>
		        </div>
	        @else
				<div class="alert alert-info alert-dismissible">
		          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		          <h5><i class="icon fas fa-check"></i> Selesai!</h5>
		          <small>Area: <b>{{ $navTarget->nama }}</b> telah selesai dijawab. <a wire:click="periksaKembali" href="javascript:void(0)">Periksa kembali</a></small>
		        </div>
	        @endif
	        
          @endif

		@elseif($isCekLapangan)
		  <h4>Daftar Onsite Assessment</h4> 
			
		  @foreach($daftarKonfirmasi as $index => $konfirmasi)
			<div class="card card-{{ $konfirmasi->informasi->confirmed ? 'success' : 'warning' }}">
				<div class="card-header">
					<div class="card-title">
						#{{ $index + 1 }} {{ $konfirmasi->teks }}
					</div>
				</div>
				<div class="card-body">
				  <div class="form-group">
	                @foreach($konfirmasi->pilihan->jawaban as $jawaban)
	                <div class="custom-control custom-radio">
	                  <input 
	                  class="custom-control-input" 
	                  type="radio" 
	                  id="customRadio{{ $konfirmasi->id }}-{{ $jawaban->id }}" 
	                  name="customRadio{{ $konfirmasi->id }}" 
	                  value="{{ $jawaban->id }}"
					  @if($jawaban->id == $konfirmasi->informasi->jawaban_1)
						checked
					  @endif
					  disabled 
	                  >
	                  <label for="customRadio{{ $konfirmasi->id }}-{{ $jawaban->id }}" class="custom-control-label">
	                  	@if($jawaban->id == $konfirmasi->informasi->jawaban_2)
	                  	<i>{{ $jawaban->teks }}</i>
	                  	@else
	                  	{{ $jawaban->teks }}
	                  	@endif
	                  </label>
	                </div>
	                @endforeach
	                
	              </div>
	              <div class="form-group">
	              	<span class="help-block"><i>{{ $konfirmasi->informasi->catatan }}</i></span>
	              </div>
				</div>
			</div>
		  @endforeach

		@else
		  <h4>{{ $navTarget->nama }} </h4> 
		  <div class="form-group">
		  	<div class="input-group input-group-sm">
              <input wire:model="search" type="text" class="form-control" placeholder="Cari...">
              <span class="input-group-append">
                <button wire:click="tutupPeriksaKembali" type="button" class="btn btn-danger btn-flat">x</button>
              </span>
            </div>
		  </div>

		  @php
		  	$informasi_count = $navTarget->informasi->count();
		  @endphp

		  @foreach($navTarget->pertanyaan as $pertanyaan)

		  @php
		  	$id = $pertanyaan->id;
		  	$key = $navTarget->informasi->search(function($i) use ($id) {
			    return $i->pertanyaan_id === $id;
			});

		  	$informasi = $navTarget->informasi[$key];
		  @endphp

		  <div class="card @if($informasi->confirm) @if($informasi->confirmed) card-success @else card-warning @endif @else card-info @endif">
        	<div class="card-header">
        		<div class="card-title">
        			#{{ $key + 1 }} {{ $pertanyaan->teks }}
        			<div>
						@if($pertanyaan->kematangan)
						<span class="badge badge-danger">{{ $pertanyaan->kematangan->nama }}</span>
						@endif
						@if($pertanyaan->kesiapan)
						<span class="badge badge-warning">{{ $pertanyaan->kesiapan->nama }}</span>
						@endif
					</div>
        		</div>
        	</div>
        	<div class="card-body">
        	  <form wire:submit.prevent="updateJawaban('{{ $informasi->id }}', '{{ $pertanyaan->id }}')">
	        	  <div class="form-group">
	                @foreach($pertanyaan->pilihan->jawaban as $jawaban)
	                <div class="custom-control custom-radio">
	                  <input wire:model="jawaban.{{ $pertanyaan->id }}"
	                  	class="custom-control-input" 
	                  	type="radio" 
	                  	id="customRadio{{ $pertanyaan->id }}-{{ $jawaban->id }}" 
	                  	name="customRadio{{ $pertanyaan->id }}" 
	                  	value="{{ $jawaban->id }}"
						
						@if($jawaban->id == $informasi->jawaban_1) 
							checked 
						@endif
						
						@if(!is_null($uAsesmen->jadwal))
							disabled 
						@endif
	                  	>
	                  <label for="customRadio{{ $pertanyaan->id }}-{{ $jawaban->id }}" 
	                  	class="custom-control-label">
	                  	@if($jawaban->id == $informasi->jawaban_2)
	                  	<i>{{ $jawaban->teks }}</i>
	                  	@else
	                  	{{ $jawaban->teks }}
	                  	@endif
	                  </label>
	                </div>
	                @endforeach
	                
	              </div>
	              @if(is_null($uAsesmen->jadwal))
	              	<button wire:loading.attr="disabled" wire:target="updateJawaban" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
	              @else
	              <div class="form-group">
	              	{{-- <label class="control-label">Catatan:</label> --}}
	              	<div class="form-control-static"><i>{{ $informasi->catatan }}</i></div>
	              </div>
				  @endif
              </form>
        	</div>
          </div>
		  @endforeach
		@endif
        </div>

        @include('ikami-usr::livewire.statistik')

		@include('ikami-usr::livewire.lak-dok')
		
	</div>

	<div class="col-md-3">
		
		@include('ikami-usr::livewire.kategorisasi')

	</div>
</div>
