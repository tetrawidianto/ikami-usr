<?php

namespace IkamiUsr\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use IkamiAdm\Models\Asesmen;
use IkamiAdm\Models\User;

class DesktopAssessment extends Component
{
	use WithPagination;

	public $search;
	public $user;
	public $asesmenId;
	public $terjadwal = true;
	public $berlangsung = true;
	public $selesai = true;

	public function mount()
	{
		$this->user = User::find(auth()->id());
	}

	public function render()
	{
		$searchTerm = '%'.$this->search.'%';

		$status = [];
		
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

		$listAsesmen = Asesmen::with('sistemEl', 'versi')->whereHas('asesor', function($query) {
			$query->where('user_id', $this->user->id);
		})
		->whereHas('sistemEl', function($query) use ($searchTerm) {
			$query->where('nama', 'like', $searchTerm);
		})
		->currentStatus($status)
		->orderBy('jadwal')
		->paginate(10);

		return view('ikami-usr::livewire.desktop-assessment', [
			'listAsesmen' => $listAsesmen
		]);
	}

	public function filterStatus($status)
	{
		$this->{$status} = !$this->{$status};
	}
}