@if($uAsesmen->selesai)
<div class="card card-primary">
	<div class="card-header">
		<div class="card-title">
			Dokumen Terkait
		</div>
	</div>
	
	<div class="card-body">
		<ul class="list-group">
		  <li class="list-group-item d-flex justify-content-between align-items-center">
			<a href="javascript:void(0)" onclick="window.open('{{ route('ba-pengguna', $uAsesmen->id)  }}', 'ikami-preview', 'height=800,width=600')">Berita Acara</a>
		  </li>
	  	</ul>
	</div>
</div>
@endif