<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_akun extends Model
{
	protected $siakad_akun = 'siakad_akun';
	protected $siakad_riwayatpendidikan = 'siakad_riwayatpendidikan';
	protected $siakad_akun_mahasiswa = 'siakad_akun_mahasiswa';
	protected $siakad_mahasiswa = 'siakad_mahasiswa';
	protected $siakad_level = 'siakad_level';
	protected $siakad_akun_dosen = 'siakad_akun_dosen';
	protected $siakad_dosen = 'siakad_dosen';
	protected $siakad_prodi = 'siakad_prodi';
	protected $ref_getjenjangpendidikan = 'ref_getjenjangpendidikan';
	
    public function getakun($id=false,$username=false,$kodept=false)
    {
		$builder = $this->db->table("{$this->siakad_akun}");
		if($id){
			$builder->where("id",$id);
		}
		if($username){
			$builder->where("username",$username);
		}
		if($kodept){
			$builder->where("kodept",$kodept);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id || $username){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function leveluser($val=false){
		$data = array("1"=>"Administrator","2"=>"Admin Prodi","3"=>"Keuangan","4"=>"Kepegawaian");
		if($val){
			$ret = $data[$val];
		}else{
			$ret = $data;
		}
		return $ret;
	}
	public function getakunmahasiswa($id=false,$username=false,$kodept=false,$id_mahasiswa=false)
    {
		$builder = $this->db->table("{$this->siakad_akun_mahasiswa} a");
		$builder->join("{$this->siakad_riwayatpendidikan} b","a.nim = b.nim","left");
		$builder->join("{$this->siakad_mahasiswa} c","b.id_mahasiswa = c.id_mahasiswa","left");
		$builder->join("{$this->siakad_prodi} d","b.id_prodi = d.id_prodi","left");
		$builder->join("{$this->ref_getjenjangpendidikan} e","d.id_jenjang = e.id_jenjang_didik","left");
		$builder->select("a.*,b.id_periode_masuk,c.id_mahasiswa,c.nama_mahasiswa,d.nama_prodi,e.nama_jenjang_didik");
		
		if($id){
			$builder->where("a.id",$id);
		}
		if($username){
			$builder->where("a.username",$username);
		}
		if($kodept){
			$builder->where("a.kodept",$kodept);
		}
		if($id_mahasiswa){
			$builder->where("a.id_mahasiswa",$id_mahasiswa);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id || $username || $id_mahasiswa){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getakundosen($id=false,$username=false,$kodept=false)
    {
		$builder = $this->db->table("{$this->siakad_akun_dosen} a");
		$builder->join("{$this->siakad_dosen} b","a.id_dosen = b.id_dosen","left");
		$builder->select("a.*,b.nama_dosen");
		
		if($id){
			$builder->where("a.id",$id);
		}
		if($username){
			$builder->where("a.username",$username);
		}
		if($kodept){
			$builder->where("a.kodept",$kodept);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id || $username){
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
