<div>
	<form class="form-inline">
      <div class="custom-control custom-checkbox mx-1">
        <input wire:model="sudah" class="custom-control-input" type="checkbox" id="customCheckbox1" checked>
        <label for="customCheckbox1" class="custom-control-label text-success">sudah</label>
      </div>

      <div class="custom-control custom-checkbox mx-1">
        <input wire:model="belum" class="custom-control-input" type="checkbox" id="customCheckbox2" checked>
        <label for="customCheckbox2" class="custom-control-label text-danger">belum</label>
      </div>
  </form>

	<div class="card">
		<div class="card-header">
			<div class="card-title">
				Daftar Sistem Elektronik
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
		            <th>Penyedia</th>
		            <th>Status VA</th>
		          </tr>
		        </thead>
		        <tbody>
		        	@foreach($listSistemEl as $sistemEl)
		        	<tr>
		        		<td style="transform: rotate(0);"><a wire:click="openSidebar('{{ $sistemEl->id }}')" href="javascript:void(0)" class="stretched-link" @if(!$isOpen || $sistemEl->id == $itemId) data-widget="control-sidebar" @endif>
			              @if($sistemEl->id == $itemId)
			              <i class="far fa-circle"></i>
			              @else
			              <i class="fas fa-cogs"></i>
			              @endif
			            </a></td>
		        		<td>{{ $sistemEl->id }}</td>
		        		<td>{{ $sistemEl->nama }}</td>
		        		<td>{{ $sistemEl->penyedia->nama }}</td>
		        		<td>
		        			@if($sistemEl->va)
								<span class="fas fa-check-circle text-success"></span>
		        			@else
								<span class="fas fa-times-circle text-danger"></span>
		        			@endif
		        		</td>
		        	</tr>
		        	@endforeach
		        	@if($listSistemEl->isEmpty())
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
	@livewire('monitoring-va-sidebar')
@endsection