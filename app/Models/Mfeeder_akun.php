<?php 
namespace App\Models;
use CodeIgniter\Model;

class Mfeeder_akun extends Model
{
	protected $feeder_akun = 'feeder_akun';
	
    public function getakun($kodept = false)
    {
		$builder = $this->db->table($this->feeder_akun);
		if($kodept){
			$builder->where("kodept",$kodept);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($kodept){
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
