@if($uAsesmen->terevaluasiSemua())
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-check"></i> Desktop Assessment</h5>
    <small>Anda telah menyelesaikan Desktop Assessment <b>Indeks KAMI</b>. <a wire:click="periksaKembali" href="javascript:void(0)">Periksa kembali</a> area: <b>{{ $navTarget->nama }}</b>.</small>
  </div>
@else
  <div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-info"></i> Periksa Area Lain!</h5>
    <small>Area: <b>{{ $navTarget->nama }}</b> telah selesai diperiksa. Anda dapat menuju area lain yang belum diperiksa. <a wire:click="periksaKembali" href="javascript:void(0)">Periksa kembali</a></small>
  </div>
@endif