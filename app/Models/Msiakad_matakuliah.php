<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_matakuliah extends Model
{
	
	
	protected $siakad_matakuliah = 'siakad_matakuliah';
	protected $feeder_matakuliah = 'feeder_matakuliah';
	
    public function getdata($id_matakuliah=false,$id_matakuliah_ws=false,$kode_matakuliah=false,$kodept=false)
    {
		$akses = explode(",",session()->akses);
		$builder = $this->db->table($this->siakad_matakuliah);
		$builder->select("*");
		if($kodept){
			$builder->where("kodept",$kodept);
		}
		if($id_matakuliah){
			$builder->where("id_matakuliah",$id_matakuliah);
		}
		if($id_matakuliah_ws){
			$builder->where("id_matkul_ws",$id_matakuliah_ws);
		}
		if($kode_matakuliah){
			$builder->where("kode_matakuliah",$kode_matakuliah);
		}
		//akses only
		$builder->whereIn("id_prodi",$akses);
		$builder->orderBy('kode_matakuliah', 'DESC');
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_matakuliah || $kode_matakuliah || $id_matakuliah_ws){
				$ret = $data[0]; 
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getdatapddikti($id_matkul=false,$kodept=false)
    {
		$builder = $this->db->table($this->feeder_matakuliah);
		$builder->select("*");
		if($kodept){
			$builder->where("kode_perguruan_tinggi",$kodept);
		}
		if($id_matkul){
			$builder->where("id_matkul",$id_matkul);
		}
		
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_matkul){
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
