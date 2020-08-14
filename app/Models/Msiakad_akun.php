<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_akun extends Model
{
	protected $siakad_akun = 'siakad_akun';
	protected $siakad_level = 'siakad_level';
	
    public function getakun($id=false,$kodept = false)
    {
		$builder = $this->db->table("{$this->siakad_akun}");
		if($id){
			$builder->where("id",$id);
		}
		if($kodept){
			$builder->where("kodept",$kodept);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function leveluser($val=false){
		$data = array("1"=>"Administrator","2"=>"Admin Prodi");
		if($val){
			$ret = $data[$val];
		}else{
			$ret = $data;
		}
		return $ret;
	}
}
