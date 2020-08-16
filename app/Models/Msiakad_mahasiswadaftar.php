<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_mahasiswadaftar extends Model
{
	
	
	protected $siakad_mahasiswa_mendaftar = 'siakad_mahasiswa_mendaftar';
	
    public function getdata($id=false,$kodept=false)
    {
		$akses = explode(",",session()->akses);
		$builder = $this->db->table($this->siakad_mahasiswa_mendaftar);
		$builder->select("*");
		if($kodept){
			$builder->where("kodept",$kodept);
		}
		if($id){
			$builder->where("id",$id);
		}
		//akses only
		$builder->whereIn("id_prodi",$akses);
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
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
	
}
