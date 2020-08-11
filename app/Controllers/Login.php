<?php 
namespace App\Controllers;

class Login extends BaseController
{
	public function __construct(){
		$this->db = \Config\Database::connect();
	}
	public function index()
	{
		
		$data = [
			'title' => 'Halaman Login'
		];
		return view('login',$data);
	}
	public function proseslogin(){
		if($this->request->isAJAX()){
			$username = $this->request->getVar("username");
			$password = $this->request->getVar("password");
			
			$validation = \Config\Services::validation();
			$valid = $this->validate([
				"username" => [
					"label" => 'Username',
					"rules" => 'required',
					"errors" => [
						'required' => 'Username harus diisi',
					]
				],
				"password" => [
					"label" => 'Password',
					"rules" => 'required',
					"errors" => [
						'required' => 'Password harus diisi',
					]
				]
			]);
			
			if(!$valid){
				$msg = [
					'error' => [
						'username'=>$validation->getError("username"),
						'password'=>$validation->getError("password")
					]
				];
			}else{
				//cek user di database
				$qcekuser = $this->db->query("SELECT * FROM siakad_akun JOIN siakad_level ON userlevel = level WHERE username = '{$username}' ");
				$result = $qcekuser->getResult();
				if(count($result) > 0){
					$row = $qcekuser->getRow();
					$password_user = $row->password;
					if(password_verify($password,$password_user)){
						$simpan_session = [
							'login' => true,
							'username' => $row->username,
							'nama' => $row->nama,
							'level' => $row->level,
							'nama_level' => $row->nama_level
						];
						$this->session->set($simpan_session);
						$msg = [
							'success' => [
								'link'=>base_url()
							]
						];
					}else{
						$msg = [
							'error' => [
								'password'=>'Maaf password salah'
							]
						];
					}
				}else{
					$msg = [
						'error' => [
							'username'=>'Username tidak ditemukan'
						]
					];
				}
			}
			echo json_encode($msg);
		}
	}
	public function logout(){
		$this->session->destroy();
		return redirect()->to('index');
	}
}