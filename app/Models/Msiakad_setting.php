<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_setting extends Model
{
	
	function __construct()
    {
		parent::__construct();
		$this->mfeeder_data	= new Mfeeder_data();
    }
	
	protected $siakad_profil = 'siakad_profil';
	
    public function getdata($kodept=false)
    {
		$builder = $this->db->table($this->siakad_profil);
		if($kodept){
			$builder->where("kodept",$kodept);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			$ret = $data[0];
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getprofile(){
		$data = $this->mfeeder_data->getprofilept(false,$this->getdata()->kodept);
		if($data){
			return $data;
		}else{
			return FALSE;
		}
	}
}
