<?php

namespace IkamiUsr\Livewire;

use Livewire\Component;
use IkamiAdm\Models\Area;
use IkamiAdm\Models\Asesmen;
use IkamiAdm\Models\Aspek;
use IkamiAdm\Models\Badge;
use IkamiAdm\Models\DokumenDa;
use IkamiAdm\Models\Informasi;
use IkamiAdm\Models\Status;

class LakAsesmen extends Component
{
	public $asesmen;
	public $navLink = 1;
	public $jawabanId;
	public $message = [
			'required' => ':attribute harus dipilih.',
		];
	public $attribute = [
			'jawabanId' => 'Jawaban',
			
		];
	public $isRecheck = false;
	public $jawaban = [];
	public $search;
	public $dokumen;
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

		$uAsesmen = Asesmen::with('kategoriSistemEl', 'areaUtama.kematanganBaru', 'areaUtama.area', 'aspekSuplemen.aspek', 'opini', 'dokumenDa')->find($this->asesmen->id);

		if($uAsesmen->terjawabSemua())
		{
			$statistik = $uAsesmen->areaUtama->pluck('skor')->toArray();
			$this->emit('updateRadarChart', json_encode($statistik));
		}
		else{
			$statistik = [];
		}

		return view('ikami-usr::livewire.lak-asesmen', [
			'daftarArea' => $this->asesmen->versi->area()->with(['aspek' => function($query) {
				$query->withCount(['pertanyaan', 'informasi' => function($query) {
					$query->where('asesmen_id', $this->asesmen->id);
				}]);
			}])->withCount(['pertanyaan', 'informasi' => function($query) {
				$query->where('asesmen_id', $this->asesmen->id);
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

	public function jawabPertanyaan($pertanyaanId, $targetId, $relTargetId)
	{
		$this->validate([
			'jawabanId' => 'required'
		], $this->message, $this->attribute);

		if($relTargetId)
		{
			$areaId = $relTargetId;
			$aspekId = $targetId;
		}
		else
		{
			$areaId = $targetId;
			$aspekId = NULL;
		}

		$this->asesmen->informasi()->create([
            'area_id' => $areaId,
            'aspek_id' => $aspekId,
            'pertanyaan_id' => $pertanyaanId,
            'jawaban_1' => $this->jawabanId
        ]);

        $this->reset('jawabanId');
	}

	public function updateJawaban($informasiId, $pertanyaanId)
	{
		$this->validate([
			'jawaban.'.$pertanyaanId => 'required'
		], $this->message, $this->attribute);

		$informasi = Informasi::find($informasiId)->update([
			'jawaban_1' => $this->jawaban[$pertanyaanId]
		]);

		$this->reset('jawaban');
	}

	public function upgradeAsesmen()
	{
		$asesmen = Asesmen::find($this->asesmen->id);
		$asesmen->update(['desktop_assessment' => true]);
		$asesmen->setStatus(Status::DA, Badge::DA);
		$asesmen->setStatus(Status::MASUK, Badge::MASUK);
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

	public function loadCekLapangan()
	{
		$this->isCekLapangan = true;
		$this->isRecheck = true;
	}
}