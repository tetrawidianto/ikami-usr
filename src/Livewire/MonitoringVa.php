<?php 

namespace IkamiUsr\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use IkamiAdm\Models\SistemEl;

class MonitoringVa extends Component 
{
	use WithPagination;

	public $isOpen = false;
	public $itemId;

	public function render()
	{
		$listSistemEl = SistemEl::currentStatus('diterima')
			->latest()
			->paginate(10);

		return view('ikami-usr::livewire.monitoring-va', [
			'listSistemEl' => $listSistemEl
		]);
	}
}