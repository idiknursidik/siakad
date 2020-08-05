<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Profilept extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Profile PT PDDIKTI',
			'judul' => 'Profile PDDIKTI',
			'mn_feeder_a'=>true,
			'mn_profilept'=>true
		];
		return view('feeder/profilept',$data);
	}
	public function show()
	{
		$session 		= \Config\Services::session();
		$feeder_akun = $session->get("feeder_akun");
		
		$cekkoneksi = $this->mfeeder_ws->cekkoneksifeeder();
		if($cekkoneksi){
			echo $cekkoneksi;	
			exit();			
		}
		
		$dataws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetProfilPT','',false,'1','0');	
		if($dataws->error_code != 0){
			echo $dataws->error_desc;
			exit();
		}		
		$data = $this->mfeeder_data->getprofilept($dataws->data[0]->id_perguruan_tinggi);
		if(!$data){
			echo "<a class='btn btn-primary' id='ambilprofilpt' href='#' data-src='".base_url()."/feeder/profilept/inputdata'>Ambil data</a>";
		}else{
			echo "<a class='btn btn-primary' style='float:right' id='ambilprofilpt' href='#' data-src='".base_url()."/feeder/profilept/inputdata'>Update data</a>";
			echo "<table class='table'>";
			echo "<thead><tr><th colspan='2'>Info</th></tr></thead>";
			echo "<tbody>";
			foreach($data as $key=>$val){
				$key = explode("_",$key);
				$key = implode(" ",$key);
				echo "<tr>";
				echo "<th>{$key}</th><td>: {$val}</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
		}
		
	}
	public function inputdata(){
		$ret=array("success"=>false,"messages"=>array());
		//cek koneksi
		$cekkoneksi = $this->mfeeder_ws->cekkoneksifeeder();
		$error=false;
		if($cekkoneksi){
			$ret['messages'] = $cekkoneksi;
			$error=true;
		}
		if(!$error){
			$session 		= \Config\Services::session();
			$feeder_akun = $session->get("feeder_akun");
			$dataws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetProfilPT','',false,'1','0');
			$datain = $this->mfungsi->object_to_array($dataws->data[0]);
				
			$data = $this->mfeeder_data->getprofilept($dataws->data[0]->id_perguruan_tinggi);
			if(!$data){
				$query = $this->db->table('feeder_profilpt')->insert($datain);
				$ret['messages'] = "data berhasil dimasukan";
				$ret['success'] = true;
			}else{
				//update
				$query = $this->db->table('feeder_profilpt')->update($datain, array('id_perguruan_tinggi' => $dataws->data[0]->id_perguruan_tinggi));
				$ret['messages'] = "data berhasil diupdate";
				$ret['success'] = true;
			}
		}
		
        echo json_encode($ret);
		//return redirect()->to(base_url().'/feeder/profilept');
	}
	

}
