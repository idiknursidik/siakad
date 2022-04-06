<?php 
namespace App\Models;
use CodeIgniter\Model;

class Mdictionary extends Model
{
	public function InsertBiodataMahasiswa()
    {
		/*
		$data=array("
		nama_mahasiswa": "Pangeran Ridwan",
		"jenis_kelamin": "L",
		"tempat_lahir": "Banggai",
		"tanggal_lahir": "2001-03-03",
		"id_agama": 1,
		"nik": "8208060305400002",
		"nisn": null,
		"npwp": null,
		"kewarganegaraan": "ID",
		"jalan": "Jl. Raya tanjung situ",
		"dusun": null,
		"rt": 5,
		"rw": 0,
		"kelurahan": "Kelurahan Tanjung Situ",
		"kode_pos": null,
		"id_wilayah": 999999,
		"id_jenis_tinggal": 1,
		"id_alat_transportasi": null,
		"telepon": null,
		"handphone": null,
		"email": null,
		"penerima_kps": 0,
		"nomor_kps": null,
		"nik_ayah": "8208060305400001",
		"nama_ayah": "Ayahku",
		"tanggal_lahir_ayah": "1980-10-01",
		"id_pendidikan_ayah": 35,
		"id_pekerjaan_ayah": 6,
		"id_penghasilan_ayah": 13,
		"nik_ibu": "8208060305400001",
		"nama_ibu_kandung": "Ibuku",
		"tanggal_lahir_ibu": "1982-01-04",
		"id_pendidikan_ibu": 20,
		"id_pekerjaan_ibu": 9,
		"id_penghasilan_ibu": 14,
		"nama_wali": null,
		"tanggal_lahir_wali": null,
		"id_pendidikan_wali": null,
		"id_pekerjaan_wali": null,
		"id_penghasilan_wali": null,
		"id_kebutuhan_khusus_mahasiswa": 0,
		"id_kebutuhan_khusus_ayah": 0,
		"id_kebutuhan_khusus_ibu": 0
					);*/
			$data = array(
				"nama_mahasiswa",//
				"jenis_kelamin",//
				"tempat_lahir",//
				"tanggal_lahir",//
				"id_agama",//
				"nik",//
				"nisn",//
				"npwp",//
				"kewarganegaraan",//
				"jalan",//
				"dusun",//
				"rt",//
				"rw",//
				"kelurahan",//
				"kode_pos",//
				"id_wilayah",//
				"id_jenis_tinggal",//
				"id_alat_transportasi",//
				"telepon",//
				"handphone",//
				"email",//
				"penerima_kps",//
				"nomor_kps",//
				"nik_ayah",//
				"nama_ayah",//
				"tanggal_lahir_ayah",//
				"id_pendidikan_ayah",//
				"id_pekerjaan_ayah",//
				"id_penghasilan_ayah",//
				"nik_ibu",//
				"nama_ibu_kandung",//
				"tanggal_lahir_ibu",//
				"id_pendidikan_ibu",//
				"id_pekerjaan_ibu",//
				"id_penghasilan_ibu",//
				"nama_wali",//
				"tanggal_lahir_wali",//
				"id_pendidikan_wali",//
				"id_pekerjaan_wali",//
				"id_penghasilan_wali",//
				"id_kebutuhan_khusus_mahasiswa",//
				"id_kebutuhan_khusus_ayah",//
				"id_kebutuhan_khusus_ibu");	//				
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
