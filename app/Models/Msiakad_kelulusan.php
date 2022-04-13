<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_kelulusan extends Model
{
	
	protected $siakad_riwayatpendidikan = "siakad_riwayatpendidikan";
	protected $siakad_lulusan = 'siakad_lulusan';
	protected $feeder_lulusan = 'feeder_lulusan';
	protected $siakad_mahasiswa = 'siakad_mahasiswa';
	protected $siakad_prodi = 'siakad_prodi';
	protected $ref_getjenjangpendidikan = 'ref_getjenjangpendidikan';
	protected $ref_getjeniskeluar = 'ref_getjeniskeluar';
	
    public function getdata($id_keluar=false,$id_mahasiswa=false,$kodept=false)
    {
		$akses = explode(",",session()->akses);
		$builder = $this->db->table("{$this->siakad_lulusan} a");
		$builder->join("{$this->siakad_riwayatpendidikan} b","a.nim = b.nim","left");
		$builder->join("{$this->siakad_mahasiswa} c","b.id_mahasiswa = c.id_mahasiswa","left");
		$builder->join("{$this->siakad_prodi} d","b.id_prodi = d.id_prodi","left");
		$builder->join("{$this->ref_getjenjangpendidikan} e","d.id_jenjang = e.id_jenjang_didik","left");
		$builder->join("{$this->ref_getjeniskeluar} f","a.id_jenis_keluar = f.id_jenis_keluar","left");
		$builder->select("a.*,b.id_periode_masuk,c.nama_mahasiswa,d.nama_prodi,e.nama_jenjang_didik,f.jenis_keluar");
		if($kodept){
			$builder->where("a.kodept",$kodept);
		}
		if($id_keluar){
			$builder->where("a.id_keluar",$id_keluar);
		}
		if($id_mahasiswa){
			$builder->where("b.id_mahasiswa",$id_mahasiswa);
		}
			//akses only
		$builder->whereIn("a.id_prodi",$akses);
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_keluar || $id_mahasiswa){
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
		$builder = $this->db->table($this->feeder_lulusan);
		$builder->select("*");
		if($kodept){
			$builder->where("kode_perguruan_tinggi",$kodept);
		}
		if($id_mahasiswa){
			$builder->where("id_mahasiswa",$id_mahasiswa); //ws_
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
