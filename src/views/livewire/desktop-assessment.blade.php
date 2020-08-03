@section('content_header')
	<h3>Desktop Asesmen</h3>
@endsection

<div>
	<form class="form-inline">
      <div class="custom-control custom-checkbox mx-1">
        <input wire:model="terjadwal" class="custom-control-input" type="checkbox" id="customCheckbox1" checked>
        <label for="customCheckbox1" class="custom-control-label text-warning">terjadwal</label>
      </div>

      <div class="custom-control custom-checkbox mx-1">
        <input wire:model="berlangsung" class="custom-control-input" type="checkbox" id="customCheckbox2" checked>
        <label for="customCheckbox2" class="custom-control-label text-info">berlangsung</label>
      </div>
      
      <div class="custom-control custom-checkbox mx-1">
        <input wire:model="selesai" class="custom-control-input" type="checkbox" id="customCheckbox3" checked>
        <label for="customCheckbox3" class="custom-control-label text-success">selesai</label>
      </div>
  </form>
	<div class="card card-primary card-outline">
		<div class="card-header">
			<div class="card-title">
				Daftar Asesmen<button wire:click="$refresh" wire:loading.remove wire:target="$refresh" class="btn btn-sm"><i class="fas fa-sync-alt"></i></button>
				<div wire:loading wire:target="$refresh" class="spinner-border spinner-border-sm text-primary" role="status">
				  <span class="sr-only">Loading...</span>
				</div>
			</div>
			<div class="card-tools">
              <div class="input-group input-group-sm" style="width: 150px;">
                <input wire:model="search" type="text" name="table_search" class="form-control float-right" placeholder="Cari">

                <div class="input-group-append">
                  <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </div>
		</div>
		<div class="card-body table-responsive p-0">
		  <table class="table table-hover table-striped">
              <thead class="thead-dark">
                <tr>
                  
                  <th>Nama Sistem El</th>
                  <th>Tgl Pelaksanaan</th>
                  
                  <th>Versi</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($listAsesmen as $asesmen)
                <tr style="transform: rotate(0);">
                	<td><a href="{{ url('/desktop-assessment/'.$asesmen->id) }}" class="stretched-link"></a>{{ $asesmen->sistemEl->nama }}</td>
                	<td><small>{{ $asesmen->jadwal->toDayDateTimeString() }}</small></td>
                	<td>{{ $asesmen->versi->kode }}</td>
                	<td>
                		<span class="badge badge-{{ $asesmen->jadwal->lte(Carbon\Carbon::now()) && $asesmen->terkunci ? 'danger' : $asesmen->status()->badge }}">{{ $asesmen->status }}</span>
                	</td>
                </tr>
                @endforeach

                @if($listAsesmen->isEmpty())
					<tr>
						<td colspan="4" class="text-center">
			      			<span class="far fa-smile"></span> Tidak ada
			      		</td>
					</tr>
                @endif
              </tbody>
            </table>
		</div>
	</div>
	{{ $listAsesmen->links() }}
</div>