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
	protected $GetJenisKeluar		= "ref_getjeniskeluar";
	protected $GetJenisEvaluasi		= "ref_getjenisevaluasi";
	protected $GetKebutuhanKhusus	= "ref_getkebutuhankhusus";
	protected $GetStatusMahasiswa	= "ref_getstatusmahasiswa";
	protected $GetJalurMasuk		= "ref_getjalurmasuk";
	protected $GetJenisPendaftaran	= "ref_getjenispendaftaran";
	protected $GetPembiayaan		= "ref_getpembiayaan";
	
	public function getlistreferensi(){
		$data =array("GetJenjangPendidikan",
					 "GetPekerjaan",
					 "GetPenghasilan",
					 "GetAgama",
					 "GetAlatTransportasi",
					 "GetNegara",
					 "GetWilayah",
					 "GetSemester",
					 "GetJenisKeluar",
					 "GetJenisEvaluasi",
					 "GetKebutuhanKhusus",
					 "GetStatusMahasiswa",
					 "GetJalurMasuk",
					 "GetJenisPendaftaran",
					 "GetPembiayaan");
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
	public function GetJenisKeluar($id_jenis_keluar=false){
		$builder = $this->db->table($this->GetJenisKeluar);
		if($id_jenis_keluar){
			$builder->where("id_jenis_keluar",$id_jenis_keluar);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_jenis_keluar){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}
	}
	public function GetJenisEvaluasi($id_jenis_evaluasi=false){
		$builder = $this->db->table($this->GetJenisEvaluasi);
		if($id_jenis_evaluasi){
			$builder->where("id_jenis_evaluasi",$id_jenis_evaluasi);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_jenis_evaluasi){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}
	}
	public function GetKebutuhanKhusus($id_kebutuhan_khusus=false){
		$builder = $this->db->table($this->GetKebutuhanKhusus);
		if($id_kebutuhan_khusus){
			$builder->where("id_kebutuhan_khusus",$id_kebutuhan_khusus);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_kebutuhan_khusus){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}
	}
	public function GetStatusMahasiswa($id_status_mahasiswa=false){
		$builder = $this->db->table($this->GetStatusMahasiswa);
		if($id_status_mahasiswa){
			$builder->where("id_status_mahasiswa",$id_status_mahasiswa);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_status_mahasiswa){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}
	}
	public function GetJalurMasuk($id_jalur_masuk=false){
		$builder = $this->db->table($this->GetJalurMasuk);
		if($id_jalur_masuk){
			$builder->where("id_jalur_masuk",$id_jalur_masuk);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_jalur_masuk){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}
	}
	public function GetJenisPendaftaran($id_jenis_daftar=false){
		$builder = $this->db->table($this->GetJenisPendaftaran);
		if($id_jenis_daftar){
			$builder->where("id_jenis_daftar",$id_jenis_daftar);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_jenis_daftar){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}
	}
	public function GetPembiayaan($id_pembiayaan=false){
		$builder = $this->db->table($this->GetPembiayaan);
		if($id_pembiayaan){
			$builder->where("id_pembiayaan",$id_pembiayaan);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResult();
			if($id_pembiayaan){
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
