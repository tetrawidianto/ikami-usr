<?php 

namespace IkamiUsr\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use IkamiAdm\Models\Asesmen;
use IkamiAdm\Models\Status;
use IkamiAdm\Models\User;

class Penjadwalan extends Component
{
	use WithPagination;

	public $isOpen = false;
	public $itemId;
	public $masuk =true;
	public $terjadwal = true;
	public $berlangsung = true;
	public $selesai = true;
	public $search;

	protected $listeners = ['sidebarClosed', 'statusUpdated'];

	public function render()
	{
		$searchTerm = '%'.$this->search.'%';

		$user = User::find(auth()->id());

		$sektor = $user->sektor()->first();

		$status = [];
		
		if($this->masuk)
		{
			array_push($status, 'masuk');
		}
		if($this->terjadwal)
		{
			array_push($status, 'terjadwal');
		}
		if($this->berlangsung)
		{
			array_push($status, 'berlangsung');
		}
		if($this->selesai)
		{
			array_push($status, 'selesai');
		}

		$listAsesmen = Asesmen::with('sistemEl', 'versi')
			->whereHas('sistemEl', function($query) use ($sektor, $searchTerm) {
				$query->where('sektor_id', $sektor->id)
					->where('nama', 'like', $searchTerm);
			})
			->currentStatus($status)
			->latest()
			->get();

		return view('ikami-usr::livewire.penjadwalan', [
			'listAsesmen' => $listAsesmen
		]);
	}

	public function openSidebar($itemId)
	{
		if($this->itemId == $itemId)
		{
			$this->isOpen = false;
		}
		else
		{
			$this->isOpen = true;
			$this->itemId = $itemId;
			$this->emitTo('penjadwalan-sidebar', 'loadData', $itemId);
		}
	}

	public function sidebarClosed()
	{
		$this->isOpen = false;
		$this->reset('itemId');
	}

	public function statusUpdated()
	{

	}
}