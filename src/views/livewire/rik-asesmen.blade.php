<div class="row">
	<div class="col-md-3">
	  <a wire:click="loadArea(1)" href="javascript:void(0)" class="btn btn-{{ $navLink == 1 ? 'warning' : 'outline-primary' }} btn-block mb-3">Kategori Sistem El
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
		              <a wire:click="loadArea('{{ $area->id }}')" href="javascript:void(0)" class="nav-link @if($navLink == $area->id) active @endif">
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
              <a wire:click="loadAspek('{{ $aspek->id }}')" href="javascript:void(0)" class="nav-link @if($navLink == $aspek->id + 6) active @endif">
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

      <div class="card">
  		<div class="card-header">
  			<div class="card-title">
  				Referensi
  			</div>
  			<div class="card-tools">
            	<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            	</button>
          	</div>
  		</div>
  		<div class="card-body p-1">

  		  @if($uAsesmen->terkunci || $uAsesmen->selesai)
  		  	<ul>
				@foreach($uAsesmen->dokumenDa as $dokumen)
				<li>{{ $dokumen->judul_dokumen }}</li>
				@endforeach
			</ul>
  		  
		  @else
			  <ul class="list-group">
			  	@foreach($uAsesmen->dokumenDa as $dokumen)
			  	<li class="list-group-item d-flex justify-content-between align-items-center">
					{{ $dokumen->judul_dokumen }}
				<a wire:loading.remove wire:target="hapusDokumen" wire:click="hapusDokumen('{{ $dokumen->id }}')" href="javascript:void(0)" class="text-danger">
					<span class="fas fa-times"></span>
				</a>
				<div wire:loading wire:target="hapusDokumen">
			        <div class="spinner-border spinner-border-sm text-primary" role="status">
					  <span class="sr-only">Loading...</span>
					</div>
					
		        </div>
			  	</li>
			  	@endforeach
			  </ul>
		  @endif
  		</div>
  		
  		@if(!($uAsesmen->terkunci || $uAsesmen->selesai))
  		<div class="card-footer p-2">
  		  <div class="form-group">
  		  	<label class="control-label">Tambah dokumen:</label>
		  	<div class="input-group">
                <input wire:model="dokumen" type="text" class="form-control @error('dokumen') is-invalid @enderror" placeholder="Judul:">
                
                <div class="input-group-append">
                  <button wire:click="tambahDokumen" wire:loading.attr="disabled" wire:target="tambahDokumen" type="button" class="btn btn-warning"><i class="fas fa-save"></i></button>
                </div>
            </div>
            @error('dokumen') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
		  </div>
  		</div>
  		@endif
      </div>

	</div>

	<div class="col-md-6">
		<div class="row">
          <div class="col-12 col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-server"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Sistem El
					@if($uAsesmen->terkunci)
					<i class="fas fa-lock text-danger float-right"></i>
					@else
					<i class="fas fa-unlock text-success float-right"></i>
					@endif
                </span>
                <span class="info-box-number">
                  {{ $asesmen->sistemEl->nama }} 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Versi</span>
                <span class="info-box-number">{{ $asesmen->versi->kode }} <small class="text-secondary"><i>{{ $asesmen->jadwal->toDateString() }}</i></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>

		@if($uAsesmen->terevaluasiSemua())
			@if(!$uAsesmen->selesai)
				<div class="alert alert-info alert-dismissible">
		          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		          <h5><i class="icon fas fa-info"></i> Penutupan</h5>
		          <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium voluptas at, rerum, quam nemo, odit autem repellat perspiciatis delectus doloremque est enim qui vitae libero blanditiis consequuntur, et impedit fuga. 
		          	@if(!is_null($uAsesmen->berita_acara))
					<a onclick="confirm('{{ __('Apakah Anda sudah yakin?') }}') || event.stopImmediatePropagation()" wire:click="tutupAsesmen" href="javascript:void(0)">Tutup</a>
					@endif
		          </small>
		        </div>
			@else
				<div class="alert alert-primary alert-dismissible">
		          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		          <h5><i class="icon fas fa-certificate"></i> Selesai!</h5>
		          <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium voluptas at, rerum, quam nemo, odit autem repellat perspiciatis delectus doloremque est enim qui vitae libero blanditiis consequuntur, et impedit fuga. </small>
		        </div>
			@endif
		@endif


	    <div class="d-flex justify-content-center">
	       	<div wire:loading wire:target="loadAspek,loadArea,periksaKembali,tutupPeriksaKembali">
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
		              <button wire:loading.attr="disabled" wire:target="jawabPertanyaan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
	              </form>
	        	</div>
	        </div>

	        @endif
        
          @else
	        @if($uAsesmen->terevaluasiSemua())
				<div class="alert alert-success alert-dismissible">
		          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		          <h5><i class="icon fas fa-check"></i> Selamat!</h5>
		          <small>Anda telah menyelesaikan pemeriksaan asesmen mandiri <b>Indeks KAMI</b>. <a wire:click="periksaKembali" href="javascript:void(0)">Periksa kembali</a> area: <b>{{ $navTarget->nama }}</b>.</small>
		        </div>
	        @else
				<div class="alert alert-info alert-dismissible">
		          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		          <h5><i class="icon fas fa-check"></i> Selesai!</h5>
		          <small>Area: <b>{{ $navTarget->nama }}</b> telah selesai diperiksa. Anda dapat menuju area lain yang belum diperiksa. <a wire:click="periksaKembali" href="javascript:void(0)">Periksa kembali</a></small>
		        </div>
	        @endif
	        
          @endif
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

		  <div class="card card-info">
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

		
        <div class="card" @if(!$uAsesmen->terevaluasiSemua()) style="display: none;" @endif>
			<div class="card-header">
				<div class="card-title">
					Statistik
				</div>
			</div>
			<div wire:ignore class="card-body">
				<canvas id="radarChart"></canvas>
			</div>
		</div>

		@if($uAsesmen->terevaluasiSemua())
		<div class="row">
			<div class="col">
				<div class="info-box mb-3 bg-info">
	              <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>

	              <div class="info-box-content">
	                <span class="info-box-text">Skor Akhir</span> 
	                <span class="info-box-number">{{ $uAsesmen->skor_utama }}</span>
	              </div>
	              <!-- /.info-box-content -->
	            </div>
			</div>
			<div class="col">
				<div class="info-box mb-3 bg-{{ $uAsesmen->opini->color }}">
	              <span class="info-box-icon"><i class="fas fa-trophy"></i></span>

	              <div class="info-box-content">
	                <span class="info-box-text">Hasil Akhir</span> 
	                <span class="info-box-number">{{ $uAsesmen->opini->nama }}</span>
	              </div>
	              <!-- /.info-box-content -->
	            </div>
			</div>
		</div>

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
						<a href="javascript:void(0)" onclick="window.open('{{ route('berita-acara-asesor', $uAsesmen->id)  }}', 'ikami-preview', 'height=800,width=600')">Berita Acara</a>
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
			@endif

			@if(is_null($uAsesmen->berita_acara))
			<div class="card-footer">
			  <h5>Form Upload</h5>
			  <hr>
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

	</div>

	<div class="col-md-3">
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
	</div>
</div>

@push('js')
	<script src="{{ asset('vendor/chart.js/Chart.js') }}"></script>
	<script>
		var statistik = JSON.parse('{{ $statistik }}')

		var data = {
            labels: ['Tata Kelola', 'Pengelolaan Risiko', 'Kerangka Kerja', 'Pengelolaan Aset', 'Teknologi'],
            datasets: [
                {
                    label: "Asesmen",
                    backgroundColor: "rgba(0, 0, 0, 0)",
                    borderColor: "rgba(255,133,27, 0.8)",
                    data: statistik
                },
                {
                    label: "Kerangka Kerja Dasar",
                    backgroundColor: "rgba(11,156,49,0.6)",
                    data: [24, 30, 36, 72, 42]
                },
                {
                    label: "Penerapan Operasional",
                    backgroundColor: "rgba(11,156,49,0.4)",
                    data: [72, 54, 96, 132, 102]
                },
                {
                    label: "Kepatuhan ISO 27001",
                    backgroundColor: "rgba(11,156,49,0.2)",
                    data: [126, 72, 159, 168, 120]
                },
            ]
        }

        var options = {
            scale: {
                ticks: {
                    display: false
                }
            },
            legend: {
              position: 'bottom'
            }
        }

        var ctx = document.getElementById('radarChart').getContext('2d');

        var chart = new Chart(ctx, {
		    type: 'radar',
		    data: data,
		    options: options
		})

		window.livewire.on('updateRadarChart', (statistik) => {
		    chart.data.datasets[0].data = JSON.parse(statistik)
		    chart.update()
		});

	</script>
@endpush
