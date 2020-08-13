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
  
  @if($uAsesmen->dokumenDa->count() > 0)
  <div class="card-body p-1">
    @if($uAsesmen->latestStatus(['self-assessment', 'desktop-assessment'])->name == 'desktop-assessment')
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
  @endif
  @if($uAsesmen->dokumenDa->count() < env('MAX_DOC_DA') && $uAsesmen->latestStatus(['self-assessment', 'desktop-assessment'])->name == 'self-assessment')
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