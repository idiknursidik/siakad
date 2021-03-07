<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Mailsetting extends BaseController
{
	
	protected $setting_mail = 'setting_mail';
	public function __construct(){
		$session = \Config\Services::session();
		if($session->get("level") != 1){
			header("Location:".base_url());
			exit();			
		}
	}
	public function index()
	{

		$data = [
			'title' => 'Setting Mail',
			'judul' => 'Setting Email',
			'mn_setting'=>true,
			'mn_setting_mail'=>true
			
		];
		return view('admin/mailsetting',$data);
	}
	public function form()
	{
		$data = $this->msiakad_setting->getmailsetting();
		if($data){
			$host = $data->smtp_host;
			$port = $data->smtp_port;
			$user = $data->smtp_user;
			$pass = $data->smtp_pass;
			$encryption = $data->encryption;
		}else{
			$host = "";
			$port = "";
			$user = "";
			$pass = "";
			$encryption = "";
		}
		echo "<form method='post' id='form_mailsetting' action='".base_url()."/admin/mailsetting/simpan' enctype='multipart/form-data' class='d-inline'>";
		echo csrf_field();
	
		echo "<div class='form-group'>";
			echo "<label for='smtp_host'>Host</label>";
			echo "<input name='smtp_host' type='text' class='form-control' id='smtp_host' placeholder='masukan host' value='".(($host)?$host:old('smtp_host'))."'>";
		echo "</div>";
		echo "<div class='form-group'>";
			echo "<label for='smtp_port'>Port</label>";
			echo "<input name='smtp_port' type='text' class='form-control' id='smtp_port' placeholder='masukan port' value='".(($port)?$port:old('smtp_port'))."'>";
		echo "</div>";
		echo "<div class='form-group'>";
			echo "<label for='smtp_user'>User</label>";
			echo "<input name='smtp_user' type='text' class='form-control' id='smtp_user' placeholder='masukan user' value='".(($user)?$user:old('smtp_user'))."'>";
		echo "</div>";
		echo "<div class='form-group'>";
			echo "<label for='smtp_pass'>Password</label>";
			echo "<input name='smtp_pass' type='text' class='form-control' id='smtp_pass' placeholder='masukan password' value='".(($pass)?$pass:old('smtp_pass'))."'>";
		echo "</div>";
		echo "<div class='form-group'>";
			echo "<label for='encryption'>encryption</label>";
			echo "<input name='encryption' type='text' class='form-control' id='encryption' placeholder='masukan encryption' value='".(($encryption)?$encryption:old('encryption'))."'>";
		echo "</div>";
		echo "<hr><button type='submit' name='kirim' id='btnSubmit_form_mail' class='btn bg-primary'>Simpan data</button>";
		echo " <a href='".base_url()."' class='btn btn-warning'>Batal</a>";
		echo "</form>";		
	}
	public function simpan(){
		
		$ret=array("success"=>false,"messages"=>array());
		$validation =  \Config\Services::validation();
	
		$cekvalid = $this->validate([
			'smtp_host' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Host harus diisi.'
				] 
			],
			'smtp_port' => [
				'rules' => 'required|min_length[3]|numeric',
				'errors' => [
					'required' => 'Post harus diisi.',
					'min_length' => 'Port minimal 3 karakter.',
					'numeric' => 'Port harus angka'
				] 
			],
			'smtp_user' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'User harus diisi.'
				] 
			],
			'smtp_pass' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Password harus diisi.'
				] 
			]						
			
		]);
		
		if(!$cekvalid){			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{	
			$smtp_host = $this->request->getVar('smtp_host');
			$smtp_port = $this->request->getVar('smtp_port');
			$smtp_user = $this->request->getVar('smtp_user');
			$smtp_pass = $this->request->getVar('smtp_pass');
			$encryption = $this->request->getVar('encryption');
			
			$datain = array("smtp_host"=>$smtp_host,
							"smtp_port"=>$smtp_port,
							"smtp_user"=>$smtp_user,
							"smtp_pass"=>$smtp_pass,
							"encryption"=>$encryption);
			$datalama = $this->msiakad_setting->getmailsetting();				
			if(!$datalama){				
				$this->db->table($this->setting_mail)->insert($datain);
				$ret['messages'] = "Data berhasil dimasukan";
			}else{
				$this->db->table($this->setting_mail)->update($datain);
				$ret['messages'] = "Data berhasil diupdate";
			}			
			$ret['success'] = true;		
		}
		
		echo json_encode($ret);
	}
}
