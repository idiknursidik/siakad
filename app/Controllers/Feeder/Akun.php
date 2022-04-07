<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Akun extends BaseController
{
	
	protected $feeder_akun = 'feeder_akun';
	public function index()
	{

		$data = [
			'title' => 'Akun PDDIKTI',
			'judul' => 'Setting akun PDDIKTI',
			'mn_akun'=>true
		];
		return view('feeder/akun',$data);
	}
	public function form()
	{
		
		$this->session 		= \Config\Services::session();
		$userinfo = $this->session->get("userinfo");
		$feeder_akun = $this->session->get("feeder_akun");
		
		if($feeder_akun){
			$profilpt = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetProfilPT','',false,'1','0');
			if($profilpt->error_code != 0){
				echo $profilpt->error_desc;
				echo "<hr><a class='btn btn-danger' href='".base_url()."/feeder/akun/logout'>Login ulang</a>";
				exit();
			}
			echo "<div class='info-box bg-success'>";
				echo "<span class='info-box-icon'><i class='fas fa-check-circle'></i></span>";
				echo "<div class='info-box-content'>";
					echo "<span class='info-box-number'>{$profilpt->data[0]->nama_perguruan_tinggi}</span>";
					echo "<span class='info-box-text'>Username : {$feeder_akun->username}, Url : {$feeder_akun->url}</span>";

					echo "<div class='progress'>";
					  echo "<div class='progress-bar' style='width: 100%'></div>";
					echo "</div>";
					echo "<span class='progress-description'>Token : {$feeder_akun->token}</span>";
				echo "</div>";
            echo "</div>";
		}else{
			echo "<div class='info-box bg-danger'>";
				echo "<span class='info-box-icon'><i class='far fa-times-circle'></i></span>";
				echo "<div class='info-box-content'>";
					echo "<span class='info-box-number'>Status</span>";

					echo "<div class='progress'>";
					  echo "<div class='progress-bar' style='width: 1%'></div>";
					echo "</div>";
					echo "<span class='progress-description'>Tidak konek ke PDDIKTI FEEDER</span>";
				echo "</div>";
            echo "</div>";
		}
		
		if($feeder_akun){
			echo " <a class='btn btn-danger' href='".base_url()."/feeder/akun/logout'>Logout PDDIKTI</a>";
		}else{
			echo "<form method='post' id='login_feeder' action='".base_url()."/feeder/akun/loginfeeder' class='d-inline'>";
			echo csrf_field();
			 echo "<div class='form-group'>";
				echo "<label for='url'>Url</label>";
				echo "<input name='url' type='url' class='form-control' id='url' placeholder='masukan url PDDIKTI contoh : http://localhost:8100/' value='".old('url')."'>";
			  echo "</div>";
			  echo "<div class='form-group'>";
				echo "<label for='username'>Username</label>";
				echo "<input name='username' type='username' class='form-control' id='username' placeholder='masukan username atau kodept' value='".old('username')."'>";
			  echo "</div>";
			  echo "<div class='form-group'>";
				echo "<label for='password'>Password</label>";
				echo "<input name='password' type='text' class='form-control' placeholder='masukan password PDDIKTI' id='password' value='".old('password')."'>";
			  echo "</div>";
			echo "<hr><button type='submit' id='btnSubmit_login_feeder' class='btn bg-primary'>Proses connect PDDIKTI</button>";
			echo "</form>";	
		}
		
	}

	public function loginfeeder(){
		
		$ret=array("success"=>false,"messages"=>array(),"error_feeder"=>false);
		$validation =  \Config\Services::validation();   
		if (! $this->validate([
			'username' =>[
				'rules' => 'required',
				'errors' => [
					'required' => '{field} harus diisi.'
				]
			],
			'password'  => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Password harus diisi.'
				]
			],
			'url'  => [
				'rules' => 'required|prep_url',
				'errors' => [
					'required' => 'URL harus diisi.',
					'prep_url' => 'URL harus benar.'
				]
			]
		]))
		{
			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
			
		}else{		
			$username = $this->request->getVar("username");
			$password = $this->request->getVar("password");
			$url	= $this->request->getVar("url");
			$datain =  [
				'kodept'	=> $username,
				'username'  => $username,
				'password'  => $password,
				'feeder_in' => TRUE
			];
				
				
			$this->session 		= \Config\Services::session();
			//ws
			$dataws = array('act'=>'GetToken','username'=>$username,'password'=>$password);
			$returnws = $this->mfeeder_ws->runWS($dataws,false,$url);
			$returnws = json_decode($returnws);
			if(!$returnws){
				$ret['messages'] = "Isian url salah";
				$ret['error_feeder'] = true;
			}else{
				if($returnws->error_code != 0){
					$ret['error_feeder'] = true;
					$ret['messages'] = $returnws->error_desc;
				}else{					
					$datauserfeeder = array('act'=>'GetToken','username'=>$username,'password'=>$password,'url'=>$url,"token"=>$returnws->data->token);
					$this->session->set('feeder_akun',$this->mfungsi->array_to_object($datauserfeeder));
					$ret['messages'] = "Logedin...";
					$ret['success'] = true;
				}
			}
		}
		echo json_encode($ret);
	}
	public function logout(){
		$this->session 		= \Config\Services::session();
		$this->session->remove('feeder_akun');
		return redirect()->to(base_url().'/feeder/akun');
	}

}
