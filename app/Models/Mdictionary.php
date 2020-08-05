<?php 
namespace App\Models;
use CodeIgniter\Model;

class Mdictionary extends Model
{
	public function InsertBiodataMahasiswa()
    {
		/*
		$data=array("nama_mahasiswa",
					"jenis_kelamin",
					"jalan",
					"rt",
					"rw",
					"dusun",
					"kelurahan",
					"kode_pos",
					"nisn",
					"nik",
					"tempat_lahir",
					"tanggal_lahir",
					"nama_ayah",
					"tanggal_lahir_ayah",
					"nik_ayah",
					"id_jenjang_pendidikan_ayah",
					"id_pekerjaan_ayah",
					"id_penghasilan_ayah",
					"id_kebutuhan_khusus_ayah",
					"nama_ibu_kandung",
					"tanggal_lahir_ibu",
					"nik_ibu",
					"id_jenjang_pendidikan_ibu",
					"id_pekerjaan_ibu",
					"id_penghasilan_ibu",
					"id_kebutuhan_khusus_ibu",
					"nama_wali",
					"tanggal_lahir_wali",
					"id_jenjang_pendidikan_wali",
					"id_pekerjaan_wali",
					"id_penghasilan_wali",
					"id_kebutuhan_khusus_mahasiswa",
					"telepon","handphone",
					"email",
					"penerima_kps",
					"no_kps",
					"npwp",
					"id_wilayah",
					"id_jenis_tinggal",
					"id_agama",
					"id_alat_transportasi",
					"kewarganegaraan"
					);*/
		$data = array(
				"nama_mahasiswa",
				"jenis_kelamin",
				"tempat_lahir",
				"tanggal_lahir",
				"id_agama",
				"nik",
				"nisn",
				"npwp",
				"kewarganegaraan",
				"jalan",
				"dusun",
				"rt",
				"rw",
				"kelurahan",
				"kode_pos",
				"id_wilayah",
				"id_jenis_tinggal",
				"id_alat_transportasi",
				"telepon",
				"handphone",
				"email",
				"penerima_kps",
				"nomor_kps",
				"nik_ayah",
				"nama_ayah",
				"tanggal_lahir_ayah",
				"id_pendidikan_ayah",
				"id_pekerjaan_ayah",
				"id_penghasilan_ayah",
				"nik_ibu",
				"nama_ibu_kandung",
				"tanggal_lahir_ibu",
				"id_pendidikan_ibu",
				"id_pekerjaan_ibu",
				"id_penghasilan_ibu",
				"nama_wali",
				"tanggal_lahir_wali",
				"id_pendidikan_wali",
				"id_pekerjaan_wali",
				"id_penghasilan_wali",
				"id_kebutuhan_khusus_mahasiswa",
				"id_kebutuhan_khusus_ayah",
				"id_kebutuhan_khusus_ibu");			
		return $data;	
	}
	
	public function dictionaryFunction($function=false){
		if(!$function){
			$data = array("getdic","insertdic","updatedic","deletedic");
		}else{
			if($function == "getdic"){
				$data= array('GetProfilPT','GetAllPT','GetAllProdi','GetProdi','GetPeriode','GetListMahasiswa',
				'GetBiodataMahasiswa','GetDataLengkapMahasiswaProdi','GetListRiwayatPendidikanMahasiswa','GetKRSMahasiswa',
				'GetAktivitasKuliahMahasiswa','GetRiwayatNilaiMahasiswa','GetNilaiTransferPendidikanMahasiswa','GetAgama',
				'GetBentukPendidikan','GetIkatanKerjaSdm','GetJabfung','GetJalurMasuk','GetJenisEvaluasi','GetJenisKeluar',
				'GetJenisPendaftaran','GetJenisSertifikasi','GetJenisSMS','GetJenisSubstansi','GetJenisTinggal',
				'GetJenjangPendidikan','GetJurusan','GetKebutuhanKhusus','GetLembagaPengangkat','GetLevelWilayah','GetNegara',
				'GetPangkatGolongan','GetPekerjaan','GetPenghasilan','GetSemester','GetStatusKeaktifanPegawai',
				'GetStatusKepegawaian','GetStatusMahasiswa','GetTahunAjaran','GetWilayah','GetListDosen',
				'GetListPenugasanDosen','GetAktivitasMengajarDosen','GetRiwayatFungsionalDosen','GetRiwayatPangkatDosen',
				'GetRiwayatPendidikanDosen','GetRiwayatSertifikasiDosen','GetRiwayatPenelitianDosen','GetMahasiswaBimbinganDosen',
				'DetailBiodataDosen','GetListPenugasanSemuaDosen','GetDetailPenugasanDosen','GetListMataKuliah',
				'GetListKurikulum','GetListKelasKuliah','GetListNilaiPerkuliahanKelas','GetListPerkuliahanMahasiswa',
				'GetListSkalaNilaiProdi','GetListPeriodePerkuliahan','GetDetailMataKuliah','GetDetailKurikulum','GetMatkulKurikulum',
				'GetDetailKelasKuliah','GetDosenPengajarKelasKuliah','GetPerhitunganSKS','GetPesertaKelasKuliah',
				'GetDetailPerkuliahanMahasiswa','GetDetailSkalaNilaiProdi','GetListMahasiswaLulusDO',
				'GetDetailMahasiswaLulusDO','GetDetailPeriodePerkuliahan','ExportDataMahasiswa','ExportDataNilaiTransfer',
				'ExportDataPenugasanDosenProdi','ExportDataMatkulProdi','ExportDataKelasPerkuliahan','ExportDataMahasiswaKRS',
				'ExportDataMengajarDosen','ExportDataAktivitasKuliah','GetRekapJumlahDosen','GetRekapJumlahMahasiswa',
				'GetRekapKRSMahasiswa','GetRekapKHSMahasiswa','GetRekapIPSMahasiswa','ExportDataMahasiswaLulus',
				'GetDetailNilaiPerkuliahanKelas','GetDosenPembimbing','GetAlatTransportasi','GetListSubstansiKuliah',
				'GetListUjiMahasiswa','GetListBimbingMahasiswa','GetListAnggotaAktivitasMahasiswa',
				'GetListAktivitasMahasiswa','GetListPrestasiMahasiswa','GetPembiayaan','GetJenisPrestasi','GetTingkatPrestasi',
				'GetJenisAktivitasMahasiswa','GetKategoriKegiatan');
			}else if($function == "insertdic"){
				$data =array('InsertBiodataMahasiswa','InsertRiwayatPendidikanMahasiswa',
				'InsertNilaiTransferPendidikanMahasiswa','InsertMataKuliah','InsertMatkulKurikulum','InsertKurikulum',
				'InsertKelasKuliah','InsertDosenPengajarKelasKuliah','InsertPesertaKelasKuliah','InsertPerkuliahanMahasiswa',
				'InsertSkalaNilaiProdi','InsertMahasiswaLulusDO','InsertDosenPembimbing','InsertPeriodePerkuliahan',
				'InsertSubstansiKuliah','InsertAktivitasMahasiswa','InsertAnggotaAktivitasMahasiswa','InsertBimbingMahasiswa',
				'InsertUjiMahasiswa','InsertPrestasiMahasiswa');
			}else if($function == "updatedic"){
				$data=array('UpdateBiodataMahasiswa','UpdateRiwayatPendidikanMahasiswa',
				'UpdateNilaiTransferPendidikanMahasiswa','UpdateMataKuliah','UpdateKurikulum',
				'UpdateKelasKuliah','UpdateDosenPengajarKelasKuliah','UpdatePerkuliahanMahasiswa','UpdateSkalaNilaiProdi',
				'UpdateMahasiswaLulusDO','UpdatePeriodePerkuliahan','UpdateSubstansiKuliah','UpdatePrestasiMahasiswa','UpdateAktivitasMahasiswa');
			}else if($function == "deletedic"){
				$data=array('DeleteBiodataMahasiswa','DeleteRiwayatPendidikanMahasiswa','DeleteNilaiTransferPendidikanMahasiswa',
				'DeleteMataKuliah','DeleteKurikulum','DeleteMatkulKurikulum','DeleteKelasKuliah','DeleteDosenPengajarKelasKuliah',
				'DeletePesertaKelasKuliah','DeletePerkuliahanMahasiswa','DeleteSkalaNilaiProdi','DeleteMahasiswaLulusDO',
				'DeletePeriodePerkuliahan','DeleteDosenPembimbing','DeleteSubstansiKuliah','DeletePrestasiMahasiswa',
				'DeleteAktivitasMahasiswa','DeleteAnggotaAktivitasMahasiswa','DeleteBimbingMahasiswa','DeleteUjiMahasiswa');
			}
		}
		return $data;			
	}
	
}
