<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_mahasiswadaftar extends Model
{
	
	
	protected $siakad_mahasiswa_mendaftar = 'siakad_mahasiswa_mendaftar';
	protected $ref_getjenispendaftaran	= 'ref_getjenispendaftaran';
    public function getdata($id=false,$kodept=false)
    {
		$akses = explode(",",session()->akses);
		$builder = $this->db->table("{$this->siakad_mahasiswa_mendaftar} a");
		$builder->join("{$this->ref_getjenispendaftaran} b","a.id_jenis_daftar=b.id_jenis_daftar","left");
		$builder->select("a.*,b.nama_jenis_daftar");
		if($kodept){
			$builder->where("a.kodept",$kodept);
		}
		if($id){
			$builder->where("a.id",$id);
		}
		//akses only
		$builder->whereIn("a.id_prodi",$akses);
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id){
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
