<?php

namespace IkamiUsr\Livewire;

// use App\User;
// use Carbon\Carbon;
use IkamiAdm\Models\SistemEl;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
// use IkamiAdm\Models\Asesmen;
// use IkamiAdm\Models\Badge;
// use IkamiAdm\Models\Status;

class MonitoringVaSidebar extends Component
{
	use WithFileUploads;

	public $itemId;
	public $avg_cvss;
	public $app_sec;
	public $tanggal;
	public $dokumen;
	public $isVa = false;
	public $isEdit = false;
	// public $waktu;
	// public $tempat;
	// public $location;
	// public $asesor;
	// public $isEdit = false;
	// public $isTerjadwal;

	protected $listeners = ['loadData'];

	public function render()
	{
		// $this->isTerjadwal = false;

		// if($this->itemId)
		// {
		// 	$model = Asesmen::with('asesor')->find($this->itemId);

		// 	if($model->latestStatus([Status::MASUK, Status::TERJADWAL])->name == Status::TERJADWAL)
		// 	{
		// 		$this->isTerjadwal = true;
		// 	}
		// }
		// else
		// {
		// 	$model = NULL;
		// }

		// $listAsesor = User::role('asesor')->get(['id', 'name']);

		return view('ikami-usr::livewire.monitoring-va-sidebar', [
			// 'model' => $model,
			// 'listAsesor' => $listAsesor
		]);
	}

	public function tambahVa()
	{
		$this->validate([
			'tanggal' => 'required|date',
			'avg_cvss' => 'required|numeric',
			'app_sec' => 'required|numeric',
			'dokumen' => 'required'
		]);

		$sistemEl = SistemEl::find($this->itemId);

		$dok_va = $this->dokumen->store('va');

		$sistemEl->va()->create([
			'average_cvss_score' => $this->avg_cvss,
			'app_security_score' => $this->app_sec,
			'tanggal' => $this->tanggal,
			'dok_va' => $dok_va
		]);

		$this->isVa = true;
	}

	public function updateVa()
	{
		$this->validate([
			'tanggal' => 'required|date',
			'avg_cvss' => 'required|numeric',
			'app_sec' => 'required|numeric',
		]);

		$sistemEl = SistemEl::with('va')->find($this->itemId);
		$va = $sistemEl->va;

		$va->update([
			'average_cvss_score' => $this->avg_cvss,
			'app_security_score' => $this->app_sec,
			'tanggal' => $this->tanggal,
		]);

		if($this->dokumen)
		{
			Storage::delete($va->dok_va);
			$dok_va = $this->dokumen->store('va');
			$va->dok_va = $dok_va;
			$va->save();
		}

		$this->batalUbahVa();
	}

	public function closeSidebar()
	{
		$this->batalUbahVa();
		$this->emitTo('monitoring-va', 'sidebarClosed');
	}

	public function ubahVa()
	{
		$this->isEdit = true;
		$this->reset('dokumen');
	}

	public function batalUbahVa()
	{
		$this->isEdit = false;
	}

	public function loadData($itemId)
	{
		$this->itemId = $itemId;
		
		$sistemEl = SistemEl::with('va')->find($this->itemId);
		
		if($sistemEl->va)
		{
			$this->isVa = true;

			$this->avg_cvss = $sistemEl->va->average_cvss_score;
			$this->app_sec = $sistemEl->va->app_security_score;
			$this->tanggal = $sistemEl->va->tanggal;
		}
	}
}
