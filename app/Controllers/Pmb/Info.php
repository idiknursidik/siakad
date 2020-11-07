<?php 
namespace App\Controllers\Pmb;
use App\Controllers\BaseController;

class Info extends BaseController
{
	public function __construct(){
		$this->db = \Config\Database::connect();
	}
	public function index()
	{
		
		$data = [
			'tpl_title' => 'Penerimaan Mahasiswa Baru',
			'judul'=>'Informasi calon mahasiswa',
			'mn_info'=>true
		];
		return view('pmb/info',$data);
	}
	public function informasi(){
		
		if($this->request->isAJAX()){
			echo "Info";
		}
	}
}
