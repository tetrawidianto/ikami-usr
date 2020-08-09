<?php

namespace IkamiUsr\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use IkamiAdm\Models\Area;
use IkamiAdm\Models\Asesmen;
use IkamiAdm\Models\Aspek;
use IkamiAdm\Models\Badge;
use IkamiAdm\Models\DokumenDa;
use IkamiAdm\Models\Informasi;
use IkamiAdm\Models\Status;

class RikAsesmen extends Component
{
	use WithFileUploads;

	public $asesmen;
	public $navLink = 1;
	public $jawabanId;
	public $catatanId;
	public $cekLapanganId = false;
	public $message = [
			'required' => ':attribute harus dipilih.',
		];
	public $attribute = [
			'jawabanId' => 'Jawaban',
			
		];
	public $isRecheck = false;
	public $jawaban = [];
	public $catatan = [];
	public $cekLapangan = [];
	public $search;
	public $dokumen;
	public $kodeAkses;
	public $beritaAcara;
	public $isCekLapangan = false;

	public function mount($asesmen)
	{
		$this->asesmen = $asesmen;
	}

	public function render()
	{
		$searchTerm = '%'.$this->search.'%';

		if($this->navLink > 6)
		{
			$navTarget = Aspek::with(['pertanyaan' => function($query) use ($searchTerm) {
				$query->where('teks', 'like', $searchTerm);
			}, 'pertanyaan.kesiapan', 'pertanyaan.kematangan', 'pertanyaan.pilihan.jawaban', 'informasi' => function($query) {
				$query->where('asesmen_id', $this->asesmen->id);
			}])->find($this->navLink - 6);
		}
		else
		{
			$navTarget = Area::with(['pertanyaan' => function($query) use ($searchTerm) {
				$query->where('teks', 'like', $searchTerm);
			}, 'pertanyaan.kesiapan', 'pertanyaan.kematangan', 'pertanyaan.pilihan.jawaban', 'informasi' => function($query) {
				$query->where('asesmen_id', $this->asesmen->id);
			}])->find($this->navLink);
		}

		$uAsesmen = Asesmen::with('kategoriSistemEl', 'areaUtama.kematanganBaru', 'areaUtama.area', 'aspekSuplemen.aspek', 'opini', 'dokumenDa')
			->find($this->asesmen->id);

		if($uAsesmen->terjawabSemua())
		{
			$statistik = $uAsesmen->areaUtama->pluck('skor')->toArray();
			$this->emit('updateRadarChart', json_encode($statistik));
		}
		else{
			$statistik = [];
		}

		return view('ikami-usr::livewire.rik-asesmen', [
			'daftarArea' => $this->asesmen->versi->area()->with(['aspek' => function($query) {
				$query->withCount(['pertanyaan', 'informasi' => function($query) {
					$query->where('asesmen_id', $this->asesmen->id)
						->where('jawaban_2', '!=', null);
				}]);
			}])->withCount(['pertanyaan', 'informasi' => function($query) {
				$query->where('asesmen_id', $this->asesmen->id)
					->where('jawaban_2', '!=', null);
			}])->get(),
			'navTarget' => $navTarget,
			'uAsesmen' => $uAsesmen,
			'statistik' => json_encode($statistik),
			'daftarKonfirmasi' => $uAsesmen->getPertanyaan()->with('pilihan.jawaban')->whereHas('informasi', function($query) { $query->where('confirm', true); })->get()
		]);
	}

	public function loadArea($navLink)
	{
		$this->navLink = $navLink;
		$this->isRecheck = false;
		$this->reset('search', 'isCekLapangan');
	}

	public function loadAspek($navLink)
	{
		$this->navLink = $navLink + 6;
		$this->isRecheck = false;
		$this->reset('search', 'isCekLapangan');
	}

	public function periksaKembali()
	{
		$this->isRecheck = true;
	}

	public function tutupPeriksaKembali()
	{
		$this->isRecheck = false;
		$this->reset('search');
	}

	public function jawabPertanyaan($informasiId)
	{
		$this->validate([
			'jawabanId' => 'required'
		], $this->message, $this->attribute);

		$informasi = Informasi::find($informasiId);

		$informasi->update([
			'jawaban_2' => $this->jawabanId,
			'catatan' => $this->catatanId,
			'confirm' => $this->cekLapanganId
		]);

        $this->reset('jawabanId', 'catatanId', 'cekLapanganId');
	}

	public function updateJawaban($informasiId, $pertanyaanId)
	{
		$informasi = Informasi::find($informasiId);

		if(array_key_exists($pertanyaanId, $this->jawaban))
		{
			$informasi->jawaban_2 = $this->jawaban[$pertanyaanId];
		}

		if(array_key_exists($pertanyaanId, $this->catatan))
		{
			$informasi->catatan = $this->catatan[$pertanyaanId];
		}

		if(array_key_exists($pertanyaanId, $this->cekLapangan))
		{
			$informasi->confirm = $this->cekLapangan[$pertanyaanId];
		}

		$informasi->save();

		// $this->reset('jawaban', 'catatan', 'cekLapangan');
	}

	public function tutupAsesmen()
	{
		$asesmen = Asesmen::find($this->asesmen->id);

		$asesmen->update([
			'selesai' => true,
		]);

		$asesmen->setStatus(Status::SELESAI, Badge::SELESAI);

	}


	public function uploadBeritaAcara()
	{
		$this->validate([
			'beritaAcara' => 'required|file|max:2048'
		]);

		$asesmen = Asesmen::find($this->asesmen->id);

		$berita_acara = $this->beritaAcara->store('berita_acara');

		$asesmen->update([
			'berita_acara' => $berita_acara
		]);

		$this->reset('beritaAcara');
	}

	public function hapusBeritaAcara()
	{
		$asesmen = Asesmen::find($this->asesmen->id);

		Storage::delete($asesmen->berita_acara);

		$asesmen->update(['berita_acara' => null]);
	}

	public function tambahDokumen()
	{
		$this->validate([
			'dokumen' => 'required'
		]);

		$this->asesmen->dokumenDa()->create([
			'judul_dokumen' => $this->dokumen
		]);

		$this->reset('dokumen');
	}

	public function hapusDokumen($dokumenId)
	{
		DokumenDa::find($dokumenId)->delete();
	}

	public function mintaKodeAkses()
	{
		$asesmen = Asesmen::find($this->asesmen->id);
		$asesmen->update(['kode_akses' => hexdec(bin2hex(random_bytes(2)))]);
	}

	public function mintaUlangKodeAkses()
	{
		$this->mintaKodeAkses();
	}

	public function kirimKodeAkses()
	{
		$asesmen = Asesmen::find($this->asesmen->id);

		$this->validate([
			'kodeAkses' => 'required|in:'.$asesmen->kode_akses
		]);

		$asesmen->update(['terkunci' => false]);

		$asesmen->setStatus(Status::BERLANGSUNG, Badge::BERLANGSUNG);

		$this->emitTo('menu-label', 'statusUpdated');

		$this->reset('kodeAkses');
	}

	public function loadCekLapangan()
	{
		$this->isCekLapangan = true;
		$this->isRecheck = true;
	}

	public function confirmJawaban($informasiId)
	{
		$this->validate([
			'jawabanId' => 'required'
		], $this->message, $this->attribute);

		$informasi = Informasi::find($informasiId);

		$informasi->jawaban_2 = $this->jawabanId;

		if($this->catatanId)
		{
			$informasi->catatan = $this->catatanId;
		}

		$informasi->confirmed = true;

		$informasi->save();

        $this->reset('jawabanId', 'catatanId');
	}
}