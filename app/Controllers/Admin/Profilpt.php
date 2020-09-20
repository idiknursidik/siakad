<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Profilpt extends BaseController
{
	
	protected $siakad_profil = 'siakad_profil';
	public function __construct(){
		$session = \Config\Services::session();
		if($session->get("level") != 1){
			echo "DONT ALLOW";
			exit();			
		}
	}
	public function index()
	{

		$data = [
			'title' => 'Setting Data',
			'judul' => 'Setting Profil Perguruan Tinggi',
			'mn_setting'=>true,
			'mn_setting_profile'=>true
			
		];
		return view('admin/profilpt',$data);
	}
	public function form()
	{
		$data = $this->msiakad_setting->getdata();
		if($data){
			$kodept = $data->kodept;
			if($data->logopt){
				$logopt = $data->logopt;
			}else{
				$logopt = 'logo.png';
			}
		}else{
			$kodept = "";
			$logopt = "logo.png";
		}
		echo "<form method='post' id='form_profile' action='".base_url()."/admin/profilpt/simpan' enctype='multipart/form-data' class='d-inline'>";
		echo csrf_field();
		echo "<div class='row'>";
			echo "<div class='col-sm-2'>";
				echo "<img src='".base_url()."/public/gambar/{$logopt}' class='img-fluid img-circle img-preview'>"; //img-thumbnail;
			echo "</div>";
			echo "<div class='col-sm-10'>";
				  echo "<div class='form-group'>";
					echo "<label for='kodept'>Kode Perguruan Tinggi</label>";
					echo "<input name='kodept' type='text' class='form-control' id='kodept' placeholder='masukan KODEPT' value='".(($kodept)?$kodept:old('kodept'))."'>";
				  echo "</div>";
				  echo "<div class='form-group'>";
						echo "<label for='logoFile'>Logo perguruan tinggi</label>";
						echo "<div class='custom-file'>";
						  echo "<input name='fileupload' type='file' class='custom-file-input form-control' id='logoFile'>";
						  echo "<label class='custom-file-label' for='logoFile'>Pilih gambar..</label>";
						echo "</div>";
				  echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "<hr><button type='submit' name='kirim' id='btnSubmit_form_profile' class='btn bg-primary'>Simpan data</button>";
		echo " <a href='".base_url()."' class='btn btn-warning'>Batal</a>";
		echo "</form>";		
	}
	public function simpan(){
		
		$ret=array("success"=>false,"messages"=>array());
		$validation =  \Config\Services::validation();
		$fileupload = $this->request->getFile("fileupload");
		
		if(isset($fileupload)){
			$cekvalid = $this->validate([
				'fileupload' => [
					'rules' => 'uploaded[fileupload]|max_size[fileupload,1024]|is_image[fileupload]|mime_in[fileupload,image/png,image/jpg,image/jpeg]',
					'errors' => [
						'uploaded' => 'File gambar harus dipilih.', //uploaded[fileupload]
						'max_size' => 'Ukuran gambar terlalu besar.',
						'is_image' => 'Yang anda pilih bukan gambar.',
						'mime_in' => 'Yang anda pilih bukan gambar.'
					] 
				]
			]);		
		}
		
		$cekvalid = $this->validate([
			'kodept' => [
				'rules' => 'required|min_length[6]|numeric',
				'errors' => [
					'required' => 'Kode perguruan tinggi harus diisi.',
					'min_length' => 'Kode perguruan tinggi harus 6 karakter.',
					'numeric' => 'Kode perguruan tinggi harus angka'
				] 
			]	
			
		]);
		
		if(!$cekvalid){			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{	
			
			$datalama = $this->msiakad_setting->getdata();
			if(!isset($fileupload)){		//if($fileupload->getError() == 4){
				$logopt = "logo.png";
			}else{
				//hapus file yang ada
				
				if($datalama->logopt != "logo.png" && strlen($datalama->logopt) > 5){
					if(file_exists("public/gambar/".$datalama->logopt)){
						unlink("public/gambar/".$datalama->logopt);
					}
				}
				$logopt = $fileupload->getRandomName();
				$fileupload->move('public/gambar',$logopt);
				//$logopt = $fileupload->getName();
				
			}	
			
			$kodept = $this->request->getVar('kodept');
			$datain = array("kodept"=>$kodept,
							"logopt"=>$logopt);			
			if(!$datalama){				
				$this->db->table($this->siakad_profil)->insert($datain);
				$ret['messages'] = "Data berhasil dimasukan";
			}else{
				$this->db->table($this->siakad_profil)->update($datain);
				$ret['messages'] = "Data berhasil diupdate";
			}			
			$ret['success'] = true;		
		}
		
		echo json_encode($ret);
	}
}
