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

@include('ikami-usr::livewire.lak-flyer-2')

@endif