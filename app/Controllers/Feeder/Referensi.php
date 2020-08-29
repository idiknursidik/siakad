<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Referensi extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Data Referensi PDDIKTI',
			'judul' => 'Data Referensi PDDIKTI',
			'mn_referensi'=>true
		];
		return view('feeder/referensi',$data);
	}
	public function show()
	{
		$datareferensi = $this->mreferensi->getlistreferensi();
		
		echo "<table class='table table-hover'>";
		echo "<thead><tr><th width='1'>No</th><th>Table Referensi</th><th>Jumlah Data</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		$no=0;
		foreach($datareferensi as $value){
			$no++;
			$namatable 		= $value;
			$jumlah = $this->mreferensi->$value();
			$retjumlah = ($jumlah)?count($jumlah):"0";
			echo "<tr>";
			echo "<td>{$no}</td>";
			echo "<td>{$namatable}</td>";
			echo "<td>{$retjumlah}</td>";
			echo "<td><a href='#' name='ambildata_{$no}' data-src='".base_url()."/feeder/referensi/inputdata/{$namatable}'>Ambil data</a></td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function inputdata($act){
		$ret=array("success"=>false,"messages"=>array());
		//cek koneksi
		$cekkoneksi = $this->mfeeder_ws->cekkoneksifeeder();
		$error=false;
		if($cekkoneksi){
			$ret['messages'] = $cekkoneksi;
			$error=true;
		}
		if(!$act){
			$ret['messages'] = "Aksi Referensi tidak ada";
			$error=true;
		}
		if(!$error){
			$session 		= \Config\Services::session();
			$feeder_akun = $session->get("feeder_akun");
			$dataptws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetProfilPT','',false,'1','0');
			$dataptws = $this->mfungsi->object_to_array($dataptws->data[0]);
			
			$datareferensiws = $this->mfeeder_ws->getrecordset($feeder_akun->token,$act);
			//echo "<pre>";
			//print_r($datareferensiws);
			//echo "</pre>";
			//exit();			
			//hapus data dulu
			$this->db->table('ref_'.strtolower($act))->emptyTable();
			foreach($datareferensiws->data as $key=>$val){				
				$datain = $this->mfungsi->object_to_array($val);
				$query = $this->db->table('ref_'.strtolower($act))->insert($datain);
				$ret['messages'] = "Data berhasil dimasukan";
				$ret['success'] = true;				
			}
		}			
		echo json_encode($ret);
	}
}
