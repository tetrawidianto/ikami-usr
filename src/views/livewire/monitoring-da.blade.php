<div>
	<form class="form-inline">
      <div class="form-group m-1">
        <label class="control-label">Versi:</label>
        <select wire:model="versi" class="form-control">
          <option value="">Semua</option>
          @foreach($listVersi as $versi)
			<option value="{{ $versi->id }}">{{ $versi->kode }}</option>
          @endforeach
        </select>
      </div>

      <div class="custom-control custom-checkbox mx-1">
        <input wire:model="masuk" class="custom-control-input" type="checkbox" id="customCheckbox1" checked>
        <label for="customCheckbox1" class="custom-control-label text-danger">masuk</label>
      </div>

      <div class="custom-control custom-checkbox mx-1">
        <input wire:model="terjadwal" class="custom-control-input" type="checkbox" id="customCheckbox2" checked>
        <label for="customCheckbox2" class="custom-control-label text-warning">terjadwal</label>
      </div>

      <div class="custom-control custom-checkbox mx-1">
        <input wire:model="berlangsung" class="custom-control-input" type="checkbox" id="customCheckbox3" checked>
        <label for="customCheckbox3" class="custom-control-label text-info">berlangsung</label>
      </div>
      
      <div class="custom-control custom-checkbox mx-1">
        <input wire:model="selesai" class="custom-control-input" type="checkbox" id="customCheckbox4" checked>
        <label for="customCheckbox4" class="custom-control-label text-success">selesai</label>
      </div>
  </form>

	<div class="card">
		<div class="card-header">
			<div class="card-title">
				Daftar Asesmen
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
		            <th>Nama Sistem El</th>
		            <th>Versi</th>
		            <th>Status</th>
		          </tr>
		        </thead>
		        <tbody>
		        	@foreach($listAsesmen as $asesmen)
		        	<tr>
		        		<td style="transform: rotate(0);"><a wire:click="openSidebar('{{ $asesmen->id }}')" href="javascript:void(0)" class="stretched-link" @if(!$isOpen || $asesmen->id == $itemId) data-widget="control-sidebar" @endif>
			              @if($asesmen->id == $itemId)
			              <i class="far fa-circle"></i>
			              @else
			              <i class="fas fa-cogs"></i>
			              @endif
			            </a></td>
		        		<td>{{ $asesmen->id }}</td>
		        		<td>{{ $asesmen->sistemEl->nama }}</td>
		        		<td>{{ $asesmen->versi->kode }}</td>
		        		<td><span class="badge badge-{{ $asesmen->jadwal && $asesmen->jadwal->lte(Carbon\Carbon::now()) && $asesmen->terkunci ? 'danger' : $asesmen->status()->badge }}">{{ $asesmen->status }}</span>
		  					
		        		</td>
		        	</tr>
		        	@endforeach
		        	@if($listAsesmen->isEmpty())
		      		<tr>
		      			<td colspan="5" class="text-center">
		            			<span class="far fa-smile"></span> Tidak ada
		            		</td>
		      		</tr>
		          	@endif
		        </tbody>
		    </table>
		</div>
	</div>
</div>

@section('right-sidebar')
	@livewire('monitoring-da-sidebar')
@endsection