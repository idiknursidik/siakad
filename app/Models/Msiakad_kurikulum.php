<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_kurikulum extends Model
{
	
	
	protected $siakad_kurikulum = 'siakad_kurikulum';
	protected $feeder_kurikulum = 'feeder_kurikulum';
	
    public function getdata($id_kurikulum=false,$id_kurikulum_ws=false,$kodept=false)
    {
		$builder = $this->db->table($this->siakad_kurikulum);
		$builder->select("*");
		if($kodept){
			$builder->where("kodept",$kodept);
		}
		if($id_kurikulum){
			$builder->where("id_kurikulum",$id_kurikulum);
		}
		if($id_kurikulum_ws){
			$builder->where("id_kurikulum_ws",$id_kurikulum_ws);
		}
		
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_kurikulum || $id_kurikulum_ws){
				$ret = $data[0]; 
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getdatapddikti($id_kurikulum=false,$kodept=false)
    {
		$builder = $this->db->table($this->feeder_kurikulum);
		$builder->select("*");
		if($kodept){
			$builder->where("kode_perguruan_tinggi",$kodept);
		}
		if($id_kurikulum){
			$builder->where("id_kurikulum",$id_kurikulum);
		}
		
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_kurikulum){
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
