<?php 
namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		//rekap data
		$jumlah_mahasiswa	= $this->msiakad_mahasiswa->getdata();
		$retjumlah_mahasiswa = ($jumlah_mahasiswa)?count($jumlah_mahasiswa):0;		
		$jumlah_dosen 		= $this->msiakad_dosen->getdata();
		$retjumlah_dosen	= ($jumlah_dosen)?count($jumlah_dosen):0;	
		$jumlah_prodi 		= $this->msiakad_prodi->getdata();
		$retjumlah_prodi	= ($jumlah_prodi)?count($jumlah_prodi):0;
		$data = [
			'title' => 'halaman depan',
			'jumlah_mahasiswa'=>$retjumlah_mahasiswa,
			'jumlah_dosen'=>$jumlah_dosen,
			'jumlah_prodi'=>$jumlah_prodi
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
