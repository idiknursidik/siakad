<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_dosenmengajar extends Model
{
	
	
	protected $siakad_dosenmengajar = 'siakad_dosenmengajar';
	protected $feeder_dosenmengajar = 'feeder_dosenmengajar';
	protected $siakad_kelas = 'siakad_kelas';
	
    public function getdata($id_aktivitas_mengajar=false,$id_aktivitas_mengajar_ws=false,$kodept=false,$id_kelas=false)
    {
		$builder = $this->db->table("{$this->siakad_dosenmengajar} a");
		$builder->join("{$this->siakad_kelas} b","a.id_kelas=b.id_kelas","left");
		$builder->select("a.*,b.nama_kelas_kuliah,b.id_semester,b.kode_mata_kuliah");
		if($kodept){
			$builder->where("a.kodept",$kodept);
		}
		if($id_aktivitas_mengajar){
			$builder->where("a.id_aktivitas_mengajar",$id_aktivitas_mengajar);
		}
		if($id_aktivitas_mengajar_ws){
			$builder->where("a.id_aktivitas_mengajar_ws",$id_aktivitas_mengajar_ws);
		}
		if($id_kelas){
			$builder->where("a.id_kelas",$id_kelas);
		}
		//akses only
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_aktivitas_mengajar || $id_aktivitas_mengajar_ws){
				$ret = $data[0]; 
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getdatapddikti($id_aktivitas_mengajar_ws=false,$kodept=false)
    {
		$builder = $this->db->table($this->feeder_dosenmengajar);
		$builder->select("*");
		if($kodept){
			$builder->where("kode_perguruan_tinggi",$kodept);
		}
		if($id_aktivitas_mengajar_ws){
			$builder->where("id_aktivitas_mengajar_ws",$id_aktivitas_mengajar_ws);
		}
		
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_aktivitas_mengajar_ws){
				$ret = $data[0]; 
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
}
