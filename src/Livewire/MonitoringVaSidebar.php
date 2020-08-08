<?php

namespace IkamiUsr\Livewire;

use IkamiAdm\Models\SistemEl;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

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

	protected $listeners = ['loadData'];

	public function render()
	{
		return view('ikami-usr::livewire.monitoring-va-sidebar');
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
