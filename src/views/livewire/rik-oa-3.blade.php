<h4>Onsite Assessment</h4>
<div class="form-group">
  <div class="input-group input-group-sm">
    <input wire:model="search" type="text" class="form-control" placeholder="Cari...">
    <span class="input-group-append">
      <button wire:click="tutupPeriksaKembali" type="button" class="btn btn-danger btn-flat">x</button>
    </span>
  </div>
</div>

@foreach($daftarKonfirmasi as $index => $konfirmasi)
<div class="card card-{{ $konfirmasi->informasi->confirmed ? 'success' : 'warning' }}">
  <div class="card-header">
    <div class="card-title">
      {{ $konfirmasi->teks }}
      <div>
        <small><span class="badge bg-secondary">{{ $konfirmasi->area->nama }}</span></small>
      </div>
      @if($konfirmasi->aspek)
      <div>
        <small><span class="badge bg-light">{{ $konfirmasi->aspek->nama }}</span></small>
      </div>
      @endif
    </div>
  </div>
  <div class="card-body">
    <form wire:submit.prevent="updateConfirmJawaban('{{ $konfirmasi->informasi->id }}', '{{ $konfirmasi->id }}')">
    <div class="form-group">
      @foreach($konfirmasi->pilihan->jawaban as $jawaban)
      <div class="custom-control custom-radio">
        <input wire:model="jawaban.{{ $konfirmasi->id }}"
        class="custom-control-input"
        type="radio"
        id="customRadio{{ $konfirmasi->id }}-{{ $jawaban->id }}"
        name="customRadio{{ $konfirmasi->id }}"
        value="{{ $jawaban->id }}"
        @if($jawaban->id == $konfirmasi->informasi->jawaban_2)
        checked
        @endif
        {{-- disabled --}}
        >
        <label for="customRadio{{ $konfirmasi->id }}-{{ $jawaban->id }}" class="custom-control-label">
          @if($jawaban->id == $konfirmasi->informasi->jawaban_1)
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
      <input wire:model="catatan.{{ $konfirmasi->id }}" type="text" class="form-control w-auto" placeholder="Catatan:">
    </div>
    <button wire:loading.attr="disabled" wire:target="updateConfirmJawaban" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
  </div>
</div>
@endforeach