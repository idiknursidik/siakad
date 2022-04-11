<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_kurikulum extends Model
{
	
	
	protected $siakad_kurikulum = 'siakad_kurikulum';
	protected $siakad_prodi = 'siakad_prodi';
	protected $feeder_kurikulum = 'feeder_kurikulum';
	
    public function getdata($id_kurikulum=false,$id_kurikulum_ws=false,$kodept=false)
    {
		$akses = explode(",",session()->akses);
		$builder = $this->db->table("{$this->siakad_kurikulum} a");
		$builder->join("{$this->siakad_prodi} b","a.id_prodi_ws = b.id_prodi_ws");
		$builder->select("a.*,b.*");
		if($kodept){
			$builder->where("a.kodept",$kodept);
		}
		if($id_kurikulum){
			$builder->where("a.id_kurikulum",$id_kurikulum);
		}
		if($id_kurikulum_ws){
			$builder->where("a.id_kurikulum_ws",$id_kurikulum_ws);
		}
		//akses only
		$builder->whereIn("a.id_prodi",$akses);
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
