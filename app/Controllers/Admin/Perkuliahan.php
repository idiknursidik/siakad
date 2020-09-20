<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Perkuliahan extends BaseController
{
	
	protected $siakad_perkuliahan = 'siakad_perkuliahan';
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
			'title' => 'Setting Data',
			'judul' => 'Setting Perkuliahan',
			'mn_setting'=>true,
			'mn_setting_perkuliahan'=>true
			
		];
		return view('admin/perkuliahan',$data);
	}
	public function form()
	{
		$data = $this->msiakad_setting->setperkuliahan();
		if($data){
			$semester_aktif = (strlen($data->semester_aktif) > 0)?$data->semester_aktif:"";
			$status = $data->status;
		}else{
			$semester_aktif = "";
			$status = "";
		}
		
		echo "<form method='post' id='form_perkuliahan' action='".base_url()."/admin/perkuliahan/simpan' class='d-inline'>";
		echo csrf_field();
		echo "<div class='row'>";
			echo "<div class='col-7'>";
				echo "<div class='input-group mb-3'>";
						echo "<div class='input-group-prepend'>";
							echo "<span class='input-group-text'>Semester Aktif</span>";
						echo "</div>";
						echo "<select type='text' class='form-control' name='semester_aktif'>";				
							for($tahun=date('Y')-1; $tahun<=date("Y"); $tahun++){
								foreach(array("1","2") as $value){
									$semester = $tahun.$value;
									echo "<option value='{$semester}'";
									if($semester_aktif == $semester) echo " selected='selected'";
									echo ">{$semester}</option>";
								}
							}
						echo "</select>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-3'>";
				echo "<div class='input-group'>";
					echo "<select type='text' class='form-control' name='status'>";		
						foreach(array("Y"=>"Aktif","N"=>"Tidak Aktif") as $key=>$val){
							echo "<option value='{$key}'";
							if($status == $key) echo " selected='selected'";
							echo ">{$val}</option>";
						}
					echo "</select>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "<hr><button type='submit' name='kirim' id='btnSubmit_form_perkuliahan' class='btn bg-primary'>Simpan data</button>";
		echo "</form>";		
	}
	public function simpan(){
		
		$ret=array("success"=>false,"messages"=>array());
		$validation =  \Config\Services::validation();
		$datalama = $this->msiakad_setting->setperkuliahan();
		$semester_aktif	= $this->request->getVar("semester_aktif");
		$status = $this->request->getVar("status");
		$cekvalid = $this->validate([
			'semester_aktif' => [
				'rules' => 'required|min_length[5]|numeric',
				'errors' => [
					'required' => 'Semester harus diisi.',
					'min_length' => 'Semester harus 5 karakter.',
					'numeric' => 'Semester harus angka'
				] 
			]	
			
		]);
		
		if(!$cekvalid){			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{	
			
			$datain = array("semester_aktif"=>$semester_aktif,
							"status"=>$status);			
			if(!$datalama){
				$datain['date_inserted'] = date("Y-m-d H:i:s");
				$this->db->table($this->siakad_perkuliahan)->insert($datain);
				$ret['messages'] = "Data berhasil dimasukan";
			}else{
				$datain['date_updated'] = date("Y-m-d H:i:s");
				$this->db->table($this->siakad_perkuliahan)->update($datain);
				$ret['messages'] = "Data berhasil diupdate";
			}			
			$ret['success'] = true;		
		}
		
		echo json_encode($ret);
	}
}
