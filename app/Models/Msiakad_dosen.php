<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_dosen extends Model
{
	
	
	protected $siakad_dosen = 'siakad_dosen';
	protected $feeder_dosen = 'feeder_dosen';
	
    public function getdata($id_dosen=false,$id_dosen_ws=false,$kodept=false)
    {
		$builder = $this->db->table("{$this->siakad_dosen} a");
		
		if($kodept){
			$builder->where("a.kodept",$kodept);
		}
		if($id_dosen){
			$builder->where("a.id_dosen",$id_dosen);
		}
		if($id_dosen_ws){
			$builder->where("a.id_dosen_ws",$id_dosen_ws);
		}
		
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_dosen || $id_dosen_ws){
				$ret = $data[0]; 
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getdatapddikti($id_dosen=false,$kodept=false)
    {
		$builder = $this->db->table($this->feeder_dosen);
		$builder->select("*");
		if($kodept){
			$builder->where("kode_perguruan_tinggi",$kodept);
		}
		if($id_dosen){
			$builder->where("id_dosen",$id_dosen);
		}
		
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_dosen){
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
