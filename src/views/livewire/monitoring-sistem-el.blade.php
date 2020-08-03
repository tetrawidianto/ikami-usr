<div>
  <form class="form-inline m-1">
      <div class="form-group m-1">
        <label class="control-label">Sektor:</label>
        <select wire:model="sektor" class="form-control">
          <option value="">Semua</option>
          @foreach($listSektor as $sektor)
            <option value="{{ $sektor->id }}">{{ $sektor->nama }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group m-1">
        <label class="control-label">Kategori:</label>
        <select wire:model="kategori" class="form-control">
          <option value="">Semua</option>
          @foreach($listKategori as $kategori)
            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group m-1">
        <label class="control-label">Predikat:</label>
        <select wire:model="opini" class="form-control">
          <option value="">Semua</option>
          @foreach($listOpini as $opini)
            <option value="{{ $opini->id }}">{{ $opini->nama }}</option>
          @endforeach
        </select>
      </div>
  </form>

	<div class="card card-primary card-outline">
		<div class="card-header">
			<div class="card-title">
				Daftar Sistem Elektronik
				<button wire:click="$refresh" wire:loading.remove wire:target="$refresh" class="btn btn-sm"><i class="fas fa-sync-alt"></i></button>
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
            <th>Penyedia</th>
            <th>Sektor</th>
            <th><i>SA</i></th>
            <th><i>DA</i></th>
            <th>Kategori</th>
            <th>Predikat</th>

          </tr>
        </thead>
        <tbody>
          @foreach($listSistemEl as $sistemEl)
          <tr >
            
            <td>{{ $sistemEl->nama }}</td>
            <td>{{ $sistemEl->penyedia->nama }}</td>
            <td>{{ $sistemEl->sektor->nama }}</td>
            <td>{{ $sistemEl->asesmen->count() }}</td>
            <td>{{ $sistemEl->asesmen->where('desktop_assessment', true)->count() }}</td>
            <td><span class="text-{{ $sistemEl->latestDa ? $sistemEl->latestDa->kategoriSistemEl->color : 'default' }}">{{ $sistemEl->latestDa ? $sistemEl->latestDa->kategoriSistemEl->nama : '' }}</span></td>
            <td><span class="text-{{ $sistemEl->latestDa ? $sistemEl->latestDa->opini->color : 'default' }}">{{ $sistemEl->latestDa ? $sistemEl->latestDa->opini->nama : '' }}</span></td>

          </tr>
          @endforeach
          
          @if($listSistemEl->isEmpty())
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
	{{ $listSistemEl->links() }}
</div>