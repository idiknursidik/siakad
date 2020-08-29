<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_riwayatpendidikan extends Model
{
	
	
	protected $siakad_riwayatpendidikan = 'siakad_riwayatpendidikan';
	protected $siakad_mahasiswa = 'siakad_mahasiswa';
	protected $feeder_riwayatpendidikan = 'feeder_riwayatpendidikan';
	
    public function getdata($id_riwayatpendidikan=false,$id_registrasi_mahasiswa=false,$kodept=false,$id_jenis_keluar=false,$nim=false)
    {
		$akses = explode(",",session()->akses);
		$builder = $this->db->table("{$this->siakad_riwayatpendidikan} a");
		$builder->join("{$this->siakad_mahasiswa} b","a.id_mahasiswa = b.id_mahasiswa");
		$builder->select("a.*,b.nama_mahasiswa");
		if($kodept){
			$builder->where("a.kodept",$kodept);
		}
		
		if($id_riwayatpendidikan){
			$builder->where("a.id_riwayatpendidikan",$id_riwayatpendidikan);
		}
		if($id_registrasi_mahasiswa){
			$builder->where("a.id_registrasi_mahasiswa",$id_registrasi_mahasiswa);
		}
		if($id_jenis_keluar){
			$builder->whereIn("a.id_jenis_keluar",$id_jenis_keluar);
		}
		if($nim){
			$builder->where("a.nim",$nim);
		}
		//akses only
		$builder->whereIn("a.id_prodi",$akses);
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_riwayatpendidikan || $id_registrasi_mahasiswa || $nim){
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
