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
		$data = array("1"=>"Administrator","2"=>"Admin Prodi");
		if($val){
			$ret = $data[$val];
		}else{
			$ret = $data;
		}
		return $ret;
	}
	public function getakunmahasiswa($id=false,$username=false,$kodept=false)
    {
		$builder = $this->db->table("{$this->siakad_akun_mahasiswa} a");
		$builder->join("{$this->siakad_riwayatpendidikan} b","a.nim = b.nim","left");
		$builder->join("{$this->siakad_mahasiswa} c","b.id_mahasiswa = c.id_mahasiswa","left");
		$builder->select("a.*,c.nama_mahasiswa");
		
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
