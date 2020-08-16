<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_riwayatpendidikan extends Model
{
	
	
	protected $siakad_riwayatpendidikan = 'siakad_riwayatpendidikan';
	protected $feeder_riwayatpendidikan = 'feeder_riwayatpendidikan';
	
    public function getdata($id_riwayatpendidikan=false,$id_registrasi_mahasiswa=false,$kodept=false)
    {
		$akses = explode(",",session()->akses);
		$builder = $this->db->table($this->siakad_riwayatpendidikan);
		$builder->select("*");
		if($kodept){
			$builder->where("kodept",$kodept);
		}
		
		if($id_riwayatpendidikan){
			$builder->where("id_riwayatpendidikan",$id_riwayatpendidikan);
		}
		if($id_registrasi_mahasiswa){
			$builder->where("id_registrasi_mahasiswa",$id_registrasi_mahasiswa);
		}
		//akses only
		$builder->whereIn("id_prodi",$akses);
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_riwayatpendidikan || $id_registrasi_mahasiswa){
				$ret = $data[0]; 
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getdatapddikti($id_riwayatpendidikan=false,$kodept=false)
    {
		$builder = $this->db->table($this->feeder_riwayatpendidikan);
		$builder->select("*");
		if($kodept){
			$builder->where("kode_perguruan_tinggi",$kodept);
		}
		if($id_riwayatpendidikan){
			$builder->where("id_riwayatpendidikan",$id_riwayatpendidikan);
		}
		
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_riwayatpendidikan){
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
