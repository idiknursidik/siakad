<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;

class Mahasiswa extends BaseController
{
	protected $siakad_mahasiswa = 'siakad_mahasiswa';
	protected $feeder_biodatamahasiswa = 'feeder_biodatamahasiswa';
	
	public function index()
	{

		$data = [
			'title' => 'Data Akademik',
			'judul' => 'Mahasiswa',
			'mn_akademik' => true,
			'mn_akademik_mahasiswa'=>true
			
		];
		return view('akademik/mahasiswa',$data);
	}
	public function listdata()
	{
		?>
		<script>
		  $(function () {
			$('#datatable').DataTable({
			  "paging": true,
			  "lengthChange": true,
			  "searching": true,
			  "ordering": true,
			  "info": true,
			  "autoWidth": false,
			  "responsive": true,
			});
		  });
		</script>
		<?php
		
		$profile 	= $this->msiakad_setting->getdata(); 
		$data 		= $this->msiakad_mahasiswa->getdata(false,false,false,false,$profile->kodept);
		
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Nama</th><th>Tanggal lahir</th><th>Jenis Kelamin</th><th>NIK</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='2'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nama_mahasiswa}</td>";
				echo "<td>{$val->tanggal_lahir}</td>";
				echo "<td>{$this->mfungsi->jenis_kelamin($val->jenis_kelamin)}</td>";
				echo "<td>{$val->nik}</td>";
				echo "<td><a href='".base_url()."/akademik/mahasiswa/detail/{$val->id_mahasiswa}'>detail</a></td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function detail($id_mahasiswa){
		$profile 	= $this->msiakad_setting->getdata();
		$mahasiswa  = $this->msiakad_mahasiswa->getdata(false,$id_mahasiswa,false,false,$profile->kodept);
		$infoakun 	= $this->msiakad_akun->getakunmahasiswa(false,false,false,$mahasiswa->id_mahasiswa);
		$data = [
			'title' => 'Data Akademik',
			'judul' => 'Mahasiswa',
			'mn_akademik' => true,
			'mn_akademik_mahasiswa'=>true,
			'id_mahasiswa'=>$id_mahasiswa,
			'data' => $mahasiswa,
			'infoakun'=>$infoakun
			
		];
		return view('akademik/mahasiswa_detail',$data);
	}
	public function getmahasiswapddikti(){		
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$data_mahasiswa_feeder = $this->msiakad_mahasiswa->getdatapddikti(false,$profile->kodept);
		if(!$data_mahasiswa_feeder){
			$ret["messages"] = "Tidak ada data PDDIKTI";
		}else{
			$jum=0;
			foreach($data_mahasiswa_feeder as $key=>$val){
				//cek data dulu
				$cekdata = $this->msiakad_mahasiswa->getdata(false,false,$val->id_mahasiswa,false,$profile->kodept);
				if(!$cekdata){
					
					$datain = array("kodept"=>$val->kode_perguruan_tinggi,
									"id_mahasiswa_ws"=>$val->id_mahasiswa,
									"nama_mahasiswa"=>$val->nama_mahasiswa,
									"jenis_kelamin"=>$val->jenis_kelamin,
									"jalan"=>$val->jalan,
									"rt"=>$val->rt,
									"rw"=>$val->rw,
									"dusun"=>$val->dusun,
									"kelurahan"=>$val->kelurahan,
									"kode_pos"=>$val->kode_pos,
									"nisn"=>$val->nisn,
									"nik"=>$val->nik,
									"tempat_lahir"=>$val->tempat_lahir,
									"tanggal_lahir"=>$val->tanggal_lahir,
									"nama_ayah"=>$val->nama_ayah,
									"tanggal_lahir_ayah"=>$val->tanggal_lahir_ayah,
									"nik_ayah"=>$val->nik_ayah,
									"id_pendidikan_ayah"=>$val->id_pendidikan_ayah,
									"id_pekerjaan_ayah"=>$val->id_pekerjaan_ayah,
									"id_penghasilan_ayah"=>$val->id_penghasilan_ayah,
									"id_kebutuhan_khusus_ayah"=>$val->id_kebutuhan_khusus_ayah,//
									"nama_ibu_kandung"=>$val->nama_ibu,
									"tanggal_lahir_ibu"=>$val->tanggal_lahir_ibu,
									"nik_ibu"=>$val->nik_ibu,
									"id_pendidikan_ibu"=>$val->id_pendidikan_ibu,
									"id_pekerjaan_ibu"=>$val->id_pekerjaan_ibu,
									"id_penghasilan_ibu"=>$val->id_penghasilan_ibu,
									"id_kebutuhan_khusus_ibu"=>$val->id_kebutuhan_khusus_ibu,//
									"nama_wali"=>$val->nama_wali,
									"tanggal_lahir_wali"=>$val->tanggal_lahir_wali,
									"id_pendidikan_wali"=>$val->id_pendidikan_wali,
									"id_pekerjaan_wali"=>$val->id_pekerjaan_wali,
									"id_penghasilan_wali"=>$val->id_penghasilan_wali,
									"id_kebutuhan_khusus_mahasiswa"=>$val->id_kebutuhan_khusus_mahasiswa,
									"telepon"=>$val->telepon,
									"handphone"=>$val->handphone,
									"email"=>$val->email,
									"penerima_kps"=>$val->penerima_kps,
									"no_kps"=>$val->nomor_kps,
									"npwp"=>$val->npwp,
									"id_wilayah"=>$val->id_wilayah,
									"id_jenis_tinggal"=>$val->id_jenis_tinggal,
									"id_agama"=>$val->id_agama,
									"id_alat_transportasi"=>$val->id_alat_transportasi,
									"kewarganegaraan"=>$val->id_negara,
									"penerima_kps"=>$val->penerima_kps);
									
					$query = $this->db->table($this->siakad_mahasiswa)->insert($datain);
					if($query){
						$jum++;
					}
				}
			}
			if($jum > 0){
				$ret["messages"] = "{$jum} data berhasil dimasukan";
				$ret["success"] = true;
			}else{
				$ret["messages"] = "tidak ada data yang dimasukan";
			}
		}		
		echo json_encode($ret);		
	}
	
	public function gethistoripendidikan($id_mahasiswa){
		if($this->request->isAJAX()){
			$data  = $this->msiakad_riwayatpendidikan->getdata(false,false,false,false,false,false,$id_mahasiswa);
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}
		
	}
	public function getkrs($id_mahasiswa){
		echo "H KRS {$id_mahasiswa}";
	}
	
	public function getbiodata($id_mahasiswa){
		if($this->request->isAJAX()){
			$data  = $this->msiakad_mahasiswa->getdata(false,$id_mahasiswa);
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}
	}
}
