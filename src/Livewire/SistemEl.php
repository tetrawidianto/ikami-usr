<?php

namespace IkamiUsr\Livewire;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use IkamiAdm\Models\Asesi;
use IkamiAdm\Models\Badge;
use IkamiAdm\Models\SistemEl as SistemElModel;
use IkamiAdm\Models\Status;
use IkamiAdm\Models\User;
use IkamiAdm\Scopes\AsesiScope;

class SistemEl extends Component
{
	use WithFileUploads;
	use WithPagination;

	public $search;
	public $nama;
	public $deskripsi;
	public $suratTugas;
	public $message = [
			'required' => ':attribute harus diisi.',
			'image' => ':attribute harus berupa foto.',
			'max' => [
		    	'file' => ':attribute tidak boleh lebih besar dari :max kilobytes.',
			],
		];
	public $attribute = [
			'nama' => 'Nama',
			'deskripsi' => 'Deskripsi',
			'suratTugas' => 'Surat Tugas'
		];
	public $user;
	public $pengguna;
	public $hubunganTerbuka = false;
	public $sistemElId;
	public $namaSistemEl;
	public $isKoreksiSistemEl = false;
	public $isKoreksiAsesi = false;

	public function mount()
	{
		$this->user = User::find(auth()->id());
		$this->pengguna = $this->user->pengguna;
		
	}

	public function render()
	{
		$uSistemEl = SistemElModel::where('inisiator_id', $this->user->id)->latest()->first();

		$uAsesi = Asesi::where('user_id', $this->user->id)->latest()->first();

		$searchTerm = '%'.$this->search.'%';

		return view('ikami-usr::livewire.sistem-el', [
			'daftarSistemEl' => SistemElModel::with(['asesi' => function($query) {
				$query->withoutGlobalScope(AsesiScope::class)->where('user_id', $this->user->id);
			}])->where('penyedia_id', $this->pengguna->penyedia_id)
				->where('nama', 'like', $searchTerm)
				->orWhere(function($query) use ($searchTerm) {
					$query->where('penyedia_id', $this->pengguna->penyedia_id)
						->where('deskripsi', 'like', $searchTerm);
				})
				->latest()->paginate(10),
			'uAsesi' => $uAsesi,
			'uSistemEl' => $uSistemEl
		]);
	}

	public function tambahSistemEl()
	{
		$this->validate([
			'nama' => ['required', 'string', 'min:3', 'max:255', 
			Rule::unique('sistem_el')->where(function($query) {
                return $query->where('penyedia_id', $this->pengguna->penyedia_id);
            })
		],
			'deskripsi' => 'required',
			'suratTugas' => 'required|image|max:2048'
		], $this->message, $this->attribute);

		$sistemEl = $this->user->inisiasiSistemEl()->create([
			'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'penyedia_id' => $this->pengguna->penyedia_id
		]);

		$surat_tugas = $this->suratTugas->store('surat_tugas');

		$asesi = $sistemEl->asesi()->create([
			'user_id' => $this->user->id,
            'surat_tugas' => $surat_tugas
		]);

		$this->reset('nama', 'deskripsi', 'suratTugas');

		$sistemEl->setStatus(Status::MENUNGGU, Badge::MENUNGGU);
		
		$asesi->setStatus(Status::MENUNGGU, Badge::MENUNGGU);

		session()->flash('message', '');
	}

	public function koreksiSistemEl()
	{
		$sistemEl = SistemElModel::where('inisiator_id', $this->user->id)->latest()->first();

		$this->validate([
			'nama' => ['required', 'string', 'min:3', 'max:255', 
			Rule::unique('sistem_el', 'nama')->ignore($sistemEl->id)->where(function($query) {
                return $query->where('penyedia_id', $this->pengguna->penyedia_id);
            })
		],
			'deskripsi' => 'required',
		], $this->message, $this->attribute);

		$sistemEl->update([
			'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
		]);

		$this->reset('nama', 'deskripsi');

		$sistemEl->setStatus(Status::MENUNGGU, Badge::MENUNGGU);

		session()->flash('message', '');

		$this->isKoreksiSistemEl = false;
	}

	public function koreksiAsesi()
	{
		$this->validate([
			'suratTugas' => 'required|image|max:2048'
		], $this->message, $this->attribute);

		$surat_tugas = $this->suratTugas->store('surat_tugas');

		$asesi = Asesi::where('user_id', $this->user->id)->latest()->first();

		Storage::delete($asesi->surat_tugas);

		$asesi->update([
			'surat_tugas' => $surat_tugas
		]);

		$this->reset('suratTugas');

		$asesi->setStatus(Status::MENUNGGU, Badge::MENUNGGU);

		session()->flash('message', '');

		$this->isKoreksiAsesi = false;
	}

	public function bukaHubungan($sistemElId, $namaSistemEl)
	{
		$this->hubunganTerbuka = true;
		$this->sistemElId = $sistemElId;
		$this->namaSistemEl = $namaSistemEl;
	}

	public function tutupHubungan()
	{
		$this->hubunganTerbuka = false;
		$this->reset('sistemElId', 'namaSistemEl');
	}

	public function hubungkan()
	{
		$this->validate([
			'suratTugas' => 'required|image|max:2048'
		], $this->message, $this->attribute);

		$sistemEl = SistemElModel::find($this->sistemElId);

		$surat_tugas = $this->suratTugas->store('surat_tugas');

		$asesi = $sistemEl->asesi()->create([
			'user_id' => $this->user->id,
            'surat_tugas' => $surat_tugas
		]);

		$this->reset('suratTugas');

		$asesi->setStatus(Status::MENUNGGU, Badge::MENUNGGU);

		session()->flash('message', '');

		$this->tutupHubungan();
	}

	public function bukaKoreksiSistemEl()
	{
		$this->isKoreksiSistemEl = true;
		
		$sistemEl = SistemElModel::where('inisiator_id', $this->user->id)->latest()->first();
		
		$this->nama = $sistemEl->nama;
		$this->deskripsi = $sistemEl->deskripsi;
	}

	public function bukaKoreksiAsesi()
	{
		$this->isKoreksiAsesi = true;
	}
}