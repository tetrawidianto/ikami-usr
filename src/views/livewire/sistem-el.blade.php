@section('content_header')
	<h3>Sistem Elektronik</h3>
@endsection

<div>
	<div class="row">
		<div class="col-md-8">
			<div class="card card-primary card-outline">
				<div class="card-header">
					<div class="card-title">
						Daftar Sistem Elektronik<button wire:click="$refresh" wire:loading.remove wire:target="$refresh,bukaHubungan,tutupHubungan" class="btn btn-sm"><i class="fas fa-sync-alt"></i></button>
						<div wire:loading wire:target="$refresh,bukaHubungan,tutupHubungan" class="spinner-border spinner-border-sm text-primary" role="status">
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
	                      
	                      <th>Nama</th>
	                      <th>Tgl Pendaftaran</th>
	                      
	                      <th>Deskripsi</th>
	                      <th>Status</th>
	                      <th>Asesi</th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                    @foreach($daftarSistemEl as $sistemEl)
	                    <tr>
	                      
	                      <td>{{ $sistemEl->nama }}</td>
	                      <td>{{ $sistemEl->created_at->toDayDateTimeString() }}</td>
	                      
	                      <td><small><i>{{ $sistemEl->deskripsi }}</i></small></td>
	                      <td><span class="badge badge-{{ $sistemEl->status()->badge }}">{{ $sistemEl->status }}</span></td>
	                      <td>
	                      	@if($sistemEl->asesi->first())
	                      	<span class="badge badge-{{ $sistemEl->asesi->first()->status()->badge }}">{{ $sistemEl->asesi->first()->status }}</span>
	                      	@else
	                      		@if($sistemEl->status == IkamiAdm\Models\Status::DITERIMA)
									<a wire:click="bukaHubungan('{{ $sistemEl->id }}', '{{ $sistemEl->nama }}')" href="javascript:void(0)" class="badge badge-secondary">{{ __('tidak-terhubung') }}</a>
	                      		@endif
	                      	
	                      	@endif
	                      </td>
	                    </tr>
	                    @endforeach
	                    @if($daftarSistemEl->isEmpty())
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
			{{ $daftarSistemEl->links() }}
		</div>

		<div class="col-md-4">
			@if(session()->has('message'))
			<div class="alert alert-success alert-dismissible">
		      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		      <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
		      ...
		    </div>
			@endif

			@if($uSistemEl && $uSistemEl->status == IkamiAdm\Models\Status::MENUNGGU)
			<div class="alert alert-info alert-dismissible">
		      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		      <h5><i class="icon fas fa-info"></i> Mohon menunggu!</h5>
		      <small>Kami sedang melakukan verifikasi data sistem elektronik yang Anda kirimkan.
		      	<a wire:click="$refresh" wire:loading.remove wire:target="$refresh" href="javascript:void(0)">Periksa pembaruan</a> 
		      	<div wire:loading wire:target="$refresh" class="spinner-border spinner-border-sm text-primary" role="status">
				  <span class="sr-only">Loading...</span>
				</div>

		      </small>
		    </div>
			@endif

			@if($uSistemEl && $uSistemEl->status == IkamiAdm\Models\Status::DITOLAK)
			<div class="alert alert-warning alert-dismissible">
		      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		      <h5><i class="icon fas fa-exclamation-triangle"></i> Mohon perhatian!</h5>
		      <small>Sistem elektronik belum dapat kami terima dengan alasan: <b>{{ $uSistemEl->status()->reason }}</b>. @if(!$isKoreksiSistemEl) <a wire:click="bukaKoreksiSistemEl" href="javascript:void(0)">Koreksi</a> @endif
				<div wire:loading wire:target="bukaKoreksiSistemEl" class="spinner-border spinner-border-sm text-primary" role="status">
			  	<span class="sr-only">Loading...</span>
				</div>
		      </small> 
		    </div>
			@endif

			@if($uAsesi && $uAsesi->status == IkamiAdm\Models\Status::MENUNGGU)
			<div class="alert alert-info alert-dismissible">
		      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		      <h5><i class="icon fas fa-info"></i> Mohon menunggu!</h5>
		      <small>Kami sedang melakukan verifikasi data asesi yang Anda kirimkan.
				<a wire:click="$refresh" wire:loading.remove wire:target="$refresh" href="javascript:void(0)">Periksa pembaruan</a> 
		      	<div wire:loading wire:target="$refresh" class="spinner-border spinner-border-sm text-primary" role="status">
				  <span class="sr-only">Loading...</span>
				</div>
		      </small>
		    </div>
			@endif

			@if($uAsesi && $uAsesi->status == IkamiAdm\Models\Status::DITOLAK)
			<div class="alert alert-warning alert-dismissible">
		      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		      <h5><i class="icon fas fa-exclamation-triangle"></i> Mohon perhatian!</h5>
		      <small>Permintaan sebagai asesi belum dapat kami terima dengan alasan: <b>{{ $uAsesi->status()->reason }}</b>. @if(!$isKoreksiAsesi) <a wire:click="bukaKoreksiAsesi" href="javascript:void(0)">Koreksi</a> @endif
				<div wire:loading wire:target="bukaKoreksiAsesi" class="spinner-border spinner-border-sm text-primary" role="status">
			  	<span class="sr-only">Loading...</span>
				</div>
		      </small> 
		    </div>
			
				@if($isKoreksiAsesi)
				<div class="card">
					<div class="card-header">
						<div class="card-title">
							Koreksi Data Asesi
						</div>
					</div>
					<div class="card-body">
						<form wire:submit.prevent="koreksiAsesi">
							<div class="form-group">
								<input type="text" class="form-control" disabled value="{{ $uAsesi->sistemEl->nama }}">
							</div>
							<div class="form-group">
								<label class="control-label">Surat Tugas:</label>
								<input wire:model="suratTugas" type="file" class="form-control-file">
								@error('suratTugas') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
								<div wire:loading wire:target="suratTugas" class="spinner-border spinner-border-sm text-primary" role="status">
					        		<span class="sr-only">Loading...</span>
					      	  	</div>
							</div>
							<button wire:loading.attr="disabled" wire:target="suratTugas,koreksiAsesi" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
						</form>
					</div>
				</div>
				@endif

			@endif
	
			@if((is_null($uSistemEl) || $uSistemEl && $uSistemEl->status == IkamiAdm\Models\Status::DITERIMA) && (is_null($uAsesi) || $uAsesi && $uAsesi->status == IkamiAdm\Models\Status::DITERIMA))
				
				@if($hubunganTerbuka)
					<div class="card card-primary">
						<div class="card-header">
							<div class="card-title">
								Hubungkan dengan Sistem El
							</div>
							<div class="card-tools">
								<button wire:click="tutupHubungan" type="button" class="btn btn-tool">
			                    <i class="fas fa-times"></i>
			                  </button>
							</div>

						</div>
						<div class="card-body">
							<form wire:submit.prevent="hubungkan">
								<div class="form-group">
									<label class="control-label">Nama Sistem El:</label>
    								<div class="form-control-static">{{ $namaSistemEl }}</div>
								</div>
								<div class="form-group">
									<label class="control-label">Surat Tugas:</label>
									<input wire:model="suratTugas" type="file" class="form-control-file">
									@error('suratTugas') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
									<div wire:loading wire:target="suratTugas" class="spinner-border spinner-border-sm text-primary" role="status">
						        		<span class="sr-only">Loading...</span>
						      	  	</div>
								</div>
								<button wire:loading.attr="disabled" wire:target="suratTugas,tambahSistemEl" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
							</form>
						</div>
					</div>
				@else
				<div class="card">
					<div class="card-header">
						<div class="card-title">
							Tambah Sistem El
						</div>
					</div>
					<div class="card-body p-3">
						<form wire:submit.prevent="tambahSistemEl">
							<div class="form-group">
								<input wire:model="nama" type="text" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Sistem El">
								@error('nama') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
							</div>
							<div class="form-group">
								<textarea wire:model="deskripsi" rows="2" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Deskripsi.."></textarea>
								@error('deskripsi') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
							</div>
							<div class="form-group">
								<label class="control-label">Surat Tugas:</label>
								<input wire:model="suratTugas" type="file" class="form-control-file">
								@error('suratTugas') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
								<div wire:loading wire:target="suratTugas" class="spinner-border spinner-border-sm text-primary" role="status">
					        		<span class="sr-only">Loading...</span>
					      	  	</div>
							</div>
							<button wire:loading.attr="disabled" wire:target="suratTugas,tambahSistemEl" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
						</form>
					</div>
				</div>
				@endif
			@endif

			@if($uSistemEl && $uSistemEl->status == IkamiAdm\Models\Status::DITOLAK && $isKoreksiSistemEl)
			<div class="card">
				<div class="card-header">
					<div class="card-title">
						Koreksi Data Sistem El
					</div>
				</div>
				<div class="card-body p-3">
					<form wire:submit.prevent="koreksiSistemEl">
						<div class="form-group">
							<input wire:model="nama" type="text" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Sistem El">
							@error('nama') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
						</div>
						<div class="form-group">
							<textarea wire:model="deskripsi" rows="2" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Deskripsi.."></textarea>
							@error('deskripsi') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
						</div>
						
						<button wire:loading.attr="disabled" wire:target="koreksiSistemEl" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
					</form>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>