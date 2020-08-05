<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Datauser extends BaseController
{
	
	protected $siakad_akun = 'siakad_akun';
	public function index()
	{

		$data = [
			'title' => 'Setting Data',
			'judul' => 'Data User',
			'mn_setting'=>true,
			'mn_setting_datauser'=>true
			
		];
		return view('admin/datauser',$data);
	}
	public function listdata(){
		echo "ON....";
	}
}
