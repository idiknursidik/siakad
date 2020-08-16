<?php 
namespace App\Controllers;

class Profile extends BaseController
{
	private $siakad_akun = "siakad_akun";
	public function index()
	{
		
		$data = [
			'title' => 'Setting Profile',
			'judul' => 'Data Profile',
			'mn_profile'=>true
			
		];
		return view('profile',$data);
	}
	public function show(){
		if($this->request->isAJAX()){
			//print_r(session()->get());
			$data = $this->msiakad_akun->getakun(false,session()->get('username'));
			$userimage = ($data->user_image)?$data->user_image:"noimage.png";
			echo "<h3>Ubah Biodata</h3>";
			echo "<form class='form-horizontal' id='form_editprofile' method='post' action='".base_url()."/profile/updateprofile'>";
			echo "<div class='form-group row'>";
				echo "<label for='username' class='col-sm-2 col-form-label'>Username</label>";
				echo "<div class='col-sm-10'>";
				  echo "{$data->username} [{$this->msiakad_akun->leveluser($data->userlevel)}]";
				  echo "<input type='hidden' name='username' class='form-control' id='username' value='".$data->username."'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group row'>";
				echo "<label for='nama' class='col-sm-2 col-form-label'>Nama</label>";
				echo "<div class='col-sm-10'>";
				  echo "<input type='text' name='nama' class='form-control' id='nama' placeholder='Nama' value='{$data->nama}'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group row'>";
				echo "<label for='email' class='col-sm-2 col-form-label'>Email</label>";
				echo "<div class='col-sm-10'>";
				  echo "<input type='email' class='form-control' name='email' id='email' placeholder='Email' value='{$data->email}'>";
				echo "</div>";
			echo "</div>";
			echo "<button class='btn btn-primary' id='btnSubmit_form_editprofile' type='submit' name='kirim'>Proses update</button>";
			echo "</form>";
			echo "<hr>";
			echo "<h3>Ubah Password</h1>";
			echo "<form class='form-horizontal' id='form_editpassword' method='post' action='".base_url()."/profile/updatepassword'>";
			echo "<div class='form-group row'>";
				echo "<label for='passwordlama' class='col-sm-2 col-form-label'>Password lama</label>";
				echo "<div class='col-sm-10'>";
				  echo "<input type='text' name='passwordlama' class='form-control' id='passwordlama' placeholder='passwordlama'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group row'>";
				echo "<label for='passwordbaru' class='col-sm-2 col-form-label'>Password Baru</label>";
				echo "<div class='col-sm-10'>";
				  echo "<input type='text' name='passwordbaru' class='form-control' id='passwordbaru' placeholder='passwordbaru'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group row'>";
				echo "<label for='passwordbaru2' class='col-sm-2 col-form-label'>Password Konfirmasi</label>";
				echo "<div class='col-sm-10'>";
				  echo "<input type='text' name='passwordbaru2' class='form-control' id='passwordbaru2' placeholder='konfirmasi password baru'>";
				echo "</div>";
			echo "</div>";
			echo "<button class='btn btn-success' id='btnSubmit_form_editpassword' type='submit' name='kirim'>Proses update</button>";
			echo "</form>";
			echo "<hr>";
			echo "<h3>Ubah Gambar Profile</h1>";
			echo "<form method='post' id='form_profile_image' action='".base_url()."/profile/updateimage' enctype='multipart/form-data' class='d-inline'>";	
			echo csrf_field();			 
			  echo "<div class='form-group row'>";
				echo "<div class='col-sm-2'>";
					echo "<img src='".base_url()."/public/gambar/{$userimage}' class='profile-user-img img-fluid img-circle img-preview'>"; //img-thumbnail;
				echo "</div>";
				echo "<div class='col-sm-10'>";
					echo "<label for='logoFile'>User Image</label>";
					echo "<div class='custom-file'>";
					  echo "<input name='fileupload' type='file' class='custom-file-input form-control' id='logoFile'>";
					  echo "<label class='custom-file-label' for='logoFile'>Pilih gambar..</label>";
					echo "</div>";
				echo "</div>";
			  echo "</div>";
			echo "<hr><button type='submit' name='kirim' id='btnSubmit_form_profile_image' class='btn bg-primary'>Proses Update</button>";
			echo "</form>";
		}
	}
	public function updateprofile(){
		if($this->request->isAJAX()){
			$ret=array("success"=>false,"messages"=>array());
			$username 	= $this->request->getVar("username");
			$nama		= $this->request->getVar("nama");
			$email		= $this->request->getVar("email");
			
			$validation = \Config\Services::validation();
			$valid = $this->validate([
				"nama" => [
					"label" => 'Nama',
					"rules" => 'required',
					"errors" => [
						'required' => 'Nama harus diisi',
					]
				],
				"email" => [
					"label" => 'Email',
					"rules" => 'required|valid_email',
					"errors" => [
						'required' => 'Email harus diisi',
						'valid_email'=> 'Penulisan Email harus benar'
					]
				]
			]);
			
			if(!$valid){
				foreach($validation->getErrors() as $key=>$value){
					$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
				}
			}else{
				$datain = array("nama"=>$nama,
								"email"=>$email,
								"date_update"=>date('Y-m-d H:i:s'));
				$query = $this->db->table($this->siakad_akun)->update($datain,['username'=>session()->username]);		
				if($query){	
					$ret['messages'] = "Data berhasil diupdate";
					$ret['success'] = true;	
				}else{
					$ret['messages'] = "Data gagal diupdate";
				}	
			}
			echo json_encode($ret);
		}
	}
	public function updatepassword(){
		if($this->request->isAJAX()){
			$ret=array("success"=>false,"messages"=>array());
			$passwordlama 	= $this->request->getVar("passwordlama");
			$passwordbaru	= $this->request->getVar("passwordbaru");
			$passwordbaru2	= $this->request->getVar("passwordbaru2");
			
			$validation = \Config\Services::validation();
			$valid = $this->validate([
				"passwordlama" => [
					"label" => 'Password lama',
					"rules" => 'required',
					"errors" => [
						'required' => 'Password lama harus diisi',
					]
				],
				"passwordbaru" => [
					"label" => 'Password Baru',
					"rules" => 'required',
					"errors" => [
						'required' => 'Password baru harus diisi'
					]
				],
				"passwordbaru2" => [
					"label" => 'Password Baru Konfirmasi',
					"rules" => 'required|matches[passwordbaru]',
					"errors" => [
						'required' => 'Konfirmasi Password baru harus diisi',
						'matches'=> 'Konfirmasi password salah'
					]
				]
			]);
			
			if(!$valid){
				foreach($validation->getErrors() as $key=>$value){
					$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
				}
			}else{
				//cek password lama
				$datalama = $this->msiakad_akun->getakun(false,session()->username);
				$hashed_password = password_hash($passwordbaru,PASSWORD_DEFAULT);
	
				if(!password_verify($passwordlama,$datalama->password)){
					$ret['messages']['passwordlama'] = "<div class='invalid-feedback'>Password lama salah</div>";
				}else{					
					$datain = array("password"=>$hashed_password,
									"date_update"=>date('Y-m-d H:i:s'));
									
					$query = $this->db->table($this->siakad_akun)->update($datain,['username'=>session()->username]);		
					if($query){	
						$ret['messages'] = "Data berhasil diupdate";
						$ret['success'] = true;	
					}else{
						$ret['messages'] = "Data gagal diupdate";
					}	
				}
			}
			echo json_encode($ret);
		}
	}
	public function updateimage(){
		if($this->request->isAJAX()){
			$ret=array("success"=>false,"messages"=>array());
			$validation =  \Config\Services::validation();
			
			if (! $this->validate([
				'fileupload' => [
					'rules' => 'uploaded[fileupload]|max_size[fileupload,1024]|is_image[fileupload]|mime_in[fileupload,image/png,image/jpg,image/jpeg]',
					'errors' => [
						'uploaded' => 'File gambar harus dipilih.', //uploaded[fileupload]
						'max_size' => 'Ukuran gambar terlalu besar.',
						'is_image' => 'Yang anda pilih bukan gambar.',
						'mime_in' => 'Yang anda pilih bukan gambar.'
					] 
				]
			]))
			{			
				foreach($validation->getErrors() as $key=>$value){
					$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
				}
			}else{				
				$datalama = $this->msiakad_akun->getakun(false,session()->username);				
				$fileupload = $this->request->getFile("fileupload");				
				if($fileupload->getError() == 4){
					$user_image = "noimage.png";
				}else{
					if($datalama->user_image != "noimage.png"){
						if(file_exists("public/gambar/".$datalama->user_image)){
							unlink("public/gambar/".$datalama->user_image);
						}
					}
					$user_image = $fileupload->getRandomName();
					$fileupload->move('public/gambar',$user_image);
					
				}			
				
				$datain = array("user_image"=>$user_image,
								"date_update"=>date('Y-m-d H:i:s'));								
				$query = $this->db->table("siakad_akun")->update($datain,['username'=>session()->username]);		
				if($query){	
					$ret['messages'] = "Data berhasil diupdate";
					$ret['success'] = true;	
				}else{
					$ret['messages'] = "Data gagal diupdate";
				}			
				
			}
			echo json_encode($ret);
		}		
	}
}
