<?php

namespace IkamiUsr\Livewire;

use App\User;
use Livewire\Component;
use IkamiAdm\Models\Asesi;
use IkamiAdm\Models\Badge;
use IkamiAdm\Models\Pengguna;
use IkamiAdm\Models\Penyedia;
use IkamiAdm\Models\Sektor;
use IkamiAdm\Models\SistemEl;
use IkamiAdm\Models\Status;

class VerSidebar extends Component
{
	public $ditolak = false;
	public $alasan;
	public $itemId;
	public $path;
	public $sektorTerpilih;
	public $message = [
			'required' => ':attribute harus dipilih.',
		];
	public $attribute = [
			'sektorTerpilih' => 'Sektor',
			
		];
	public $isEdit = false;

	protected $listeners = ['loadData'];

	public function mount()
	{
		$this->path = request()->path();
	}

	public function render()
	{
		$listSektor = [];
		
		if($this->itemId)
		{
			switch($this->path)
			{
				case 'ver-penyedia':
					$model = Penyedia::find($this->itemId);
					break;
				case 'ver-pengguna':
					$model = Pengguna::find($this->itemId);
					break;
				case 'ver-sistem-el':
					$model = SistemEl::with('sektor')->find($this->itemId);
					$listSektor = Sektor::get(['id', 'nama']);
					break;
				default:
					$model = Asesi::find($this->itemId);
			}
		}
		else
		{
			$model = NULL;
		}

		return view('ikami-usr::livewire.ver-sidebar-1', [
			'model' => $model,
			'listSektor' => $listSektor
		]);
	}

	public function updateStatus()
	{
		switch($this->path)
		{
			case 'ver-penyedia':
				$model = Penyedia::find($this->itemId);
				break;
			case 'ver-pengguna':
				$model = Pengguna::find($this->itemId);
				break;
			case 'ver-sistem-el':
				$model = SistemEl::find($this->itemId);
				break;
			default:
				$model = Asesi::find($this->itemId);
		}

		if($this->ditolak)
		{
			$this->validate([
				'alasan' => 'required'
			]);

			$model->setStatus(Status::DITOLAK, Badge::DITOLAK, $this->alasan);

			if($this->path == 'ver-pengguna')
			{
				User::find($model->user_id)->syncRoles([]);
			}
			
		}
		else
		{
			if($this->path == 'ver-sistem-el')
			{
				$this->validate([
					'sektorTerpilih' => 'required'
				], $this->message, $this->attribute);

				$model->update([
					'sektor_id' => $this->sektorTerpilih
				]);
			}

			$model->setStatus(Status::DITERIMA, Badge::DITERIMA);

			if($this->path == 'ver-pengguna')
			{
				User::find($model->user_id)->assignRole('pengguna');
			}
		}

		$this->reset('ditolak', 'alasan', 'sektorTerpilih');

		$this->emitTo('verifikasi', 'statusUpdated');

		$this->emitTo('menu-label', 'statusUpdated');

		$this->isEdit = false;
		
	}

	public function loadData($itemId)
	{
		$this->itemId = $itemId;
	}

	public function closeSidebar()
	{
		$this->reset('ditolak', 'alasan');
		$this->emitTo('verifikasi', 'sidebarClosed');
		$this->isEdit = false;
	}

	public function ubahStatus()
	{
		$this->isEdit = true;
	}

	public function batalUbahStatus()
	{
		$this->isEdit = false;
	}
}
