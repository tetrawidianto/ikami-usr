<?php

namespace IkamiUsr\Livewire;

use App\User;
use Carbon\Carbon;
use Livewire\Component;
use IkamiAdm\Models\Asesmen;
use IkamiAdm\Models\Badge;
use IkamiAdm\Models\Status;

class PenjadwalanSidebar extends Component
{
	public $itemId;
	public $tanggal;
	public $waktu;
	public $tempat;
	public $location;
	public $asesor;
	public $isEdit = false;
	public $isTerjadwal;

	protected $listeners = ['loadData'];

	public function render()
	{
		$this->isTerjadwal = false;

		if($this->itemId)
		{
			$model = Asesmen::with('asesor')->find($this->itemId);

			if($model->latestStatus([Status::MASUK, Status::TERJADWAL])->name == Status::TERJADWAL)
			{
				$this->isTerjadwal = true;
			}
		}
		else
		{
			$model = NULL;
		}

		$listAsesor = User::role('asesor')->get(['id', 'name']);

		return view('ikami-usr::livewire.penjadwalan-sidebar', [
			'model' => $model,
			'listAsesor' => $listAsesor
		]);
	}

	public function closeSidebar()
	{
		$this->batalUbahPenjadwalan();
		$this->emitTo('penjadwalan', 'sidebarClosed');
	}

	public function loadData($itemId)
	{
		$this->itemId = $itemId;
	}

	public function tambahJadwal()
	{
		$asesmen = $this->ubahJadwal();

		$asesmen->setStatus(Status::TERJADWAL, Badge::TERJADWAL);

		$this->emitTo('penjadwalan', 'statusUpdated');
		$this->emitTo('menu-label', 'statusUpdated');
	}

	public function ubahPenjadwalan()
	{
		$asesmen = Asesmen::with('asesor')->find($this->itemId);

		$this->tanggal = $asesmen->jadwal->toDateString();
		// $this->waktu = date('h:i', strtotime($asesmen->waktu));
		$this->waktu = $asesmen->jadwal->toTimeString();
		$this->tempat = $asesmen->tempat;
		$this->location = $asesmen->location;
		$this->asesor = $asesmen->asesor->pluck('id')->toArray();

		$this->isEdit = true;

		$this->emit('selectAsesor', json_encode($this->asesor));
	}

	public function batalUbahPenjadwalan()
	{
		$this->isEdit = false;
		$this->reset('tanggal', 'waktu', 'tempat', 'asesor');
		$this->emit('clearAsesor');
	}

	public function ubahJadwal()
	{
		$this->validate([
			'tanggal' => 'required|date|after:' . Carbon::yesterday()->toDateString() . '|before_or_equal:' . Carbon::today()->addDays(env('MAX_DATE_DA'))->toDateString(),
			'waktu' => 'required',
			'tempat' => 'required',
			'location' => 'required',
			'asesor' => 'required'
		]);

		$asesmen = Asesmen::find($this->itemId);

		$asesmen->update([
			'jadwal' => $this->tanggal.'T'.$this->waktu,
			// 'waktu' => $this->waktu,
			'tempat' => $this->tempat,
			'location' => $this->location
		]);

		$asesmen->asesor()->sync($this->asesor);

		$this->reset('tanggal', 'waktu', 'tempat', 'asesor');

		$this->isEdit = false;

		$this->emit('clearAsesor');

		return $asesmen;
	}
}
