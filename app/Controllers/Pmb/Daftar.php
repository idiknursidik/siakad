<?php 
namespace App\Controllers\Pmb;
use App\Controllers\BaseController;

class Daftar extends BaseController
{
	public function __construct(){
		$this->db = \Config\Database::connect();
	}
	public function index()
	{
		
		$data = [
			'title' => 'Halaman Pendaftaran Mahasiswa Baru'
		];
		return view('pmb/daftar',$data);
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
				$qcekuser = $this->db->query("SELECT * FROM siakad_akun WHERE username = '{$username}' ");
				$result = $qcekuser->getResult();
				if(count($result) > 0){
					$row = $qcekuser->getRow();
					$password_user = $row->password;
					if(password_verify($password,$password_user)){
						$simpan_session = [
							'login' => true,
							'username' => $row->username,
							'nama' => $row->nama,
							'level' => $row->userlevel,
							'akses' => $row->akses,
							'nama_level' => $this->msiakad_akun->leveluser($row->userlevel),
							'type'=>'admin'
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
					//cek akun mahasiswa
					$qcekuser = $this->db->query("SELECT a.*,b.id_prodi FROM siakad_akun_mahasiswa a
					LEFT JOIN siakad_riwayatpendidikan b ON a.nim = b.nim
					WHERE a.username = '{$username}' ");
					$result = $qcekuser->getResult();
					if(count($result) > 0){
						$row = $qcekuser->getRow();
						$password_user = $row->password;
						if(password_verify($password,$password_user)){
							//update last login
							$last_login = array('last_login'=>date("Y-m-d H:i:s"));
							$this->db->table("siakad_akun_mahasiswa")->update($last_login,['username'=>$row->username]);
							
							$simpan_session = [
								'login' => true,
								'username' => $row->username,
								'akses' => $row->id_prodi,
								'type'=>'mahasiswa'
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
						//cek akun mahasiswa
						$qcekuser = $this->db->query("SELECT * FROM siakad_akun_dosen WHERE username = '{$username}' ");
						$result = $qcekuser->getResult();
						if(count($result) > 0){
							$row = $qcekuser->getRow();
							$password_user = $row->password;
							if(password_verify($password,$password_user)){
								//update last login
								$last_login = array('last_login'=>date("Y-m-d H:i:s"));
								$this->db->table("siakad_akun_dosen")->update($last_login,['username'=>$row->username]);
								
								$simpan_session = [
									'login' => true,
									'username' => $row->username,
									'type'=>'dosen'
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
				}
				
			}
			echo json_encode($msg);
		}
	}
}
