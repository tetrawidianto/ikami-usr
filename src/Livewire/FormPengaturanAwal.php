<?php

namespace IkamiUsr\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use IkamiAdm\Models\Badge;
use IkamiAdm\Models\Pengguna;
use IkamiAdm\Models\Penyedia;
use IkamiAdm\Models\Status;
use IkamiAdm\Models\User;

class FormPengaturanAwal extends Component
{
	use WithFileUploads;

	public $user;
	public $aktivasi = false;
	public $nama;
	public $namaPanjang;
	public $alamat;
	public $website;
	public $email;
	public $nomorTelepon;
	public $ktp;
	public $tandaPengenal;
	public $penyediaTerpilih;
	public $message = [
			'required' => ':attribute harus diisi.',
			'image' => ':attribute harus berupa foto.',
			'max' => [
		    	'file' => ':attribute tidak boleh lebih besar dari :max kilobytes.',
			],
		];
	public $attribute = [
			'nama' => 'Nama singkat',
			'namaPanjang' => 'Nama panjang',
			'alamat' => 'Alamat',
			'website' => 'Website',
			'email' => 'Email',
			'nomorTelepon' => 'Nomor telepon',
			'ktp' => 'KTP',
			'tandaPengenal' => 'Tanda Pengenal',
			'penyediaTerpilih' => 'Penyedia'
		];
	public $isKoreksiPenyedia = false;
	public $isKoreksiPengguna = false;

	public function mount()
	{
		$this->user = User::find(auth()->id());
		
	}

	public function render()
	{
		$uPenyedia = Penyedia::where('inisiator_id', $this->user->id)->first();

		$uPengguna = Pengguna::where('user_id', $this->user->id)->first();

		$daftarPenyedia = Penyedia::currentStatus(Status::DITERIMA)->get(['id', 'nama']);

		return view('ikami-usr::livewire.form-pengaturan-awal', [
			'daftarPenyedia' => $daftarPenyedia,
			'uPenyedia' => $uPenyedia,
			'uPengguna' => $uPengguna
		]);
	}

	public function inisiasi()
	{
		if($this->aktivasi)
		{
			$rule = [
				'penyediaTerpilih' => 'required',
				'ktp' => 'required|image|max:2048',
				'tandaPengenal' => 'required|image|max:2048'
			];
		}
		else
		{
			$rule = [
				'nama' => 'required|unique:penyedia',
				'namaPanjang' => 'required',
				'alamat' => 'required',
				'website' => 'required|active_url',
				'email' => 'required|email:rfc,dns',
				'nomorTelepon' => 'required|numeric|digits_between:8,12',
				'ktp' => 'required|image|max:2048',
				'tandaPengenal' => 'required|image|max:2048'
			];
		}

		$this->validate($rule, $this->message, $this->attribute);

		$ktp = $this->ktp->store('ktp');
		$tanda_pengenal = $this->tandaPengenal->store('tanda_pengenal');

		if($this->aktivasi)
		{
			$penyedia = Penyedia::currentStatus(Status::DITERIMA)->find($this->penyediaTerpilih);

			if($penyedia)
			{
				$pengguna = $penyedia->pengguna()->create([
					'user_id' => $this->user->id,
            		'ktp' => $ktp,
            		'tanda_pengenal' => $tanda_pengenal
				]);

				$pengguna->setStatus(Status::MENUNGGU, Badge::MENUNGGU);

				session()->flash('message', '...');

				$this->reset('penyediaTerpilih', 'ktp', 'tandaPengenal');
			}
		}
		else
		{
			$penyedia = $this->user->inisiasiPenyedia()->create([
				'nama' => $this->nama, 
				'nama_panjang' => $this->namaPanjang, 
				'alamat' => $this->alamat, 
				'website' => $this->website, 
				'email' => $this->email, 
				'nomor_telepon' => $this->nomorTelepon
			]);

			$pengguna = $penyedia->pengguna()->create([
	            'user_id' => $this->user->id,
	            'ktp' => $ktp,
	            'tanda_pengenal' => $tanda_pengenal
	        ]);

			$penyedia->setStatus(Status::MENUNGGU, Badge::MENUNGGU);
			$pengguna->setStatus(Status::MENUNGGU, Badge::MENUNGGU);

			session()->flash('message', '...');

			$this->reset('nama', 'namaPanjang', 'alamat', 'website', 'email', 'nomorTelepon', 'ktp', 'tandaPengenal');
		}
	}

	public function koreksiPengguna()
	{
		$rule = [
			'ktp' => 'required|image|max:2048',
			'tandaPengenal' => 'required|image|max:2048'
		];

		$this->validate($rule, $this->message, $this->attribute);

		$ktp = $this->ktp->store('ktp');
		$tanda_pengenal = $this->tandaPengenal->store('tanda_pengenal');

		$pengguna = Pengguna::where('user_id', $this->user->id)->first();

		Storage::delete($pengguna->ktp);
		Storage::delete($pengguna->tanda_pengenal);

		$pengguna->update([
			'ktp' => $ktp,
            'tanda_pengenal' => $tanda_pengenal
		]);

		$this->reset('ktp', 'tandaPengenal');

		$pengguna->setStatus(Status::MENUNGGU, Badge::MENUNGGU);

		session()->flash('message', '...');

		$this->isKoreksiPengguna = false;
	}

	public function koreksiPenyedia()
	{
		$rule = [
			'nama' => 'required',
			'namaPanjang' => 'required',
			'alamat' => 'required',
			'website' => 'required|active_url',
			'email' => 'required|email:rfc,dns',
			'nomorTelepon' => 'required|numeric|digits_between:8,12',
		];

		$this->validate($rule, $this->message, $this->attribute);

		$penyedia = Penyedia::where('inisiator_id', $this->user->id)->first();

		$penyedia->update([
			'nama' => $this->nama, 
			'nama_panjang' => $this->namaPanjang, 
			'alamat' => $this->alamat, 
			'website' => $this->website, 
			'email' => $this->email, 
			'nomor_telepon' => $this->nomorTelepon
		]);

		$this->reset('nama', 'namaPanjang', 'alamat', 'website', 'email', 'nomorTelepon');

		$penyedia->setStatus(Status::MENUNGGU, Badge::MENUNGGU);

		session()->flash('message', '...');

		$this->isKoreksiPenyedia = false;
	}

	public function bukaKoreksiPenyedia()
	{
		$this->isKoreksiPenyedia = true;

		$penyedia = Penyedia::where('inisiator_id', $this->user->id)->first();

		$this->nama = $penyedia->nama;
		$this->namaPanjang = $penyedia->nama_panjang;
		$this->alamat = $penyedia->alamat;
		$this->website = $penyedia->website;
		$this->email = $penyedia->email;
		$this->nomorTelepon = $penyedia->nomor_telepon;
	}

	public function bukaKoreksiPengguna()
	{
		$this->isKoreksiPengguna = true;

		$pengguna = Pengguna::where('user_id', $this->user->id)->first();

		$this->penyediaTerpilih = $pengguna->penyedia_id;
	}
}