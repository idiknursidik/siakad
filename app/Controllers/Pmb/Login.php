<?php 
namespace App\Controllers\Pmb;
use App\Controllers\BaseController;

class Login extends BaseController
{
	public function __construct(){
		$this->db = \Config\Database::connect();
	}
	private $pmb_akun = "pmb_akun";
	public function index()
	{
		
		$data = [
			'tpl_title' => 'Penerimaan Mahasiswa Baru',
			'judul'=>'Login calon mahasiswa',
			'mn_login'=>true
		];
		return view('pmb/login',$data);
	}
	public function form(){		
		if($this->request->isAJAX()){
			echo "<form id='form_login' method='post' action='".base_url()."/pmb/login/proseslogin'>";
			echo csrf_field();
			echo "<label>Username/Email</label>";
			echo "<div class='input-group'>";				
				echo "<input type='text' name='username' class='form-control'>";
			echo "</div>";
			echo "<label>Password</label>";
			echo "<div class='input-group'>";				
				echo "<input type='password' name='password' class='form-control'>";
			echo "</div>";
			echo "<hr>";
			echo "<button type='submit' id='btnSubmit_form_login' class='btn btn-primary'>Login</button>";
			echo "</form>";
		}
	}
	public function proseslogin(){
		if($this->request->isAJAX()){
			$ret=array("success"=>false,"messages"=>array());
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
				foreach($validation->getErrors() as $key=>$value){
					$msg['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
				}
			}else{				
				//cek user di database
				$qcekuser = $this->db->query("SELECT * FROM {$this->pmb_akun} WHERE email = '{$username}' ");
				$result = $qcekuser->getResult();
				if(count($result) > 0){
					$row = $qcekuser->getRow();
					$password_user = $row->password;
					if(password_verify($password,$password_user)){
						$simpan_session = [
							'login' => true,
							'username' => $row->email,
							'nama' => $row->nama,
							'type'=>'pmb'
						];
						$this->session->set($simpan_session);
						$msg = [
							'success' => true,
							'messages'=>['Loged in.....'],							
							'link'=>base_url()							
						];
					}else{
						$msg = [
							'messages' => [
								'password'=>'<div class="invalid-feedback">Maaf password salah</div>'
							]
						];
					}
				}else{
					$msg = [
							'messages' => [
								'username'=>'<div class="invalid-feedback">Akun tidak ditemukan</div>'
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
