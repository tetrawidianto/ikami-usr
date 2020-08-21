@section('content_header')
	<h3>Asesmen</h3>
@endsection

<div>
	<div class="row">
		<div class="col-md-8">
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
	                      <th>Tgl Pembuatan</th>
	                      
	                      <th>Versi</th>
	                      <th>Status</th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                    @foreach($daftarAsesmen as $asesmen)
	                    <tr style="transform: rotate(0);">
	                    	<td><a href="{{ url('/asesmen/'.$asesmen->id) }}" class="stretched-link"></a>{{ $asesmen->sistemEl->nama }}</td>
	                    	<td><small>{{ $asesmen->created_at->toDayDateTimeString() }}</small></td>
	                    	<td>{{ $asesmen->versi->kode }}</td>
	                    	<td>
	                    		<span class="badge badge-{{ $asesmen->latestStatus([IkamiAdm\Models\Status::SA, IkamiAdm\Models\Status::DA])->badge }}">{{ $asesmen->latestStatus([IkamiAdm\Models\Status::SA, IkamiAdm\Models\Status::DA])->name }}</span>
								
								@if($asesmen->latestStatus([IkamiAdm\Models\Status::SA, IkamiAdm\Models\Status::DA])->name == IkamiAdm\Models\Status::SA && $asesmen->terjawabSemua())

									<span class="badge badge-success">selesai</span>

								@endif

								@if($asesmen->latestStatus([IkamiAdm\Models\Status::SA, IkamiAdm\Models\Status::DA])->name == IkamiAdm\Models\Status::DA)
								<span class="badge badge-{{ $asesmen->jadwal && $asesmen->jadwal->lte(Carbon\Carbon::now()) && $asesmen->terkunci ? 'danger' : $asesmen->status()->badge }}">{{ $asesmen->status }}</span>
								@endif
	                    	</td>
	                    </tr>
	                    @endforeach
	                    @if($daftarAsesmen->isEmpty())
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
			{{ $daftarAsesmen->links() }}
		</div>

		<div class="col-md-4">
			@if(session()->has('message'))
				<div class="alert alert-success alert-dismissible">
			      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			      <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
			      <small>Data telah tersimpan.</small>
			    </div>
		    @endif

		    @if($uAsesmen)
			    <div class="alert alert-info alert-dismissible">
			      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			      <h5><i class="icon fas fa-info"></i> Masih berlangsung!</h5>
			      <small>Anda tidak dapat membuat asesmen baru apabila masih ada asesmen yang belum selesai.</small>
			    </div>
			@else
				<div class="card">
					<div class="card-header">
						<div class="card-title">
							Tambah Asesmen
						</div>
					</div>
					<div class="card-body p-3">
						<form wire:submit.prevent="tambahAsesmen">
							<div class="form-group">
								<label class="contol-label">Sistem Elektronik:</label>
								<select wire:model="sistemElId" class="form-control @error('sistemElId') is-invalid @enderror">
									<option ></option>
									@foreach($daftarSistemEl as $sistemEl)
										<option value="{{ $sistemEl->id }}">{{ $sistemEl->nama }}</option>
									@endforeach
								</select>
								@error('sistemElId') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
							</div>
							<div class="form-group">
								<label class="contol-label">Versi Indeks KAMI:</label>
								<select wire:model="versiId" class="form-control @error('versiId') is-invalid @enderror">
									<option ></option>
									@foreach($daftarVersi as $versi)
										<option value="{{ $versi->id }}">{{ $versi->kode }}</option>
									@endforeach
								</select>
								@error('versiId') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
							</div>
							<button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
						</form>
					</div>
				</div>
		    @endif

		</div>
	</div>
</div>