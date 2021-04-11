<?php 
namespace App\Controllers\Pmb;
use App\Controllers\BaseController;

class Biodata extends BaseController
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
		return view('pmb/biodata',$data);
	}
	public function formbiodata(){
		
		if($this->request->isAJAX()){
			echo "Lengkapi Biodata";
		}
	}
}
