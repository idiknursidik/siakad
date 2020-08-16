<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_kelas extends Model
{
	
	
	protected $siakad_kelas = 'siakad_kelas';
	protected $feeder_kelas = 'feeder_kelas';
	
    public function getdata($id_kelas=false,$id_kelas_kuliah_ws=false,$kodept=false)
    {
		$akses = explode(",",session()->akses);
		$builder = $this->db->table($this->siakad_kelas);
		$builder->select("*");
		if($kodept){
			$builder->where("kodept",$kodept);
		}
		if($id_kelas){
			$builder->where("id_kelas",$id_kelas);
		}
		if($id_kelas_kuliah_ws){
			$builder->where("id_kelas_kuliah_ws",$id_kelas_kuliah_ws);
		}
		//akses only
		$builder->whereIn("id_prodi",$akses);
		$builder->orderBy('id_kelas', 'DESC');
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_kelas || $id_kelas_kuliah_ws){
				$ret = $data[0]; 
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getdatapddikti($id_kelas=false,$kodept=false)
    {
		$builder = $this->db->table($this->feeder_kelas);
		$builder->select("*");
		if($kodept){
			$builder->where("kode_perguruan_tinggi",$kodept);
		}
		if($id_kelas){
			$builder->where("id_kelas",$id_kelas);
		}
		
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_kelas){
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
