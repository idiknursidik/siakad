<?php 
namespace App\Models;
use CodeIgniter\Model;
 
class Mreferensi extends Model
{
	protected $GetJenjangPendidikan = "ref_getjenjangpendidikan";
	protected $GetPekerjaan			= "ref_getpekerjaan";
	protected $GetPenghasilan		= "ref_getpenghasilan";
	protected $GetAgama				= "ref_getagama";
	protected $GetAlatTransportasi	= "ref_getalattransportasi";
	protected $GetNegara			= "ref_getnegara";
	protected $GetWilayah			= "ref_getwilayah";
	protected $GetSemester			= "ref_getsemester";
	
	public function getlistreferensi(){
		$data =array("GetJenjangPendidikan",
					 "GetPekerjaan",
					 "GetPenghasilan",
					 "GetAgama",
					 "GetAlatTransportasi",
					 "GetNegara",
					 "GetWilayah",
					 "GetSemester");
		return $data;
	}
	public function GetJenjangPendidikan($id_jenjang_didik=false){
		$builder = $this->db->table($this->GetJenjangPendidikan);
		if($id_jenjang_didik){
			$builder->where("id_jenjang_didik",$id_jenjang_didik);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_jenjang_didik){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}
	}
	public function GetPekerjaan($id_pekerjaan=false){
		$builder = $this->db->table($this->GetPekerjaan);
		if($id_pekerjaan){
			$builder->where("id_pekerjaan",$id_pekerjaan);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_pekerjaan){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}
	}
	public function GetPenghasilan($id_penghasilan=false){
		$builder = $this->db->table($this->GetPenghasilan);
		if($id_penghasilan){
			$builder->where("id_penghasilan",$id_penghasilan);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_penghasilan){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}
	}
	public function GetAgama($id_agama=false){
		$builder = $this->db->table($this->GetAgama);
		if($id_agama){
			$builder->where("id_agama",$id_agama);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_agama){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}
	}
	public function GetAlatTransportasi($id_alat_transportasi=false){
		$builder = $this->db->table($this->GetAlatTransportasi);
		if($id_alat_transportasi){
			$builder->where("id_alat_transportasi",$id_alat_transportasi);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_alat_transportasi){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}
	}
	public function GetNegara($id_negara=false){
		$builder = $this->db->table($this->GetNegara);
		if($id_negara){
			$builder->where("id_negara",$id_negara);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_negara){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}
	}
	public function GetWilayah($id_wilayah=false){
		$builder = $this->db->table($this->GetWilayah);
		if($id_wilayah){
			$builder->where("id_wilayah",$id_wilayah);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_wilayah){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}
	}
	public function GetSemester($id_semester=false){
		$builder = $this->db->table($this->GetSemester);
		if($id_semester){
			$builder->where("id_semester",$id_semester);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_semester){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}
	}
	public function GetJenisMatakuliah($val=false){
		$data = array("A"=>"Wajib","B"=>"Pilihan","C"=>"Wajib Peminatan","D"=>"Pilihan Peminatan","S"=>"Tugas akhir/Skripsi/Tesis/Disertasi");
		if($val){
			$ret = $data[$val];
		}else{
			$ret=$data;
		}
		return $ret;
	}

}
