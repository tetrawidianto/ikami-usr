<?php 

namespace IkamiUsr\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use IkamiAdm\Models\SistemEl;
use IkamiAdm\Models\User;

class MonitoringVa extends Component 
{
	use WithPagination;

	public $isOpen = false;
	public $itemId;
	public $search;
	public $user;
	public $sektor;

	public function mount()
	{
		$this->user = User::find(auth()->id());

		$this->sektor = $this->user->sektor()->first();
	}

	public function render()
	{
		$searchTerm = '%'.$this->search.'%';

		$listSistemEl = SistemEl::currentStatus('diterima')
			->where('sektor_id', $this->sektor->id)
			->where('nama', 'like', $searchTerm)
			->latest()
			->paginate(10);

		return view('ikami-usr::livewire.monitoring-va', [
			'listSistemEl' => $listSistemEl
		]);
	}
}