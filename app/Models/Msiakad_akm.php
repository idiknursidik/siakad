<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_akm extends Model
{
	
	
	protected $siakad_akm = 'siakad_akm';
	protected $feeder_akm = 'feeder_akm';
	protected $siakad_riwayatpendidikan = 'siakad_riwayatpendidikan';
	protected $siakad_mahasiswa = 'siakad_mahasiswa';
	protected $siakad_prodi = 'siakad_prodi';
	protected $ref_getjenjangpendidikan = 'ref_getjenjangpendidikan';
	
    public function getdata($id_akm=false,$nim=false,$semester=false,$kodept=false)
    {
		$akses = explode(",",session()->akses);
		$builder = $this->db->table("{$this->siakad_akm} a");
		$builder->join("{$this->siakad_riwayatpendidikan} b","a.nim = b.nim","left");
		$builder->join("{$this->siakad_mahasiswa} c","b.id_mahasiswa = c.id_mahasiswa","left");
		$builder->join("{$this->siakad_prodi} d","b.id_prodi = d.id_prodi","left");
		$builder->join("{$this->ref_getjenjangpendidikan} e","d.id_jenjang = e.id_jenjang_didik","left");
		$builder->select("a.*,b.id_periode_masuk,b.id_registrasi_mahasiswa,c.nama_mahasiswa,d.nama_prodi,e.nama_jenjang_didik");
		if($kodept){
			$builder->where("a.kodept",$kodept);
		}
		if($id_akm){
			$builder->where("a.id_akm",$id_akm);
		}
		if($nim){
			$builder->where("a.nim",$nim);
		}
		if($semester){
			$builder->where("a.id_semester",$semester);
		}
		$builder->orderBy("a.nim");
		//akses only
		$builder->whereIn("a.id_prodi",$akses);
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_akm || ($nim && $semester)){
				$ret = $data[0]; 
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getdatapddikti($id_semester=false,$nim=false,$kodept=false)
    {
		$builder = $this->db->table($this->feeder_akm);
		$builder->select("*");
		if($kodept){
			$builder->where("kode_perguruan_tinggi",$kodept);
		}
		if($id_semester){
			$builder->where("id_semester",$id_semester);
		}
		if($nim){
			$builder->where("nim",$nim);
		}
		
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_semester && $nim){
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
