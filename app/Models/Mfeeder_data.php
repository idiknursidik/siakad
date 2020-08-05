<?php 
namespace App\Models;
use CodeIgniter\Model;

class Mfeeder_data extends Model
{
		
	protected $profilpt 	= 'feeder_profilpt';
	protected $dataprodi 	= 'feeder_dataprodi';
	protected $mahasiswa 	= 'feeder_mahasiswa';
	protected $biodatamahasiswa		= 'feeder_biodatamahasiswa';
	protected $riwayatpendidikan	= 'feeder_riwayatpendidikan';
	protected $nilaitransfer 		= 'feeder_nilaitransfer';
	protected $akm			= 'feeder_akm';
	protected $krs			= 'feeder_krs';
	protected $nilai		= 'feeder_nilai';
	protected $matakuliah	= 'feeder_matakuliah';
	protected $kelaskuliah	= 'feeder_kelas';
	protected $kurikulum	= 'feeder_kurikulum';
	
    public function getprofilept($id_perguruan_tinggi=false,$kodept=false)
    {
		$builder = $this->db->table($this->profilpt);
		if($kodept){
			$builder->where("kode_perguruan_tinggi",$kodept);
		}
		if($id_perguruan_tinggi){
			$builder->where("id_perguruan_tinggi",$id_perguruan_tinggi);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($kodept || $id_perguruan_tinggi){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getdataprodi($id_prodi=false,$kode_program_studi=false,$id_perguruan_tinggi=false,$kodept=false)
    {
		$builder = $this->db->table($this->dataprodi);
		if($kodept){
			$builder->where("kode_perguruan_tinggi",$kodept);
		}
		if($id_perguruan_tinggi){
			$builder->where("id_perguruan_tinggi",$id_perguruan_tinggi);
		}
		if($id_prodi){
			$builder->where("id_prodi",$id_prodi);
		}
		if($kode_program_studi){
			$builder->where("kode_program_studi",$kode_program_studi);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_prodi || $kode_program_studi){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getdatamahasiswa($id_mahasiswa=false,$id_prodi=false,$id_perguruan_tinggi=false)
    {
		$builder = $this->db->table($this->mahasiswa);

		if($id_perguruan_tinggi){
			$builder->where("id_perguruan_tinggi",$id_perguruan_tinggi);
		}
		if($id_mahasiswa){
			$builder->where("id_mahasiswa",$id_mahasiswa);
		}
		if($id_prodi){
			$builder->where("id_prodi",$id_prodi);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
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
	public function getbiodatadatamahasiswa($id_mahasiswa=false,$id_perguruan_tinggi=false,$kodept=false)
    {
		$builder = $this->db->table($this->biodatamahasiswa);

		if($id_perguruan_tinggi){
			$builder->where("id_perguruan_tinggi",$id_perguruan_tinggi);
		}
		if($kodept){
			$builder->where("kodept",$kodept);
		}
		if($id_mahasiswa){
			$builder->where("id_mahasiswa",$id_mahasiswa);
		}
		
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
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
	public function getriwayatpendidikan($id_mahasiswa=false,$id_perguruan_tinggi=false,$id_prodi=false)
    {
		$builder = $this->db->table($this->riwayatpendidikan);

		if($id_perguruan_tinggi){
			$builder->where("id_perguruan_tinggi",$id_perguruan_tinggi);
		}
		if($id_prodi){
			$builder->where("id_prodi",$id_prodi);
		}
		if($id_mahasiswa){
			$builder->where("id_mahasiswa",$id_mahasiswa);
		}
		
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
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
	public function getnilaitransfer($id_transfer=false,$id_registrasi_mahasiswa=false,$id_perguruan_tinggi=false,$id_prodi=false)
    {
		$builder = $this->db->table($this->nilaitransfer);

		if($id_perguruan_tinggi){
			$builder->where("id_perguruan_tinggi",$id_perguruan_tinggi);
		}
		if($id_prodi){
			$builder->where("id_prodi",$id_prodi);
		}
		if($id_registrasi_mahasiswa){
			$builder->where("id_registrasi_mahasiswa",$id_registrasi_mahasiswa);
		}
		if($id_transfer){
			$builder->where("id_transfer",$id_transfer);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_transfer){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getkrs($nim=false,$id_periode=false,$id_registrasi_mahasiswa=false,$id_perguruan_tinggi=false,$id_prodi=false)
    {
		$builder = $this->db->table($this->krs);

		if($id_perguruan_tinggi){
			$builder->where("id_perguruan_tinggi",$id_perguruan_tinggi);
		}
		if($id_prodi){
			$builder->where("id_prodi",$id_prodi);
		}
		if($id_registrasi_mahasiswa){
			$builder->where("id_registrasi_mahasiswa",$id_registrasi_mahasiswa);
		}
		if($id_periode){
			$builder->where("id_periode",$id_periode);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if(($nim && $id_periode) || ($id_periode && $id_registrasi_mahasiswa && $id_perguruan_tinggi && $id_prodi)){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getnilai($nim=false,$id_periode=false,$id_registrasi_mahasiswa=false,$id_perguruan_tinggi=false,$id_prodi=false)
    {
		$builder = $this->db->table($this->nilai);

		if($id_perguruan_tinggi){
			$builder->where("id_perguruan_tinggi",$id_perguruan_tinggi);
		}
		if($id_prodi){
			$builder->where("id_prodi",$id_prodi);
		}
		if($id_registrasi_mahasiswa){
			$builder->where("id_registrasi_mahasiswa",$id_registrasi_mahasiswa);
		}
		if($id_periode){
			$builder->where("id_periode",$id_periode);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if(($nim && $id_periode) || ($id_periode && $id_registrasi_mahasiswa && $id_perguruan_tinggi && $id_prodi)){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getakm($nim=false,$id_semester=false,$id_registrasi_mahasiswa=false,$id_perguruan_tinggi=false,$id_prodi=false)
    {
		$builder = $this->db->table($this->akm);

		if($id_perguruan_tinggi){
			$builder->where("id_perguruan_tinggi",$id_perguruan_tinggi);
		}
		if($id_prodi){
			$builder->where("id_prodi",$id_prodi);
		}
		if($id_registrasi_mahasiswa){
			$builder->where("id_registrasi_mahasiswa",$id_registrasi_mahasiswa);
		}
		if($id_semester){
			$builder->where("id_semester",$id_semester);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if(($nim && $id_semester) || ($id_semester && $id_registrasi_mahasiswa && $id_perguruan_tinggi && $id_prodi)){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getmatakuliah($id_matkul=false,$kode_mata_kuliah=false,$id_perguruan_tinggi=false,$id_prodi=false)
    {
		$builder = $this->db->table($this->matakuliah);

		if($id_perguruan_tinggi){
			$builder->where("id_perguruan_tinggi",$id_perguruan_tinggi);
		}
		if($id_prodi){
			$builder->where("id_prodi",$id_prodi);
		}
		if($id_matkul){
			$builder->where("id_matkul",$id_matkul);
		}
		if($kode_mata_kuliah){
			$builder->where("kode_mata_kuliah",$kode_mata_kuliah);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_matkul){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getkelaskuliah($id_kelas_kuliah=false,$id_matkul=false,$id_perguruan_tinggi=false,$id_prodi=false)
    {
		$builder = $this->db->table($this->kelaskuliah);

		if($id_perguruan_tinggi){
			$builder->where("id_perguruan_tinggi",$id_perguruan_tinggi);
		}
		if($id_prodi){
			$builder->where("id_prodi",$id_prodi);
		}
		if($id_matkul){
			$builder->where("id_matkul",$id_matkul);
		}
		if($id_kelas_kuliah){
			$builder->where("id_kelas_kuliah",$id_kelas_kuliah);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_kelas_kuliah){
				$ret = $data[0];
			}else{
				$ret = $data;
			}
			return $ret;
		}else{
			return FALSE;
		}		
	}
	public function getkurikulum($id_kurikulum=false,$id_semester=false,$id_perguruan_tinggi=false,$id_prodi=false)
    {
		$builder = $this->db->table($this->kurikulum);

		if($id_perguruan_tinggi){
			$builder->where("id_perguruan_tinggi",$id_perguruan_tinggi);
		}
		if($id_prodi){
			$builder->where("id_prodi",$id_prodi);
		}
		if($id_semester){
			$builder->where("id_semester",$id_semester);
		}
		if($id_kurikulum){
			$builder->where("id_kurikulum",$id_kurikulum);
		}
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			if($id_kurikulum){
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
