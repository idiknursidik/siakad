<?php 
namespace App\Controllers\Pmb;
use App\Controllers\BaseController;

class Login extends BaseController
{
	public function __construct(){
		$this->db = \Config\Database::connect();
	}
	public function index()
	{
		
		$data = [
			'tpl_title' => 'Penerimaan Mahasiswa Baru',
			'judul'=>'Login calon mahasiswa'
		];
		return view('pmb/login',$data);
	}
	public function form(){		
		if($this->request->isAJAX()){
			echo "login";
		}
	}
}
