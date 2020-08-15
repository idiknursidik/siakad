<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_kurikulummatakuliah extends Model
{
	
	
	protected $siakad_kurikulummatakuliah = 'siakad_kurikulummatakuliah';
	protected $feeder_kurikulummatakuliah = 'feeder_kurikulummatakuliah';
	
    public function getdata($id_kurikulummatakuliah=false,$id_kurikulum=false,$id_kurikulum_ws=false,$id_prodi_ws=false,$id_matkul_ws=false,$id_semester=false,$kodept=false)
    {
		$akses = explode(",",session()->akses);
		$builder = $this->db->table($this->siakad_kurikulummatakuliah);
		$builder->select("*");
		if($kodept){
			$builder->where("kodept",$kodept);
		}
		if($id_kurikulummatakuliah){
			$builder->where("id_kurikulummatakuliah",$id_kurikulummatakuliah);
		}
		if($id_kurikulum){
			$builder->where("id_kurikulum",$id_kurikulum);
		}
		if($id_kurikulum_ws){
			$builder->where("id_kurikulum_ws",$id_kurikulum_ws);
		}
		if($id_prodi_ws){
			$builder->where("id_prodi_ws",$id_prodi_ws);
		}
		if($id_matkul_ws){
			$builder->where("id_matkul_ws",$id_matkul_ws);
		}
		if($id_semester){
			$builder->where("id_semester",$id_semester);
		}
		//akses only
		$builder->whereIn("id_prodi",$akses);
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_kurikulummatakuliah || ($id_kurikulum_ws && $id_prodi_ws && $id_matkul_ws && $id_semester)){
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
		$builder = $this->db->table($this->feeder_kurikulummatakuliah);
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
			return $data;
		}else{
			return FALSE;
		}		
	}
}
