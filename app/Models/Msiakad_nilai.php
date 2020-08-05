<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_nilai extends Model
{
	
	
	protected $siakad_nilai = 'siakad_nilai';
	protected $feeder_nilai = 'feeder_nilai';
	
    public function getdata($id_nilai=false,$nim=false,$kode_matakuliah=false,$semester=false,$kodept=false)
    {
		$builder = $this->db->table($this->siakad_nilai);
		$builder->select("*");
		if($kodept){
			$builder->where("kodept",$kodept);
		}
		if($id_nilai){
			$builder->where("id_nilai",$id_nilai);
		}
		if($nim){
			$builder->where("nim",$nim);
		}
		if($kode_matakuliah){
			$builder->where("kode_matakuliah",$kode_matakuliah);
		}
		if($semester){
			$builder->where("semester",$semester);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_nilai || ($nim && $kode_matakuliah && $semester)){
				$ret = $data[0]; 
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getdatapddikti($id_matkul=false,$nim=false,$id_periode=false,$kodept=false)
    {
		$builder = $this->db->table($this->feeder_nilai);
		$builder->select("*");
		if($kodept){
			$builder->where("kode_perguruan_tinggi",$kodept);
		}
		if($id_matkul){
			$builder->where("id_matkul",$id_matkul);
		}
		if($nim){
			$builder->where("nim",$nim);
		}
		if($id_periode){
			$builder->where("id_periode",$id_periode);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_matkul && $nim && $id_periode){
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
