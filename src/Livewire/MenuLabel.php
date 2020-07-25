<?php

namespace IkamiUsr\Livewire;

use Livewire\Component;
use IkamiAdm\Models\Asesi;
use IkamiAdm\Models\Asesmen;
use IkamiAdm\Models\Pengguna;
use IkamiAdm\Models\Penyedia;
use IkamiAdm\Models\SistemEl;
use IkamiAdm\Models\Status;
use IkamiAdm\Models\User;

class MenuLabel extends Component
{
	public $label;
	public $labelColor;
	
	public function mount($label, $labelColor)
	{
		$this->label = $label;
		$this->labelColor = $labelColor;
	}

	protected $listeners = ['statusUpdated'];

	public function render()
	{
		$user = User::find(auth()->id());

		$sektor = $user->sektor()->first();

		switch($this->label)
		{
			case 'ver-penyedia':
				$x = Penyedia::currentStatus(Status::MENUNGGU)->count();
				break;
			case 'ver-pengguna':
				$x = Pengguna::currentStatus(Status::MENUNGGU)->count();
				break;
			case 'ver-sistem-el':
				$x = SistemEl::currentStatus(Status::MENUNGGU)->count();
				break;
			case 'ver-asesi':
				$x = Asesi::currentStatus(Status::MENUNGGU)->count();
				break;
			case 'penjadwalan-da':
				$x = Asesmen::whereHas('sistemEl', function($query) use ($sektor) {
					$query->where('sektor_id', $sektor->id);
				})->currentStatus(Status::MASUK)->count();
				break;
			case 'desktop-assessment':
				$x = Asesmen::whereHas('asesor', function($query) use ($user) {
            		$query->where('user_id', $user->id);
        		})->currentStatus(Status::TERJADWAL)->count();
				break;
			default:
				$x = 0;
		}

		return view('ikami-usr::livewire.menu-label', [
			'x' => $x
		]);
	}

	public function statusUpdated()
	{

	}
}
