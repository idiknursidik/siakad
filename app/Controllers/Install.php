<?php 
namespace App\Controllers;

class Install extends BaseController
{
	public function __construct(){
		$this->db = \Config\Database::connect();
	}
	public function index()
	{
		
		$data = [
			'title' => 'Halaman Install'
		];
		//create akun jika tidak ada admin
		return view('install',$data);
	}
	public function prosesinstall(){
		if($this->request->isAJAX()){
			
				
			
			echo json_encode($msg);
		}
	}
	
}
