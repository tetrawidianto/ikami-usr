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
		
		<div wire:loading.remove wire:target="loadAspek,loadArea,periksaKembali,tutupPeriksaKembali,loadCekLapangan">
		
		@if(!$isRecheck)

		  @if($isCekLapangan)
			@if($daftarKonfirmasi->count() == $daftarKonfirmasi->where('informasi.confirmed', true)->count())
  				@include('ikami-usr::livewire.lak-oa-1')
			@else
				@include('ikami-usr::livewire.lak-oa-2')
			@endif
		  @else
			@include('ikami-usr::livewire.lak-sa-1')
		  @endif

		@else
		  @if($isCekLapangan)
			@include('ikami-usr::livewire.lak-oa-2')
		  @else
			@include('ikami-usr::livewire.lak-sa-2')
		  @endif
		@endif
        </div>

        @include('ikami-usr::livewire.statistik')

		@include('ikami-usr::livewire.lak-dok')
		
	</div>

	<div class="col-md-3">
		
		@include('ikami-usr::livewire.kategorisasi')

	</div>
</div>
