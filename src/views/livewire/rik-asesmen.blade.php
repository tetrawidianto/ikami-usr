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
		  
		  @if($isCekLapangan)
			@if($daftarKonfirmasi->count() == $daftarKonfirmasi->where('informasi.confirmed', true)->count())
				@include('ikami-usr::livewire.rik-oa-1')
			@else
				@include('ikami-usr::livewire.rik-oa-2')
			@endif
		  @else
			@include('ikami-usr::livewire.rik-da-1')
		  @endif
		
		@else

		  @if($isCekLapangan)
			@include('ikami-usr::livewire.rik-oa-3')
		  @else
			@include('ikami-usr::livewire.rik-da-2')
		  @endif

		  
		@endif
        </div>

		@include('ikami-usr::livewire.statistik')
		
		@include('ikami-usr::livewire.rik-dok')

	</div>

	<div class="col-md-3">
		
		@include('ikami-usr::livewire.kategorisasi')

	</div>
</div>

