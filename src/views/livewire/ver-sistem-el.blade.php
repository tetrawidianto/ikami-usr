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
            <th>Deskripsi</th>
            <th>Instansi/Perusahan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($listModel as $sistemEl)
          <tr @if($sistemEl->id == $itemId) class="table-active" @endif>
            <td style="transform: rotate(0);"><a wire:click="openSidebar('{{ $sistemEl->id }}')" href="javascript:void(0)" class="stretched-link" @if(!$isOpen || $sistemEl->id == $itemId) data-widget="control-sidebar" @endif>
              @if($sistemEl->id == $itemId)
              <i class="far fa-circle"></i>
              @else
              <i class="fas fa-cogs"></i>
              @endif
            </a></td>
            <td>{{ $sistemEl->id }}</td>
            <td>{{ $sistemEl->nama }}</td>
            <td><small>{{ $sistemEl->deskripsi }}</small></td>
            <td>{{ $sistemEl->penyedia->nama }}</td>
            
            <td><span class="badge badge-{{ $sistemEl->status()->badge }}">{{ $sistemEl->status }}</span></td>
          </tr>
          @endforeach
          
          @if($listModel->isEmpty())
      		<tr>
      			<td colspan="6" class="text-center">
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