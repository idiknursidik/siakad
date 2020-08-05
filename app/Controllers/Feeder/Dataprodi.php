<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Dataprodi extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Data Prodi PDDIKTI',
			'judul' => 'Data Program Studi PDDIKTI',
			'mn_feeder_a'=>true,
			'mn_dataprodi'=>true
		];
		return view('feeder/dataprodi',$data);
	}
	public function show()
	{
		$cekkoneksi = $this->mfeeder_ws->cekkoneksifeeder();
		if($cekkoneksi){
			echo $cekkoneksi;	
			exit();			
		}
		$session 		= \Config\Services::session();
		$feeder_akun = $session->get("feeder_akun");
		//$token, $table, $filter, $order, $limit, $offset
		$dataptws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetProfilPT','',false,'1','0');
		if($dataptws->error_code != 0){
			echo $dataptws->error_desc;
			exit();
		}
		$dataprodiws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetProdi');
		
		$data = $this->mfeeder_data->getdataprodi(false,false,$dataptws->data[0]->id_perguruan_tinggi);
		if(!$data){
			echo "<a class='btn btn-primary' id='ambildataprodi' href='#' data-src='".base_url()."/feeder/dataprodi/inputdata'>Ambil data</a>";
		}else{
			echo "<a class='btn btn-primary' style='float:right' id='ambildataprodi' href='#' data-src='".base_url()."/feeder/dataprodi/inputdata'>Update data</a>";
			echo "<table class='table'>";
			echo "<thead><tr><th width='1'>No</th><th>Kode Prodi</th><th>Nama Prodi</th><th>Jenjang</th><th>Status</th></tr></thead>";
			echo "<tbody>";
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->kode_program_studi}</td>";
				echo "<td>{$val->nama_program_studi}</td>";
				echo "<td>{$val->nama_jenjang_pendidikan}</td>";
				echo "<td>{$val->status}</td>";
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
			$dataptws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetProfilPT','',false,'1','0');
			$dataprodiws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetProdi');		
			$dataptws = $this->mfungsi->object_to_array($dataptws->data[0]);
		
			foreach($dataprodiws->data as $key=>$val){
				$datain = $this->mfungsi->object_to_array($val);
				$datain['id_perguruan_tinggi'] = $dataptws['id_perguruan_tinggi'];
				$datain['kode_perguruan_tinggi'] = $dataptws['kode_perguruan_tinggi'];
				
				$cekdata = $this->mfeeder_data->getdataprodi($val->id_prodi);
				if(!$cekdata){
					$query = $this->db->table('feeder_dataprodi')->insert($datain);
					$ret['messages'] = "Data berhasil dimasukan";
					$ret['success'] = true;
				}else{
					//update
					$query = $this->db->table('feeder_dataprodi')->update($datain, array('id_prodi' => $val->id_prodi));
					$ret['messages'] = "Data berhasil diupdate";
					$ret['success'] = true;
				}
				
			}
		}			
		echo json_encode($ret);
	}
}
