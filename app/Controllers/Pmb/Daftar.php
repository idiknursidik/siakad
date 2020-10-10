<?php 
namespace App\Controllers\Pmb;
use App\Controllers\BaseController;

class Daftar extends BaseController
{
	public function __construct(){
		$this->db = \Config\Database::connect();
	}
	public function index()
	{
		
		$data = [
			'title' => 'Halaman Pendaftaran Mahasiswa Baru'
		];
		return view('pmb/daftar',$data);
	}
	public function formdaftar(){
		$data = [
			'title' => 'Halaman Pendaftaran Mahasiswa Baru'
		];
		if($this->request->isAJAX()){
			return view('pmb/daftar_form',$data);
		}
	}
}
