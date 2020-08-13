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