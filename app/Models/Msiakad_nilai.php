<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_nilai extends Model
{
	
	
	protected $siakad_nilai = 'siakad_nilai';
	protected $siakad_mahasiswa = 'siakad_mahasiswa';
	protected $siakad_riwayatpendidikan = 'siakad_riwayatpendidikan';
	protected $siakad_prodi = "siakad_prodi";
	protected $ref_getjenjangpendidikan = 'ref_getjenjangpendidikan';
	
	protected $feeder_nilai = 'feeder_nilai';
	
    public function getdata($id_nilai=false,$nim=false,$kode_matakuliah=false,$semester=false,$id_kelas=false,$kodept=false)
    {
		$akses = explode(",",session()->akses);
		$builder = $this->db->table("{$this->siakad_nilai} a");
		$builder->join("{$this->siakad_riwayatpendidikan} b","a.nim = b.nim","left");
		$builder->join("{$this->siakad_mahasiswa} c","b.id_mahasiswa = c.id_mahasiswa","left");
		$builder->join("{$this->siakad_prodi} d","b.id_prodi = d.id_prodi","left");
		$builder->join("{$this->ref_getjenjangpendidikan} e","d.id_jenjang = e.id_jenjang_didik","left");
		$builder->select("a.*,b.id_periode_masuk,c.nama_mahasiswa,d.nama_prodi,e.nama_jenjang_didik");
		if($kodept){
			$builder->where("a.kodept",$kodept);
		}
		if($id_nilai){
			$builder->where("a.id_nilai",$id_nilai);
		}
		if($nim){
			$builder->where("a.nim",$nim);
		}
		if($kode_matakuliah){
			$builder->where("a.kode_matakuliah",$kode_matakuliah);
		}
		if($semester){
			$builder->where("a.semester",$semester);
		}
		if($id_kelas){
			$builder->where("a.id_kelas",$id_kelas);
		}
		//akses only
		$builder->whereIn("a.id_prodi",$akses);
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
