<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_kelas extends Model
{
	
	
	protected $siakad_kelas = 'siakad_kelas';
	protected $siakad_matakuliah = 'siakad_matakuliah';
	protected $siakad_prodi = 'siakad_prodi';
	protected $siakad_kurikulummatakuliah = 'siakad_kurikulummatakuliah';
	protected $siakad_kurikulum = 'siakad_kurikulum';
	protected $feeder_kelas = 'feeder_kelas';
	protected $ref_getjenjangpendidikan = 'ref_getjenjangpendidikan';
	
    public function getdata($id_kelas=false,$id_kelas_kuliah_ws=false,$periode=false,$kodept=false)
    {
		$akses = explode(",",session()->akses);
		$builder = $this->db->table("{$this->siakad_kelas} a");
		$builder->join("{$this->siakad_kurikulummatakuliah} b","a.id_matakuliah = b.id_matakuliah AND a.id_semester = b.id_semester AND a.id_prodi = b.id_prodi","left");
		$builder->join("{$this->siakad_kurikulum} c","b.id_kurikulum = c.id_kurikulum","left");
		$builder->join("{$this->siakad_matakuliah} d","a.id_matakuliah = d.id_matakuliah","left");
		$builder->join("{$this->siakad_prodi} e","a.id_prodi = e.id_prodi","left");
		$builder->join("{$this->ref_getjenjangpendidikan} f", 'e.id_jenjang = f.id_jenjang_didik',"left");
		$builder->select("a.*,b.semester,c.nama_kurikulum,d.nama_matakuliah,e.nama_prodi,f.nama_jenjang_didik");
		if($kodept){
			$builder->where("a.kodept",$kodept);
		}
		if($periode){
			$builder->where("a.id_semester",$periode);
		}
		if($id_kelas){
			$builder->where("a.id_kelas",$id_kelas);
		}
		if($id_kelas_kuliah_ws){
			$builder->where("a.id_kelas_kuliah_ws",$id_kelas_kuliah_ws);
		}
		//akses only
		$builder->whereIn("a.id_prodi",$akses);
		$builder->orderBy('a.id_kelas', 'DESC');
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_kelas || $id_kelas_kuliah_ws){
				$ret = $data[0]; 
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getdatapddikti($id_kelas=false,$kodept=false)
    {
		$builder = $this->db->table($this->feeder_kelas);
		$builder->select("*");
		if($kodept){
			$builder->where("kode_perguruan_tinggi",$kodept);
		}
		if($id_kelas){
			$builder->where("id_kelas",$id_kelas);
		}
		
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_kelas){
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
