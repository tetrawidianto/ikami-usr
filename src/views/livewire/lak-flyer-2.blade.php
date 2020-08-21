@if($uAsesmen->terjawabSemua())
	<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-check"></i> Self Assessment</h5>
    <small>Anda telah menyelesaikan Self Assessment <b>Indeks KAMI</b>. <a wire:click="periksaKembali" href="javascript:void(0)">Periksa kembali</a> area: <b>{{ $navTarget->nama }}</b>.</small>
  </div>
@else
	<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-info"></i> Periksa Area Lain!</h5>
    <small>Area: <b>{{ $navTarget->nama }}</b> telah selesai dijawab. <a wire:click="periksaKembali" href="javascript:void(0)">Periksa kembali</a></small>
  </div>
@endif