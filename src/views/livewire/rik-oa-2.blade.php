@php
$oaIndex = $daftarKonfirmasi->where('informasi.confirmed', true)->count();
@endphp

<h4>
	Onsite Assessment #{{ $oaIndex + 1 }} 
</h4>

<div class="card card-info">
	<div class="card-header">
		<div class="card-title">
			{{ $daftarKonfirmasi[$oaIndex]->teks }}
		</div>
	</div>
	<div class="card-body ">
	  <form wire:submit.prevent="confirmJawaban('{{ $daftarKonfirmasi[$oaIndex]->informasi->id }}')">
    	  <div class="form-group">
            @foreach($daftarKonfirmasi[$oaIndex]->pilihan->jawaban as $jawaban)
            <div class="custom-control custom-radio">
              <input 
              wire:model="jawabanId" 
              class="custom-control-input" 
              type="radio" 
              id="customRadio{{ $jawaban->id }}" 
              name="customRadio" 
              value="{{ $jawaban->id }}">
              <label for="customRadio{{ $jawaban->id }}" class="custom-control-label">
              	@if($jawaban->id == $daftarKonfirmasi[$oaIndex]->informasi->jawaban_2)
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
          	<span class="help-block">Catatan: <i>{{ $daftarKonfirmasi[$oaIndex]->informasi->catatan }}</i></span>
          	<input wire:model="catatanId" type="text" class="form-control w-auto" placeholder="Catatan:">
          </div>
          <button wire:loading.attr="disabled" wire:target="confirmJawaban" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
      </form>
	</div>
</div>