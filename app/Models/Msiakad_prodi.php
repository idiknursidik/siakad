<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_prodi extends Model
{
	
	
	protected $siakad_prodi = 'siakad_prodi';
	protected $feeder_dataprodi = 'feeder_dataprodi';
	protected $ref_getjenjangpendidikan = 'ref_getjenjangpendidikan';
    public function getdata($id_prodi=false,$id_prodi_ws=false,$kodept=false,$status="A",$kode_prodi=false)
    {
		$builder = $this->db->table("{$this->siakad_prodi} a");
		$builder->join("{$this->ref_getjenjangpendidikan} b", 'a.id_jenjang = b.id_jenjang_didik',"left");
		$builder->select("a.*,b.nama_jenjang_didik");
		if($kodept){
			$builder->where("a.kodept",$kodept);
		}
		if($id_prodi){
			$builder->where("a.id_prodi",$id_prodi);
		}
		if($id_prodi_ws){
			$builder->where("a.id_prodi_ws",$id_prodi_ws);
		}
		if($id_prodi_ws){
			$builder->where("a.id_prodi_ws",$id_prodi_ws);
		}
		if($kode_prodi){
			$builder->where("a.kode_prodi",$kode_prodi);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_prodi || $id_prodi_ws || $kode_prodi){
				$ret = $data[0]; 
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getdatapddikti($id_prodi_ws=false,$kodept=false)
    {
		$builder = $this->db->table($this->feeder_dataprodi);
		$builder->select("*");
		if($kodept){
			$builder->where("kode_perguruan_tinggi",$kodept);
		}
		if($id_prodi_ws){
			$builder->where("id_prodi",$id_prodi_ws);
		}
		
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_prodi_ws){
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
