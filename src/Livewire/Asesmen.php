<?php

namespace IkamiUsr\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use IkamiAdm\Models\SistemEl;
use IkamiAdm\Models\Status;
use IkamiAdm\Models\User;
use IkamiAdm\Models\Versi;

class Asesmen extends Component
{
	use WithPagination;

	public $search;
	public $user;
	public $sistemElId;
	public $versiId;

	public function mount()
	{
		$this->user = User::find(auth()->id());
	}

	public function render()
	{
		$uAsesmen = $this->user->asesmen()->get()->filter(function($asesmen) {
			return !$asesmen->terjawabSemua();
		})->first();

		$searchTerm = '%'.$this->search.'%';

		return view('ikami-usr::livewire.asesmen', [
			'daftarSistemEl' => SistemEl::currentStatus(Status::DITERIMA)->whereHas('asesi', function($query) {
				$query->currentStatus(Status::DITERIMA)->where('user_id', $this->user->id);
			})->get(['id', 'nama']),
			'daftarVersi' => Versi::where('is_active', true)->get(['id', 'kode']),
			'daftarAsesmen' => $this->user->asesmen()->with('sistemEl', 'versi')->whereHas('sistemEl', function($query) use ($searchTerm) {
				$query->where('nama', 'like', $searchTerm);
			})->paginate(10),
			'uAsesmen' => $uAsesmen
		]);
	}

	public function tambahAsesmen()
	{
		$this->validate([
			'sistemElId' => 'required',
			'versiId' => 'required'
		]);

		$asesmen = $this->user->inisiasiAsesmen()->create([
            'sistem_el_id' => $this->sistemElId,
            'versi_id' => $this->versiId
        ]);

		$this->reset('sistemElId', 'versiId');

		session()->flash('message', '');
	}
}