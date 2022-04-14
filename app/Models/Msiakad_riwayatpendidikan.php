<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_riwayatpendidikan extends Model
{
	
	
	protected $siakad_riwayatpendidikan = 'siakad_riwayatpendidikan';
	protected $siakad_mahasiswa = 'siakad_mahasiswa';
	protected $feeder_riwayatpendidikan = 'feeder_riwayatpendidikan';
	protected $ref_getjenispendaftaran = 'ref_getjenispendaftaran';
	protected $siakad_prodi = 'siakad_prodi';
	protected $ref_getjenjangpendidikan = 'ref_getjenjangpendidikan';
	
	
    public function getdata($id_riwayatpendidikan=false,$id_mahasiswa=false,$kodept=false,$id_jenis_keluar=false,$nim=false,$id_prodi=false,$angkatan=false)
    {
		$akses = explode(",",session()->akses);
		$builder = $this->db->table("{$this->siakad_riwayatpendidikan} a");
		$builder->join("{$this->siakad_mahasiswa} b","a.id_mahasiswa = b.id_mahasiswa");
		$builder->join("{$this->ref_getjenispendaftaran} c","a.id_jenis_daftar = c.id_jenis_daftar");
		$builder->join("{$this->siakad_prodi} d","a.id_prodi = d.id_prodi");
		$builder->join("{$this->ref_getjenjangpendidikan} e","d.id_jenjang = e.id_jenjang_didik");
		
		$builder->select("a.*,b.nama_mahasiswa,c.nama_jenis_daftar,d.nama_prodi,e.nama_jenjang_didik");
		if($kodept){
			$builder->where("a.kodept",$kodept);
		}
		
		if($id_riwayatpendidikan){
			$builder->where("a.id_riwayatpendidikan",$id_riwayatpendidikan);
		}
		
		if($id_jenis_keluar){
			$builder->whereIn("a.id_jenis_keluar",$id_jenis_keluar);
		}
		if($nim){
			$builder->where("a.nim",$nim);
		}
		if($id_prodi){
			$builder->where("a.id_prodi",$id_prodi);
		}
		if($id_mahasiswa){
			$builder->where("a.id_mahasiswa",$id_mahasiswa);
		}
		if($angkatan){
			$builder->where("SUBSTR(a.id_periode_masuk,1,4)",$angkatan);
		}
		//akses only
		$builder->whereIn("a.id_prodi",$akses);
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_riwayatpendidikan || $nim){
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
