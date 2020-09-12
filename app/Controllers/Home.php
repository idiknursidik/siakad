<?php 
namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		
		$data = [
			'title' => 'halaman depan'
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
