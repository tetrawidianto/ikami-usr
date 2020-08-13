<div class="card" @if($isRecheck || !$uAsesmen->terevaluasiSemua() || ( !$daftarKonfirmasi->isEmpty() && $daftarKonfirmasi->where('informasi.confirmed', true)->count() < $daftarKonfirmasi->count() )) style="display: none;" @endif>
	<div class="card-header">
		<div class="card-title">
			Statistik
		</div>
	</div>
	<div wire:ignore wire:key="first" class="card-body">
		<canvas id="radarChart"></canvas>
	</div>
</div>

@if(!$isRecheck && $uAsesmen->terevaluasiSemua() && ( (!$daftarKonfirmasi->isEmpty() && $daftarKonfirmasi->where('informasi.confirmed', true)->count() == $daftarKonfirmasi->count()) || $daftarKonfirmasi->isEmpty() ))
<div class="row">
	<div class="col">
		<div class="info-box mb-3 bg-info">
          <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Skor Akhir</span> 
            <span class="info-box-number">{{ $uAsesmen->skor_utama }}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
	</div>
	<div class="col">
		<div class="info-box mb-3 bg-{{ $uAsesmen->opini->color }}">
          <span class="info-box-icon"><i class="fas fa-trophy"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Hasil Akhir</span> 
            <span class="info-box-number">{{ $uAsesmen->opini->nama }}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
	</div>
</div>
@endif

@push('js')
	<script src="{{ asset('vendor/chart.js/Chart.js') }}"></script>
	<script>
		var statistik = JSON.parse('{{ $statistik }}')

		var data = {
            labels: ['Tata Kelola', 'Pengelolaan Risiko', 'Kerangka Kerja', 'Pengelolaan Aset', 'Teknologi'],
            datasets: [
                {
                    label: "Asesmen",
                    backgroundColor: "rgba(0, 0, 0, 0)",
                    borderColor: "rgba(255,133,27, 0.8)",
                    data: statistik
                },
                {
                    label: "Kerangka Kerja Dasar",
                    backgroundColor: "rgba(11,156,49,0.6)",
                    data: [24, 30, 36, 72, 42]
                },
                {
                    label: "Penerapan Operasional",
                    backgroundColor: "rgba(11,156,49,0.4)",
                    data: [72, 54, 96, 132, 102]
                },
                {
                    label: "Kepatuhan ISO 27001",
                    backgroundColor: "rgba(11,156,49,0.2)",
                    data: [126, 72, 159, 168, 120]
                },
            ]
        }

        var options = {
            scale: {
                ticks: {
                    display: false
                }
            },
            legend: {
              position: 'bottom'
            }
        }

        var ctx = document.getElementById('radarChart').getContext('2d');

        var chart = new Chart(ctx, {
		    type: 'radar',
		    data: data,
		    options: options
		})

		window.livewire.on('updateRadarChart', (statistik) => {
		    chart.data.datasets[0].data = JSON.parse(statistik)
		    chart.update()
		});

	</script>
@endpush
