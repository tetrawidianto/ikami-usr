<?php 

namespace IkamiUsr\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use IkamiAdm\Models\Asesmen;
use IkamiAdm\Models\Status;
use IkamiAdm\Models\User;
use IkamiAdm\Models\Versi;

class MonitoringDa extends Component
{
	use WithPagination;

	public $isOpen = false;
	public $itemId;
	public $versi = '';
	public $masuk =true;
	public $terjadwal = true;
	public $berlangsung = true;
	public $selesai = true;
	public $search;
	public $user;
	public $sektor;

	protected $listeners = ['sidebarClosed', 'statusUpdated'];

	public function mount()
	{
		$this->user = User::find(auth()->id());

		$this->sektor = $this->user->sektor()->first();
	}

	public function render()
	{
		$searchTerm = '%'.$this->search.'%';

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
			->whereHas('sistemEl', function($query) use ($searchTerm) {
				$query->where('sektor_id', $this->sektor->id)
					->where('nama', 'like', $searchTerm);
			})
			->where(function($query) {
				if($this->versi != '')
				{
					$query->whereHas('versi', function($query) {
						$query->where('id', $this->versi);
					});
				}
			})
			->currentStatus($status)
			->latest()
			->paginate(10);

		$listVersi = Versi::get(['id', 'kode']);

		return view('ikami-usr::livewire.monitoring-da', [
			'listAsesmen' => $listAsesmen,
			'listVersi' => $listVersi
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
			$this->emitTo('monitoring-da-sidebar', 'loadData', $itemId);
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