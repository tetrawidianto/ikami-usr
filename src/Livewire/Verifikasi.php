<?php

namespace IkamiUsr\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use IkamiAdm\Models\Asesi;
use IkamiAdm\Models\Pengguna;
use IkamiAdm\Models\Penyedia;
use IkamiAdm\Models\Sektor;
use IkamiAdm\Models\SistemEl;

class Verifikasi extends Component
{
	use WithPagination;

	public $search;
	public $isOpen = false;
	public $itemId;
	public $path;
	public $diterima =true;
	public $menunggu = true;
	public $ditolak = true;

	protected $listeners = ['sidebarClosed', 'statusUpdated'];

	public function mount()
	{
		$this->path = request()->path();
	}

	public function render()
	{
		$searchTerm = '%'.$this->search.'%';

		$status = [];
		if($this->diterima)
		{
			array_push($status, 'diterima');
		}
		if($this->menunggu)
		{
			array_push($status, 'menunggu');
		}
		if($this->ditolak)
		{
			array_push($status, 'ditolak');
		}

		switch($this->path)
		{
			case 'ver-penyedia':
				$title = 'Verifikasi Penyedia';
				$listModel = Penyedia::where('nama', 'like', $searchTerm)
					->orWhere('nama_panjang', 'like', $searchTerm)
					->orWhere('alamat', 'like', $searchTerm)
					->currentStatus($status)
					->latest()
					->paginate(10);
				break;
			case 'ver-pengguna':
				$title = 'Verifikasi Pengguna';
				$listModel = Pengguna::with('user', 'penyedia')
					->whereHas('user', function($query) use ($searchTerm) {
						$query->where('name', 'like', $searchTerm);
					})
					->orWhereHas('penyedia', function($query) use ($searchTerm) {
						$query->where('nama', 'like', $searchTerm);
					})
					->currentStatus($status)
					->latest()
					->paginate(10);
				break;
			case 'ver-sistem-el':
				$title = 'Verifikasi Sistem El';
				$listModel = SistemEl::with('penyedia', 'sektor', 'subsektor')
					->where('nama', 'like', $searchTerm)
					->orWhere('deskripsi', 'like', $searchTerm)
					->orWhereHas('penyedia', function($query) use ($searchTerm) {
						$query->where('nama', 'like', $searchTerm);
					})
					->currentStatus($status)
					->latest()
					->paginate(10);
				break;
			default:
				$title = 'Verifikasi Asesi';
				$listModel = Asesi::with('user', 'sistemEl')
					->whereHas('user', function($query) use ($searchTerm) {
						$query->where('name', 'like', $searchTerm);
					})
					->orWhereHas('sistemEl', function($query) use ($searchTerm) {
						$query->where('nama', 'like', $searchTerm);
					})
					->currentStatus($status)
					->latest()
					->paginate(10);
		}

		return view('ikami-usr::livewire.'.$this->path, [
			'listModel' => $listModel,
			'title' => $title,
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
			$this->emitTo('ver-sidebar', 'loadData', $itemId);
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

	public function filterStatus($status)
	{
		$this->{$status} = !$this->{$status};
	}
}
