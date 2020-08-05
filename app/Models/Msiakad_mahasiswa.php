<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_mahasiswa extends Model
{
	
	
	protected $siakad_mahasiswa = 'siakad_mahasiswa';
	protected $feeder_biodatamahasiswa = 'feeder_biodatamahasiswa';
	
    public function getdata($id_pendaftaran=false,$id_mahasiswa=false,$id_mahasiswa_ws=false,$nik=false,$kodept=false)
    {
		$builder = $this->db->table($this->siakad_mahasiswa);
		$builder->select("*");
		if($kodept){
			$builder->where("kodept",$kodept);
		}
		if($nik){
			$builder->where("nik",$nik);
		}
		if($id_mahasiswa){
			$builder->where("id_mahasiswa",$id_mahasiswa);
		}
		if($id_mahasiswa_ws){
			$builder->where("id_mahasiswa_ws",$id_mahasiswa_ws);
		}
		if($id_pendaftaran){
			$builder->where("id_pendaftaran",$id_pendaftaran);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_pendaftaran || $id_mahasiswa || $id_mahasiswa_ws || $nik){
				$ret = $data[0]; 
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getdatapddikti($id_mahasiswa=false,$kodept=false)
    {
		$builder = $this->db->table($this->feeder_biodatamahasiswa);
		$builder->select("*");
		if($kodept){
			$builder->where("kode_perguruan_tinggi",$kodept);
		}
		if($id_mahasiswa){
			$builder->where("id_mahasiswa",$id_mahasiswa);
		}
		
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_mahasiswa){
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
