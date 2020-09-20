<?php 
namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		//rekap data
		$jumlah_mahasiswa	= $this->msiakad_mahasiswa->getdata();		
		$jumlah_dosen 		= $this->msiakad_dosen->getdata();		
		$jumlah_prodi 		= $this->msiakad_prodi->getdata();
		$data = [
			'title' => 'halaman depan',
			'jumlah_mahasiswa'=>count($jumlah_mahasiswa),
			'jumlah_dosen'=>count($jumlah_dosen),
			'jumlah_prodi'=>count($jumlah_prodi)
		];
		if(session()->type == "admin"){
			return view('welcome_message',$data);
		}else if(session()->type == 'dosen'){
			return view('dosen/home',$data);
		}else{
			return view('mahasiswa/home',$data);
		}
	}

	//--------------------------------------------------------------------

}
