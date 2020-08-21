@if($uAsesmen->terjawabSemua())
	
  @if($uAsesmen->status == IkamiAdm\Models\Status::SA)
    
    <div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-question"></i> Desktop Assessment</h5>
      <small>Anda dapat meningkatkan validitas hasil asesmen ini melalui <b>Desktop Assessment</b>. 
      
      @if($uAsesmen->dokumenDa->count() > 0) 
        <a onclick="upgrade() || event.stopImmediatePropagation()" wire:click="upgradeAsesmen" href="javascript:void(0)">Daftar</a> 
			@else
			 Mohon diisi terlebih dahulu dokumen-dokumen yang menjadi referensi dalam asesmen ini.
      @endif

      </small>
    </div>

  @else

	  @if(is_null($uAsesmen->jadwal))
	
	    <div class="alert alert-primary alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Desktop Assessment</h5>
        <small>Mohon menunggu. Kami akan segera menjadwalkan kegiatan <b>Desktop Assessment</b> untuk Anda. <a wire:click="$refresh" href="javascript:void(0)">Periksa pembaruan</a>

		    <div wire:loading wire:target="$refresh">
	        <div class="spinner-border spinner-border-sm text-warning" role="status">
				    <span class="sr-only">Loading...</span>
				  </div>
			
        </div>
        </small>
      </div>
	
	  @elseif(!$uAsesmen->terevaluasiSemua())
      
      <div class="info-box bg-{{ $uAsesmen->jadwal->lte(Carbon\Carbon::now()) && $uAsesmen->terkunci ? 'danger' : $asesmen->status()->badge }}">
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
            @if(!is_null($uAsesmen->kode_akses) && !$uAsesmen->terkunci)
            	<small>
            		<marquee direction="left" scrollamount="2" align="center">Selamat mengikuti Desktop Assessment!</marquee>
        		</small>
        	  @else
        	    <small>
            		<marquee direction="left" scrollamount="2" align="center">{{ $uAsesmen->jadwal->diffForHumans() }}!</marquee>
        		</small>
            @endif
          </span>

          <span class="progress-description">
            @if(!is_null($uAsesmen->kode_akses) && $uAsesmen->terkunci)
            	<small>Kode Akses:</small> <span class="bg-primary">{{ $uAsesmen->kode_akses }}</span>
            @endif

            <small class="float-right">
            	<a wire:click="$refresh" href="javascript:void(0)" class="text-{{ $uAsesmen->jadwal->lte(Carbon\Carbon::now()) ? 'white' : 'dark' }}">Periksa pembaruan</a>
            	<div wire:loading wire:target="$refresh">
  			        <div class="spinner-border spinner-border-sm text-primary" role="status">
      					  <span class="sr-only">Loading...</span>
      					</div>
	            </div>
            </small>
          </span>

        </div>

        <span class="info-box-icon"><i class="far fa-clock"></i></span>
        <!-- /.info-box-content -->
      </div>

	  @elseif( (!$daftarKonfirmasi->isEmpty() && $daftarKonfirmasi->where('informasi.confirmed', true)->count() < $daftarKonfirmasi->count()))

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

	  @elseif(!$uAsesmen->selesai)
      <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Penandatanganan</h5>
        
        <small>
         Tanda tangan Berita Acara dan dokumen terkait lainnya. <a wire:click="$refresh" href="javascript:void(0)">Periksa pembaruan</a>

          <div wire:loading wire:target="$refresh">
            <div class="spinner-border spinner-border-sm text-warning" role="status">
              <span class="sr-only">Loading...</span>
            </div>
        
          </div>
        </small>
        
      </div>
    @else

	    <div class="alert alert-primary alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-certificate"></i> Selesai!</h5>
        <small>Asesmen ini telah selesai diperiksa oleh para asesor dan telah mendapatkan sertifikat dari <b>BSSN</b>.</small>
      </div>

    @endif

  @endif

@endif

@push('js')
  <script>
    function upgrade()
    {
      var jawaban = prompt("Silakan ketik: desktop-assessment");

      if(jawaban == 'desktop-assessment')
      {
        return true
      }
      else
      {
        alert('Jawaban tidak sesuai!')
      }
    }
  </script>
@endpush