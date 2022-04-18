<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_kurikulummatakuliah extends Model
{
	
	
	protected $siakad_kurikulummatakuliah = 'siakad_kurikulummatakuliah';
	protected $siakad_matakuliah = 'siakad_matakuliah';
	protected $feeder_kurikulummatakuliah = 'feeder_kurikulummatakuliah';
	protected $siakad_kurikulum = 'siakad_kurikulum';
	
    public function getdata($id_kurikulummatakuliah=false,$id_kurikulum=false,$id_kurikulum_ws=false,$id_prodi_ws=false,$id_matkul_ws=false,$id_semester=false,$kodept=false)
    {
		$akses = explode(",",session()->akses);
		$builder = $this->db->table("{$this->siakad_kurikulummatakuliah} a");
		$builder->join("{$this->siakad_matakuliah} b","a.id_matakuliah = b.id_matakuliah","left");
		$builder->join("{$this->siakad_kurikulum} c","a.id_kurikulum = c.id_kurikulum","left");
		$builder->select("a.*,b.nama_matakuliah,c.nama_kurikulum");
		if($kodept){
			$builder->where("a.kodept",$kodept);
		}
		if($id_kurikulummatakuliah){
			$builder->where("a.id_kurikulummatakuliah",$id_kurikulummatakuliah);
		}
		if($id_kurikulum){
			$builder->where("a.id_kurikulum",$id_kurikulum);
		}
		if($id_kurikulum_ws){
			$builder->where("a.id_kurikulum_ws",$id_kurikulum_ws);
		}
		if($id_prodi_ws){
			$builder->where("a.id_prodi_ws",$id_prodi_ws);
		}
		if($id_matkul_ws){
			$builder->where("a.id_matkul_ws",$id_matkul_ws);
		}
		if($id_semester){
			$builder->where("a.id_semester",$id_semester);
		}
		//akses only
		$builder->whereIn("a.id_prodi",$akses);
		$builder->orderBy('a.id_semester','DESC');
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_kurikulummatakuliah || ($id_prodi_ws && $id_matkul_ws && $id_semester)){
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
