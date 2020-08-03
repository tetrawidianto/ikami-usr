<?php

namespace IkamiUsr\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use IkamiAdm\Models\KategoriSistemEl;
use IkamiAdm\Models\Opini;
use IkamiAdm\Models\Sektor;
use IkamiAdm\Models\SistemEl;

class MonitoringSistemEl extends Component
{
	use WithPagination;

	public $search;
	public $sektor = '';
	public $kategori = '';
	public $opini = '';

	public function render()
	{
		$searchTerm = '%'.$this->search.'%';

		$listKategori = KategoriSistemEl::get(['id', 'nama']);
		$listSektor = Sektor::get(['id', 'nama']);
		$listOpini = Opini::get(['id', 'nama']);

		$listSistemEl = SistemEl::with('penyedia', 'sektor', 'asesmen', 'latestDa.opini', 'latestDa.kategoriSistemEl')
			->where(function($query) {
				if($this->sektor != '')
				{
					$query->whereHas('sektor', function($query) {
						$query->where('id', $this->sektor);
					});
				}
				if($this->kategori != '')
				{
					$query->whereHas('latestDa', function($query) {
						$query->where('kategori_sistem_el_id', $this->kategori);
					});
				}
				if($this->opini != '')
				{
					$query->whereHas('latestDa', function($query) {
						$query->where('opini_id', $this->opini);
					});
				}
			})
			->where(function($query) use ($searchTerm) {
				$query->whereHas('penyedia', function($query) use ($searchTerm) {
					$query->where('nama', 'like', $searchTerm);
				})
				->orWhere('nama', 'like', $searchTerm);
			})
			->currentStatus('diterima')
			->latest()
			->paginate(10);

		return view('ikami-usr::livewire.monitoring-sistem-el', [
			'listSistemEl' => $listSistemEl,
			'listSektor' => $listSektor,
			'listKategori' => $listKategori,
			'listOpini' => $listOpini
		]);
	}
}
