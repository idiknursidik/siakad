<?php 
namespace App\Controllers\Pmb;
use App\Controllers\BaseController;

class Daftar extends BaseController
{
	public function __construct(){
		$this->db = \Config\Database::connect();
	}
	private $pmb_akun = 'pmb_akun';
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
	public function prosesdaftar(){
		if($this->request->isAJAX()){
			$ret=array("success"=>false,"messages"=>array());
			$username 	= $this->request->getVar("username");
			$nama		= $this->request->getVar("nama");
			$email		= $this->request->getVar("email");
			$konfirmasi_email		= $this->request->getVar("konfirmasi_email");
			$nik_nisn		= $this->request->getVar("nik");
			$hp		= $this->request->getVar("hp");
			
			$validation = \Config\Services::validation();
			$valid = $this->validate([
				"nama" => [
					"label" => 'Nama',
					"rules" => 'required',
					"errors" => [
						'required' => 'Nama harus diisi',
					]
				],
				"hp" => [
					"label" => 'Nomor',
					"rules" => 'required',
					"errors" => [
						'required' => 'Nomor hp harus diisi',
					]
				],
				"email" => [
					"label" => 'Email',
					"rules" => 'required|valid_email',
					"errors" => [
						'required' => 'Email harus diisi',
						'valid_email'=> 'Penulisan Email harus benar'
					]
				],
				"konfirmasi_email" => [
					"label" => 'Email Konfirmasi',
					"rules" => 'required|valid_email|matches[email]',
					"errors" => [
						'required' => 'Konfirmasi Email harus diisi',
						'valid_email'=> 'Penulisan Konfirmasi Email harus benar',
						'matches'=> 'Konfirmasi email tidak sama'
					]
				]
			]);
			
			if(!$valid){
				foreach($validation->getErrors() as $key=>$value){
					$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
				}
			}else{
				$generate = rand(strtotime(date('YmdHis')),15);
				$password = password_hash($generate.$email,PASSWORD_DEFAULT);
				$datain = array("nama"=>$nama,
								"email"=>$email,
								"password"=>$password,
								"nik_nisn"=>$nik_nisn,
								"hp"=>$hp,
								"date_create"=>date('Y-m-d H:i:s'));
				$query = $this->db->table($this->pmb_akun)->insert($datain);		
				if($query){
					//kirim email
					$ret['messages'] = "Akun berhasil dibuat silahkan cek email";
					$ret['success'] = true;	
				}else{
					$ret['messages'] = "Data gagal diupdate";
				}	
			}
			echo json_encode($ret);		}
	}
	public function verification(){
		
	}
}
