<div class="row">
	<div class="col-md-3">
	  
	  @include('ikami-usr::livewire.rik-nav')

      @include('ikami-usr::livewire.rik-ref')

	</div>

	<div class="col-md-6">
		@include('ikami-usr::livewire.rik-header')

		@include('ikami-usr::livewire.rik-flyer-1')

	    <div class="d-flex justify-content-center">
	       	<div wire:loading wire:target="loadAspek,loadArea,periksaKembali,tutupPeriksaKembali,loadCekLapangan">
	        	<div class="spinner-grow text-primary" role="status">
			  		<span class="sr-only">Loading...</span>
				</div>
	        </div>
        </div>

        @php
			$navIndex = $navTarget->informasi->where('jawaban_2', '!=', null)->count();
		@endphp
		
		<div wire:loading.remove wire:target="loadAspek,loadArea,periksaKembali,tutupPeriksaKembali">
		
		@if(!$isRecheck)
		  
		  @if($navIndex < $navTarget->pertanyaan->count())
			
			@if($uAsesmen->terkunci)
				
				<div class="info-box bg-{{ $uAsesmen->jadwal->lte(Carbon\Carbon::now()) ? 'danger' : 'warning' }}">
	              <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
	              <div class="info-box-content">
	                <span class="info-box-text">
	                </span>
	                <span class="info-box-number"> 
	                	Desktop Assessment
						<span class="info-box-number float-right"><small>{{ $uAsesmen->jadwal->toDayDateTimeString() }}</small></span>
	                </span>
	                <div class="progress">
	                  <div class="progress-bar" style="width: {{ $uAsesmen->jadwal->gt(Carbon\Carbon::now()) ? round((env('MAX_DATE_DA') - $uAsesmen->jadwal->diffInDays())/env('MAX_DATE_DA')*100) : 100 }}%"></div>
	                </div>
	                
	                <span class="progress-description"><a href="{{ $uAsesmen->location }}" target="_blank" class="text-{{ $uAsesmen->jadwal->lte(Carbon\Carbon::now()) ? 'white' : 'dark' }}">{{ strtoupper($uAsesmen->tempat) }} <i class="fas fa-map-marker-alt"></i></a></span>

	                <span class="progress-description">
	              	    <small>
	                  		<marquee direction="left" scrollamount="2" align="center">{{ $uAsesmen->jadwal->diffForHumans() }}!</marquee>
	              		</small>
	                </span>

	                <span class="progress-description">
	                  @if(!is_null($uAsesmen->kode_akses))
	                  	<div class="form-group">
	                  		<div class="input-group input-group-sm">
				              <input wire:model="kodeAkses" type="text" class="form-control @error('kodeAkses') is-invalid @enderror" placeholder="Kode Akses:">
				              <span class="input-group-append">
				                <button wire:loading.attr="disabled" wire:target="kirimKodeAkses"  wire:click="kirimKodeAkses" type="button" class="btn btn-info btn-flat"><i class="fas fa-envelope"></i> Kirim</button>
				              </span>
				            </div>

				            @error('kodeAkses') <span class="invalid-feedback d-block text-white"><i>{{ $message }}</i></span> @enderror

	                  		<small class="form-text">
	                  		<a wire:click="mintaUlangKodeAkses" href="javascript:void(0)" class="text-white">
	                  		Minta ulang kode akses
	                  	
	                  		</a>
		                  	<div wire:loading wire:target="mintaUlangKodeAkses">
						        <div class="spinner-border spinner-border-sm text-white" role="status">
								  <span class="sr-only">Loading...</span>
								</div>
					        </div>
	                  		</small>
	                  	</div>
	                  @else
	                  	<small><i class="fas fa-lock"></i> <i>Asesmen ini masih terkunci.</i></small>
	                  @endif
					  
					  @if($uAsesmen->jadwal->lte(Carbon\Carbon::now()) && is_null($uAsesmen->kode_akses))
	                  	<small class="float-right">
		                  	<a wire:click="mintaKodeAkses" href="javascript:void(0)" class="text-white">
		                  	Minta kode akses
		                  	</a>
		                  	<div wire:loading wire:target="mintaKodeAkses">
						        <div class="spinner-border spinner-border-sm text-white" role="status">
								  <span class="sr-only">Loading...</span>
								</div>
					        </div>
	                  	</small>
	                  @elseif($uAsesmen->jadwal->gt(Carbon\Carbon::now()))
	                  	<small class="float-right">
	                  	 	<a wire:click="$refresh" href="javascript:void(0)" class="text-{{ $uAsesmen->jadwal->lte(Carbon\Carbon::now()) ? 'white' : 'dark' }}">Periksa pembaruan</a>
	                  		<div wire:loading wire:target="$refresh">
					        	<div class="spinner-border spinner-border-sm text-primary" role="status">
								  <span class="sr-only">Loading...</span>
								</div>
				        	</div>
	                  	</small>
					  @endif

	                </span>

	              </div>
	              <span class="info-box-icon"><i class="far fa-clock"></i></span>
	              <!-- /.info-box-content -->
	            </div>
			@else

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
	        	  <form wire:submit.prevent="jawabPertanyaan('{{ $navTarget->informasi[$navIndex]->id }}')">
		        	  <div class="form-group">
		                @foreach($navTarget->pertanyaan[$navIndex]->pilihan->jawaban as $jawaban)
		                <div class="custom-control custom-radio">
		                  <input wire:model="jawabanId" class="custom-control-input" type="radio" id="customRadio{{ $jawaban->id }}" name="customRadio" value="{{ $jawaban->id }}">
		                  <label for="customRadio{{ $jawaban->id }}" class="custom-control-label">
		                  	@if($jawaban->id == $navTarget->informasi[$navIndex]->jawaban_1)
		                  	<i>{{ $jawaban->teks }}</i>
		                  	@else
		                  	{{ $jawaban->teks }}
		                  	@endif
		                  </label>
		                </div>
		                @endforeach
		                @error('jawabanId') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
		              </div>
		              <div class="form-group">
		              	<input wire:model="catatanId" type="text" class="form-control w-auto" placeholder="Catatan:">
		              </div>
		              <div class="form-group">
		              	<div class="custom-control custom-checkbox">
                          <input wire:model="cekLapanganId" class="custom-control-input" type="checkbox" id="customCheckbox1">
                          <label for="customCheckbox1" class="custom-control-label">Cek Lapangan</label>
                        </div>
		              </div>
		              <button wire:loading.attr="disabled" wire:target="jawabPertanyaan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
	              </form>
	        	</div>
	        </div>

	        @endif
        
          @else
	        
	        @include('ikami-usr::livewire.rik-flyer-2')
	        
          @endif
		
		@elseif($isCekLapangan)
		  
		  @include('ikami-usr::livewire.rik-oa')

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
						
						@if($jawaban->id == $informasi->jawaban_2) 
							checked 
						@endif
						
						@if($uAsesmen->selesai)
							disabled 
						@endif
	                  	>
	                  <label for="customRadio{{ $pertanyaan->id }}-{{ $jawaban->id }}" 
	                  	class="custom-control-label">
	                  	@if($jawaban->id == $informasi->jawaban_1)
	                  	<i>{{ $jawaban->teks }}</i>
	                  	@else
	                  	{{ $jawaban->teks }}
	                  	@endif
	                  </label>
	                </div>
	                @endforeach
	                
	              </div>

				  @if(!$uAsesmen->selesai)
	              <div class="form-group">
	              	<input wire:model="catatan.{{ $pertanyaan->id }}" type="text" class="form-control w-auto" placeholder="Catatan:" value="{{ $informasi->catatan }}"
	              	>
	              </div>
	              <div class="form-group">
	              	<div class="custom-control custom-checkbox">
                      <input wire:model="cekLapangan.{{ $pertanyaan->id }}" class="custom-control-input" type="checkbox" id="customCheckbox{{ $pertanyaan->id }}" @if($informasi->confirm) checked @endif>
                      <label for="customCheckbox{{ $pertanyaan->id }}" class="custom-control-label">Cek Lapangan</label>
                    </div>
	              </div>
	              
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
		
		@include('ikami-usr::livewire.rik-dok')

	</div>

	<div class="col-md-3">
		
		@include('ikami-usr::livewire.kategorisasi')

	</div>
</div>

