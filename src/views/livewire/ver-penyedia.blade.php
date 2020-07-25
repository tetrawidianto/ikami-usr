<div>
  <form class="form-inline">
      <div class="custom-control custom-checkbox mx-1">
        <input wire:click="filterStatus('diterima')" class="custom-control-input" type="checkbox" id="customCheckbox1" checked>
        <label for="customCheckbox1" class="custom-control-label text-success">diterima</label>
      </div>

      <div class="custom-control custom-checkbox mx-1">
        <input wire:click="filterStatus('menunggu')" class="custom-control-input" type="checkbox" id="customCheckbox2" checked>
        <label for="customCheckbox2" class="custom-control-label text-warning">menunggu</label>
      </div>
      
      <div class="custom-control custom-checkbox mx-1">
        <input wire:click="filterStatus('ditolak')" class="custom-control-input" type="checkbox" id="customCheckbox3" checked>
        <label for="customCheckbox3" class="custom-control-label text-danger">ditolak</label>
      </div>
  </form>

	<div class="card card-primary card-outline">
		<div class="card-header">
			<div class="card-title">
				{{ $title }}
				<button wire:click="$refresh" wire:loading.remove wire:target="$refresh,openSidebar" class="btn btn-sm"><i class="fas fa-sync-alt"></i></button>
				<div wire:loading wire:target="$refresh,openSidebar" class="spinner-border spinner-border-sm text-primary" role="status">
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
            <th></th>
            <th>ID</th>
            <th>Nama</th>
            <th>Nama Alias</th>
            <th>Alamat</th>
            <th>Website</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($listModel as $penyedia)
          <tr @if($penyedia->id == $itemId) class="table-active" @endif>
            <td style="transform: rotate(0);"><a wire:click="openSidebar('{{ $penyedia->id }}')" href="javascript:void(0)" class="stretched-link" @if(!$isOpen || $penyedia->id == $itemId) data-widget="control-sidebar" @endif>
              @if($penyedia->id == $itemId)
              <i class="far fa-circle"></i>
              @else
              <i class="fas fa-cogs"></i>
              @endif
            </a></td>
            <td>{{ $penyedia->id }}</td>
            <td>{{ $penyedia->nama }}</td>
            <td>{{ $penyedia->nama_panjang }}</td>
            <td><small><i>{{ $penyedia->alamat }}</i></small></td>
            <td><a href="{{ url($penyedia->website) }}" target="_blank">{{ $penyedia->website }}</a></td>
            <td><span class="badge badge-{{ $penyedia->status()->badge }}">{{ $penyedia->status }}</span></td>
          </tr>
          @endforeach
          
          @if($listModel->isEmpty())
      		<tr>
      			<td colspan="7" class="text-center">
            			<span class="far fa-smile"></span> Tidak ada
            		</td>
      		</tr>
          @endif
        </tbody>
      </table>
		</div>
	</div>
	{{ $listModel->links() }}
</div>

@section('right-sidebar')
	@livewire('ver-sidebar')
@endsection