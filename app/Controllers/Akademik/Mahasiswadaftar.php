<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
use App\Models\Msiakad_mahasiswadaftar;

class Mahasiswadaftar extends BaseController
{
	
	protected $siakad_mahasiswa_mendaftar = 'siakad_mahasiswa_mendaftar';
	protected $siakad_mahasiswa = 'siakad_mahasiswa';
	public function __construct()
    {
		$this->msiakad_mahasiswadaftar	= new Msiakad_mahasiswadaftar();
    }
	
	
	public function index()
	{

		$data = [
			'title' => 'Akademik',
			'judul' => 'Mahasiswa Mendaftar',
			'mn_akademik' => true,
			'mn_akademik_mahasiswadaftar'=>true
			
		];
		return view('akademik/mahasiswadaftar',$data);
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
		$data 		= $this->msiakad_mahasiswadaftar->getdata(false,$profile->kodept);
		//dd($data);
		
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Nama</th><th>Tanggal lahir</th><th>Jenis pendaftaran</th><th>Kelas pendaftaran</th><th>Aksi</th></tr></thead>";
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
				echo "<td>{$val->nama_jenis_daftar}</td>";
				echo "<td>{$val->kelas_pendaftaran}</td>";
				echo "<td>";
					echo "<a href='".base_url()."/akademik/mahasiswadaftar/ubahdata/{$val->id}'>ubah</a>";
					echo " | <a name='hapusdata' href='".base_url()."/akademik/mahasiswadaftar/hapusdata' id='{$val->id}' csrf_test_name='".csrf_hash()."'>hapus</a>";
					echo " | <a name='terimamahasiswa_{$val->id}' href='".base_url()."/akademik/mahasiswadaftar/terimamahasiswa' id='{$val->id}' csrf_test_name='".csrf_hash()."'>Terima</a>";
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
		echo "<hr>";
		echo "<a href='".base_url()."/akademik/mahasiswadaftar/tambahdata' class='btn btn-primary'>Tambah Data</a>";
	}
	public function terimamahasiswa(){
		$ret = array("success"=>false,"messages"=>array());

		$id = $this->request->getVar("id");
		$data = $this->msiakad_mahasiswadaftar->getdata($id);
		/*
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		exit();
		*/
		if($data){
			$datain["id_pendaftaran"] 	= $data->id;
			$datain["kodept"] 			= $data->kodept;
			$datain["nama_mahasiswa"] 	= $data->nama_mahasiswa;
			$datain["jenis_kelamin"] 	= $data->jenis_kelamin;
			$datain["jalan"] 			= $data->jalan;
			$datain["rt"] 				= $data->rt;
			$datain["rw"] 				= $data->rw;
			$datain["dusun"] 			= $data->dusun;
			$datain["kelurahan"] 		= $data->kelurahan;
			$datain["kode_pos"] 		= $data->kode_pos;
			$datain["nisn"] 			= "";
			$datain["nik"] 				= $data->nik;
			$datain["tempat_lahir"] 	= $data->tempat_lahir;
			$datain["tanggal_lahir"] 	= $data->tanggal_lahir;
			$datain["nama_ayah"] 		= $data->nama_ayah;
			$datain["tanggal_lahir_ayah"] = $data->tanggal_lahir_ayah;
			$datain["nik_ayah"] 		= $data->nik_ayah;
			$datain["id_pendidikan_ayah"] = $data->id_pendidikan_ayah;//Web Service: GetJenjangPendidikan
			$datain["id_pekerjaan_ayah"] 	= $data->id_pekerjaan_ayah; //Web Service: GetPekerjaan
			$datain["id_penghasilan_ayah"]	= $data->id_penghasilan_ayah;; //Web Service: GetPenghasilan
			$datain["id_kebutuhan_khusus_ayah"] = "";
			$datain["nama_ibu_kandung"] 	= $data->nama_ibu_kandung;
			$datain["tanggal_lahir_ibu"] 	= $data->tanggal_lahir_ibu;
			$datain["nik_ibu"] 				= $data->nik_ibu;
			$datain["id_pendidikan_ibu"]	= $data->id_pendidikan_ibu; //Web Service: GetJenjangPendidikan
			$datain["id_pekerjaan_ibu"] 	= $data->id_pekerjaan_ibu; //Web Service: GetPekerjaan
			$datain["id_penghasilan_ibu"] 	= $data->id_penghasilan_ibu; //Web Service: GetPenghasilan
			$datain["id_kebutuhan_khusus_ibu"] = "";
			$datain["nama_wali"] 			= $data->nama_wali;
			$datain["tanggal_lahir_wali"] 	= $data->tanggal_lahir_wali;
			$datain["id_pendidikan_wali"] = $data->id_pendidikan_wali; //Web Service: GetRecordset:jenjang_pendidikan
			$datain["id_pekerjaan_wali"] 	= $data->id_pekerjaan_wali; //Web Service: GetPekerjaan
			$datain["id_penghasilan_wali"] 	= $data->id_penghasilan_wali; //Web Service: GetPenghasilan
			$datain["id_kebutuhan_khusus_mahasiswa"] = "";
			$datain["telepon"] 				= $data->handphone;
			$datain["handphone"]			= $data->handphone;
			$datain["email"] 				= $data->email;
			$datain["penerima_kps"] 		= (strlen($data->no_kps) > 5)?1:0; //0: Bukan penerima KPS, 1: Penerima KPS
			$datain["no_kps"] 				= $data->no_kps;
			$datain["npwp"] 				= "";
			$datain["id_wilayah"]			= ""; //ID Wilayah. Web Service: GetRecordset:wilayah
			$datain["id_jenis_tinggal"] 	= $data->id_jenis_tinggal; //Web Service: GetJenisTinggal
			$datain["id_agama"] 			= $data->id_agama; //Web Service: GetAgama
			$datain["id_alat_transportasi"] = $data->id_alat_transportasi; //Web Service: GetAlatTransportasi
			$datain["kewarganegaraan"] 		= $data->kewarganegaraan; //Web Service: GetNegara
			
			
			//insert data
			$cekdata = $this->msiakad_mahasiswa->getdata($data->id);
			if(!$cekdata){
				$query = $this->db->table($this->siakad_mahasiswa)->insert($datain);
				$ret['messages'] = "Data berhasil dimasukan";
				$ret['success'] = true;
			}else{
				//update
				$query = $this->db->table($this->siakad_mahasiswa)->update($datain, array('id_pendaftaran' => $data->id));
				$ret['messages'] = "Data berhasil diupdate";
				$ret['success'] = true;
			}		
			
		}else{
			$ret["messages"] = "Tidak ada data mahasiswa";
		}
		echo json_encode($ret);
	}
	public function hapusdata(){
		$ret = array("success"=>false,"messages"=>array());
		$id = $this->request->getVar("id");
		$query = $this->db->table($this->siakad_mahasiswa_mendaftar)->delete(array('id' => $id));		
		if($query){	
			$ret['messages'] = "Data berhasil dihapus";
			$ret['success'] = true;	
		}else{
			$ret['messages'] = "Data gagal dihapus";
		}	
		echo json_encode($ret);
	}
	public function tambahdata(){
		$data = [
			'title' => 'Akademik',
			'judul' => 'Tambah Mahasiswa Mendaftar',
			'mn_akademik' => true,
			'mn_akademik_mahasiswadaftar'=>true
			
		];
		return view('akademik/mahasiswadaftar_tambah',$data);		
	}
	public function formtambah(){
		$profile 			= $this->msiakad_setting->getdata(); 
		$GetJenisPendaftaran 	= $this->mreferensi->GetJenisPendaftaran();
		$jenis_semester		= $this->mfungsi->jenis_semester();
		
		$dataprodi			= $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		
		$kelas_pendaftaran	= $this->mfungsi->kelas_pendaftaran();
		$jenis_kelamin		= $this->mfungsi->jenis_kelamin();
		$GetAgama				= $this->mreferensi->GetAgama();
		$GetJenisTinggal		= $this->mreferensi->GetJenisTinggal();
		$kewarganegaraan	= $this->mfungsi->kewarganegaraan();
		$pend_terakhir		= $this->mfungsi->pend_terakhir();
		$GetJenjangPendidikan = $this->mreferensi->GetJenjangPendidikan();
		$GetJalurMasuk		= $this->mreferensi->GetJalurMasuk();
		$GetPekerjaan		= $this->mreferensi->GetPekerjaan();
		$GetPenghasilan		= $this->mreferensi->GetPenghasilan();
		
		echo "<form id='form_tambah' action='".base_url()."/akademik/mahasiswadaftar/simpan' method='post'>";
		echo "<input type='hidden' name='kodept' value='{$profile->kodept}'>";
		echo csrf_field();
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA PENDAFTARAN</h3>";
            echo "<div class='card-tools'>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='remove'><i class='fas fa-times'></i></button>";
			echo "</div>";
          echo "</div>";
		  echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Semester</label>";
					echo "<select name='semester' class='custom-select'>";
						for($semester = date('Y')-3; $semester<=date('Y')+1; $semester++){
							foreach($jenis_semester as $key=>$val){
								$cursemester =  ($this->request->getVar('jenis_pendaftaran'))?$this->request->getVar('jenis_pendaftaran'):date('Y').'1';
								$keysemester = $semester.$key;
								$valsemester = $semester.' '.$val;
								echo "<option value='{$keysemester}'";
								if($cursemester == $keysemester) echo " selected='selected'";
								echo ">{$valsemester}</option>";
							}
						}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Jenis Pendaftaran</label>";
					echo "<select name='id_jenis_daftar' class='custom-select'>";
						foreach($GetJenisPendaftaran as $key=>$val){
							echo "<option value='{$val->id_jenis_daftar}'";
							if($this->request->getVar('id_jenis_daftar') == $val->id_jenis_daftar) echo " selected='selected'";
							echo ">{$val->nama_jenis_daftar}</option>";
						}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Jalur Pendaftaran</label>";
					echo "<select name='id_jalur_masuk' class='custom-select'>";
						foreach($GetJalurMasuk as $key=>$val){
							echo "<option value='{$val->id_jalur_masuk}'";
							if("6" == $val->id_jalur_masuk) echo " selected='selected'";
							echo ">{$val->nama_jalur_masuk}</option>";
						}				  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";		  
			
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
					echo "<div class='form-group'>";
						echo "<label>Prodi</label>";
						echo "<select class='custom-select' name='id_prodi'>";
							foreach($dataprodi as $key=>$val){
								if(in_array($val->id_prodi,explode(",",session()->akses))){
									if($val->status == 'A'){
										echo "<option value='{$val->id_prodi}'";
										if($this->request->getVar('jenis_pendaftaran') == $val->id_prodi) echo " selected='selected'";
										echo ">{$val->nama_prodi} ({$val->nama_jenjang_didik})</option>";
									}
								}
							}				  
						echo "</select>";
					echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
					echo "<div class='form-group'>";
						echo "<label>Kelas</label>";
						echo "<select name='kelas_pendaftaran' class='custom-select'>";
							foreach($kelas_pendaftaran as $key=>$val){
								echo "<option value='{$key}'";
								if($this->request->getVar('kelas_pendaftaran') == $key) echo " selected='selected'";
								echo ">{$val}</option>";
							}				  
						echo "</select>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		  echo "</div>";
		echo "</div>";
		
		//data calon mahasiswa
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA CALON MAHASISWA</h3>";
            echo "<div class='card-tools'>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='remove'><i class='fas fa-times'></i></button>";
			echo "</div>";
          echo "</div>";
		  echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama</label>";
					echo "<input type='text' name='nama_mahasiswa' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Jenis Kelamin</label>";
					echo "<select name='jenis_kelamin' class='custom-select'>";
					foreach($jenis_kelamin as $key=>$val){
						echo "<option value='{$key}'";
						if($this->request->getVar('jenis_kelamin') == $key) echo " selected='selected'";
						echo ">{$val}</option>";
					}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
					echo "<div class='form-group'>";
						echo "<label>Tempat lahir</label>";
						echo "<input type='text' name='tempat_lahir' class='form-control'>";
					echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
					echo "<div class='form-group'>";
						echo "<label>Tanggal lahir</label>";
						echo "<input type='date' name='tanggal_lahir' class='form-control'>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>NIK</label>";
					echo "<input type='text' name='nik' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Agama</label>";
					echo "<select name='id_agama' class='custom-select'>";
					foreach($GetAgama as $key=>$val){
						echo "<option value='{$val->id_agama}'";
						if($this->request->getVar('id_agama') == $val->id_agama) echo " selected='selected'";
						echo ">{$val->nama_agama}</option>";
					}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group'>";
				echo "<label>Alamat</label>";
				echo "<input type='text' name='jalan' class='form-control'>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-3'>";
				  echo "<div class='form-group'>";
					echo "<label>RT</label>";
					echo "<input type='text' name='rt' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-3'>";
				  echo "<div class='form-group'>";
					echo "<label>RW</label>";
					echo "<input type='text' name='rw' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Dusun</label>";
					echo "<input type='text' name='dusun' class='form-control'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Kelurahan</label>";
					echo "<input type='text' name='kelurahan' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Kecamatan</label>";
					echo "<input type='text' name='kecamatan' class='form-control'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Kota/Kabupaten</label>";
					echo "<input type='text' name='kota_kabupaten' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Kode Pos</label>";
					echo "<input type='text' name='kode_pos' class='form-control'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
				echo "<label>Jenis tinggal</label>";
				echo "<select name='id_jenis_tinggal' class='custom-select'>";
					foreach($GetJenisTinggal as $key=>$val){
						echo "<option value='{$val->id_jenis_tinggal}'";
						if($this->request->getVar('id_jenis_tinggal') == $val->id_jenis_tinggal) echo " selected='selected'";
						echo ">{$val->nama_jenis_tinggal}</option>";
					}				  
				echo "</select>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nomor Handphone</label>";
					echo "<input type='text' name='handphone' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>E-mail Pribadi</label>";
					echo "<input type='text' name='email' class='form-control'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nomor Kartu Indonesia Sehat (KIS)</label>";
					echo "<input type='text' name='no_kis' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nomor Kartu Indonesia Pintar (KIP)</label>";
					echo "<input type='text' name='no_kip' class='form-control'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nomor Kartu Pra Sejahtera (KPS)</label>";
					echo "<input type='text' name='no_kps' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nomor Kartu Keluarga Sejahtera (KKS) </label>";
					echo "<input type='text' name='no_kks' class='form-control'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group'>";
				echo "<label>Kewarganegaraan </label>";
				echo "<select name='kewarganegaraan' class='custom-select'>";
					foreach($kewarganegaraan as $key=>$val){
						echo "<option value='{$key}'";
						if($this->request->getVar('kewarganegaraan') == $key) echo " selected='selected'";
						echo ">{$val}</option>";
					}				  
				echo "</select>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Pendidikan Menengah</label>";
					echo "<select name='pend_terakhir' class='custom-select'>";
						foreach($pend_terakhir as $key=>$val){
							echo "<option value='{$key}'";
							if($this->request->getVar('pend_terakhir') == $key) echo " selected='selected'";
							echo ">{$val}</option>";
						}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama Sekolah Asal</label>";
					echo "<input type='text' name='sekolah_asal' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-2'>";
				  echo "<div class='form-group'>";
					echo "<label>Tahun Lulus</label>";
					echo "<select name='tahun_lulus' class='custom-select'>";
						for($th=1900; $th<=date("Y"); $th++){
							echo "<option value='{$th}'";
							if(date("Y") == $th) echo " selected='selected'";
							echo ">{$th}</option>";
						}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group'>";
				echo "<label>Prestasi yang pernah diraih </label>";
				echo "<textarea name='prestasi' class='form-control'></textarea>";
			echo "</div>";	
		  echo "</div>";//end bo	  
		echo "</div>"; // end card
		
		
		//DATA Orang Tua
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA ORANG TUA/AYAH</h3>";
            echo "<div class='card-tools'>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='remove'><i class='fas fa-times'></i></button>";
			echo "</div>";
          echo "</div>";
		  echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama</label>";
					echo "<input type='text' class='form-control' name='nama_ayah'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>NIK</label>";
					echo "<input type='text' class='form-control' name='nik_ayah'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Tanggal Lahir</label>";
					echo "<input type='date' class='form-control' name='tanggal_lahir_ayah'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Pendidikan</label>";
					echo "<select class='form-control' name='id_pendidikan_ayah'>";
					foreach($GetJenjangPendidikan as $key=>$val){
						echo "<option value='{$val->id_jenjang_didik}'";
						if($this->request->getVar("id_pendidikan_ayah") == $val->id_jenjang_didik) echo " selected='selected'";
						echo ">{$val->nama_jenjang_didik}</option>";
					}
					echo "</select>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Pekerjaan</label>";
					echo "<select class='form-control' name='id_pekerjaan_ayah'>";
					foreach($GetPekerjaan as $key=>$val){
						echo "<option value='{$val->id_pekerjaan}'";
						if($this->request->getVar("id_pekerjaan_ayah") == $val->id_pekerjaan) echo " selected='selected'";
						echo ">{$val->nama_pekerjaan}</option>";
					}
					echo "</select>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
					echo "<div class='form-group'>";
						echo "<label>Penghasilan</label>";
						echo "<select class='form-control' name='id_penghasilan_ayah'>";
						foreach($GetPenghasilan as $key=>$val){
							echo "<option value='{$val->id_penghasilan}'";
							if($this->request->getVar("id_penghasilan_ayah") == $val->id_penghasilan) echo " selected='selected'";
							echo ">{$val->nama_penghasilan}</option>";
						}
					echo "</select>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		  echo "</div>";
		echo "</div>";
		//IBU
		//DATA Orang Tua
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA ORANG TUA/IBU</h3>";
            echo "<div class='card-tools'>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='remove'><i class='fas fa-times'></i></button>";
			echo "</div>";
          echo "</div>";
		  echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama ibu kadung</label>";
					echo "<input type='text' class='form-control' name='nama_ibu_kandung'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>NIK</label>";
					echo "<input type='text' class='form-control' name='nik_ibu'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Tanggal Lahir</label>";
					echo "<input type='date' class='form-control' name='tanggal_lahir_ibu'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Pendidikan</label>";
					echo "<select class='form-control' name='id_pendidikan_ibu'>";
					foreach($GetJenjangPendidikan as $key=>$val){
						echo "<option value='{$val->id_jenjang_didik}'";
						if($this->request->getVar("id_pendidikan_ibu") == $val->id_jenjang_didik) echo " selected='selected'";
						echo ">{$val->nama_jenjang_didik}</option>";
					}
					echo "</select>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Pekerjaan</label>";
					echo "<select class='form-control' name='id_pekerjaan_ibu'>";
					foreach($GetPekerjaan as $key=>$val){
						echo "<option value='{$val->id_pekerjaan}'";
						if($this->request->getVar("id_pekerjaan_ibu") == $val->id_pekerjaan) echo " selected='selected'";
						echo ">{$val->nama_pekerjaan}</option>";
					}
					echo "</select>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
					echo "<div class='form-group'>";
						echo "<label>Penghasilan</label>";
						echo "<select class='form-control' name='id_penghasilan_ibu'>";
						foreach($GetPenghasilan as $key=>$val){
							echo "<option value='{$val->id_penghasilan}'";
							if($this->request->getVar("id_penghasilan_ibu") == $val->id_penghasilan) echo " selected='selected'";
							echo ">{$val->nama_penghasilan}</option>";
						}
					echo "</select>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		  echo "</div>";
		echo "</div>";
		//WALI
		//DATA Orang Tua
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA ORANG TUA/WALI</h3>";
            echo "<div class='card-tools'>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='remove'><i class='fas fa-times'></i></button>";
			echo "</div>";
          echo "</div>";
		  echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>NIK</label>";
					echo "<input type='text' class='form-control' name='nama_wali'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Tanggal Lahir</label>";
					echo "<input type='date' class='form-control' name='tanggal_lahir_wali'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Pendidikan</label>";
					echo "<select class='form-control' name='id_pendidikan_wali'>";
					foreach($GetJenjangPendidikan as $key=>$val){
						echo "<option value='{$val->id_jenjang_didik}'";
						if($this->request->getVar("id_pendidikan_wali") == $val->id_jenjang_didik) echo " selected='selected'";
						echo ">{$val->nama_jenjang_didik}</option>";
					}
					echo "</select>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Pekerjaan</label>";
					echo "<select class='form-control' name='id_pekerjaan_wali'>";
					foreach($GetPekerjaan as $key=>$val){
						echo "<option value='{$val->id_pekerjaan}'";
						if($this->request->getVar("id_pekerjaan_wali") == $val->id_pekerjaan) echo " selected='selected'";
						echo ">{$val->nama_pekerjaan}</option>";
					}
					echo "</select>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
					echo "<div class='form-group'>";
						echo "<label>Penghasilan</label>";
						echo "<select class='form-control' name='id_penghasilan_wali'>";
						foreach($GetPenghasilan as $key=>$val){
							echo "<option value='{$val->id_penghasilan}'";
							if($this->request->getVar("id_penghasilan_wali") == $val->id_penghasilan) echo " selected='selected'";
							echo ">{$val->nama_penghasilan}</option>";
						}
					echo "</select>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		  echo "</div>";
		echo "</div>";
		//DATA Pekesrjaaan
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA PEKERJAAAN (JIKA BEKERJA)</h3>";
            echo "<div class='card-tools'>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='remove'><i class='fas fa-times'></i></button>";
			echo "</div>";
          echo "</div>";
		  echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama Perusahaan</label>";
					echo "<input type='text' class='form-control' name='pekerjaan_perusahaan'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Telepon</label>";
					echo "<input type='text' class='form-control' name='pekerjaan_telepon'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group'>";
				echo "<label>Alamat</label>";
				echo "<input type='text' class='form-control' name='pekerjaan_alamat'>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-2'>";
				  echo "<div class='form-group'>";
					echo "<label>RT</label>";
					echo "<input type='text' class='form-control' name='pekerjaan_rt'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-2'>";
				  echo "<div class='form-group'>";
					echo "<label>RW</label>";
					echo "<input type='text' class='form-control' name='pekerjaan_rw'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama Dusun</label>";
					echo "<input type='text' class='form-control' name='pekerjaan_dusun'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Kodepos</label>";
					echo "<input type='text' class='form-control' name='pekerjaan_kodepos'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama Kelurahan/ Desa</label>";
					echo "<input type='text' class='form-control' name='pekerjaan_kelurahan'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Kecamatan </label>";
					echo "<input type='text' class='form-control' name='pekerjaan_kecamatan'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Kabupaten </label>";
					echo "<input type='text' class='form-control' name='pekerjaan_kabupaten'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
					
		  echo "</div>";
		echo "</div>";
		//DATA MAHASISWA PINDAHAN
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA PINDAHAN (JIKA PINDAHAN)</h3>";
            echo "<div class='card-tools'>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='remove'><i class='fas fa-times'></i></button>";
			echo "</div>";
          echo "</div>";
		  echo "<div class='card-body'>";
			echo "<div class='form-group'>";
				echo "<label>Nama Perguruan Tinggi</label>";
				echo "<input type='text' class='form-control' name='pindahan_pt'>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Fakultas</label>";
					echo "<input type='text' class='form-control' name='pindahan_fakultas'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Program Studi</label>";
					echo "<input type='text' class='form-control' name='pindahan_prodi'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Akreditasi Program Studi</label>";
					echo "<input type='text' class='form-control' name='pindahan_akreditasi'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Jenjang Pendidikan</label>";
					echo "<input type='text' class='form-control' name='pindahan_jenjang'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Semester Terakhir</label>";
					echo "<input type='text' class='form-control' name='pindahan_semester'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>SKS Yang Telah Ditempuh</label>";
					echo "<input type='text' class='form-control' name='pindahan_sks'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
					
		  echo "</div>";
		echo "</div>";
		echo "<hr><button class='btn btn-primary' name='kirim' type='submit'>Simpan data</button><br><br>";
		echo "</form>";
	}
	public function simpan(){
		$profile 			= $this->msiakad_setting->getdata(); 
		$ret=array("success"=>false,"messages"=>array());
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'nama_mahasiswa' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nama harus diisi.'
				]
			],
			'tempat_lahir'=>[
				'rules' => 'required',
				'errors' => [
					'required' => 'Tempat lahir harus diisi.'
				]
			],
			'nik'=>[
				'rules' => 'required|is_unique[siakad_mahasiswa_mendaftar.nik]',//is_unique[siakad_mahasiswa_mendaftar.nik,nama,{nama}]
				'errors' => [
					'required' => 'NIK harus diisi.',
					'is_unique' => 'Data sudah ada'
				]
			],
			'tanggal_lahir'=>[
				'rules' => 'required',
				'errors' => [
					'required' => 'Tanggal lahir harus dipilih.'
				]
			],
			'nama_ibu_kandung'=>[
				'rules' => 'required',
				'errors' => [
					'required' => 'Nama ibu kandung harus diisi.'
				]
			]
		]))
		{			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{
			
			$id_prodi	= $this->request->getVar("id_prodi");
			$datain=array();
			foreach($this->request->getVar() as $key=>$val){
				if($key != "csrf_test_name"){
					$datain[$key] =  $this->request->getVar($key);
				}
			}
			$prodi = $this->msiakad_prodi->getdata($id_prodi,false,$profile->kodept);
			if($prodi){
				if(strlen($prodi->kode_prodi) > 0){
					$datain["kode_prodi"] = $prodi->kode_prodi;
				}
			}
			$query = $this->db->table($this->siakad_mahasiswa_mendaftar)->insert($datain);		
			if($query){	
				$ret['messages'] = "Data berhasil dimasukan";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal dimasukan";
			}			
		}	
		echo json_encode($ret);
	}
	public function ubahdata($id){
		$data = [
			'title' => 'Akademik',
			'judul' => 'Ubah Mahasiswa Mendaftar',
			'mn_akademik' => true,
			'mn_akademik_mahasiswadaftar'=>true,
			'id'=>$id
			
		];
		return view('akademik/mahasiswadaftar_ubah',$data);		
	}
	public function formubah($id){
		$profile			= $this->msiakad_setting->getdata();
		$jenis_pendaftaran 	= $this->mfungsi->jenis_pendaftaran();
		$jenis_semester		= $this->mfungsi->jenis_semester();
		$jalur_pendaftaran	= $this->mfungsi->jalur_pendaftaran();
		$dataprodi			= $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		$kelas_pendaftaran	= $this->mfungsi->kelas_pendaftaran();
		$jenis_kelamin		= $this->mfungsi->jenis_kelamin();
		$agama				= $this->mfungsi->agama();
		$jenis_tinggal		= $this->mfungsi->jenis_tinggal();
		$kewarganegaraan	= $this->mfungsi->kewarganegaraan();
		$pend_terakhir		= $this->mfungsi->pend_terakhir();
		
		
		$data 				= $this->msiakad_mahasiswadaftar->getdata($id);
		
		//print_r($dataprodi);
		echo "<form id='form_ubah' action='".base_url()."/akademik/mahasiswadaftar/ubah' method='post'>";
		echo "<input type='hidden' name='id' value='{$data->id}'>";
		echo "<input type='hidden' name='kodept' value='{$profile->kodept}'>";
		echo csrf_field();
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA PENDAFTARAN</h3>";
            echo "<div class='card-tools'>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='remove'><i class='fas fa-times'></i></button>";
			echo "</div>";
          echo "</div>";
		  echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Semester</label>";
					echo "<select name='semester' class='custom-select'>";
						for($semester = date('Y')-3; $semester<=date('Y')+1; $semester++){
							foreach($jenis_semester as $key=>$val){
								$cursemester =  ($data->semester)?$data->semester:date('Y').'1';
								$keysemester = $semester.$key;
								$valsemester = $semester.' '.$val;
								echo "<option value='{$keysemester}'";
								if($cursemester == $keysemester) echo " selected='selected'";
								echo ">{$valsemester}</option>";
							}
						}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Jenis Pendaftaran</label>";
					echo "<select name='jenis_pendaftaran' class='custom-select'>";
						foreach($jenis_pendaftaran as $key=>$val){
							echo "<option value='{$key}'";
							if($this->request->getVar('jenis_pendaftaran') == $key) echo " selected='selected'";
							echo ">{$val}</option>";
						}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Jalur Pendaftaran</label>";
					echo "<select name='jalur_pendaftaran' class='custom-select'>";
						foreach($jalur_pendaftaran as $key=>$val){
							echo "<option value='{$key}'";
							if($this->request->getVar('jalur_pendaftaran') == $key) echo " selected='selected'";
							echo ">{$val}</option>";
						}				  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			
			  
			
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
					echo "<div class='form-group'>";
						echo "<label>Prodi</label>";
						echo "<select class='custom-select' name='id_prodi'>";
							foreach($dataprodi as $key=>$val){
								if(in_array($val->id_prodi,explode(",",session()->akses))){
									if($val->status == 'A'){
										echo "<option value='{$val->id_prodi}'";
										if($data->id_prodi == $val->id_prodi) echo " selected='selected'";
										echo ">{$val->nama_prodi} ({$val->nama_jenjang_didik})</option>";
									}
								}
							}				  
						echo "</select>";
					echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
					echo "<div class='form-group'>";
						echo "<label>Kelas</label>";
						echo "<select name='kelas_pendaftaran' class='custom-select'>";
							foreach($kelas_pendaftaran as $key=>$val){
								echo "<option value='{$key}'";
								if($this->request->getVar('kelas_pendaftaran') == $key) echo " selected='selected'";
								echo ">{$val}</option>";
							}				  
						echo "</select>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		  echo "</div>";
		echo "</div>";
		
		//data calon mahasiswa
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA CALON MAHASISWA</h3>";
            echo "<div class='card-tools'>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='remove'><i class='fas fa-times'></i></button>";
			echo "</div>";
          echo "</div>";
		  echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama</label>";
					echo "<input type='text' name='nama' class='form-control' value='{$data->nama}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Jenis Kelamin</label>";
					echo "<select name='jenis_kelamin' class='custom-select'>";
					foreach($jenis_kelamin as $key=>$val){
						echo "<option value='{$key}'";
						if($data->jenis_kelamin == $key) echo " selected='selected'";
						echo ">{$val}</option>";
					}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
					echo "<div class='form-group'>";
						echo "<label>Tempat lahir</label>";
						echo "<input type='text' name='tempat_lahir' class='form-control' value='{$data->tempat_lahir}'>";
					echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
					echo "<div class='form-group'>";
						echo "<label>Tanggal lahir</label>";
						echo "<input type='date' name='tanggal_lahir' class='form-control' value='{$data->tanggal_lahir}'>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>NIK</label>";
					echo "<input type='text' name='nik' class='form-control' value='{$data->nik}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Agama</label>";
					echo "<select name='agama' class='custom-select'>";
					foreach($agama as $key=>$val){
						echo "<option value='{$key}'";
						if($this->request->getVar('agama') == $key) echo " selected='selected'";
						echo ">{$val}</option>";
					}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group'>";
				echo "<label>Alamat</label>";
				echo "<input type='text' name='alamat' class='form-control'>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-3'>";
				  echo "<div class='form-group'>";
					echo "<label>RT</label>";
					echo "<input type='text' name='rt' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-3'>";
				  echo "<div class='form-group'>";
					echo "<label>RW</label>";
					echo "<input type='text' name='rw' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Dusun</label>";
					echo "<input type='text' name='dusun' class='form-control'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Kelurahan</label>";
					echo "<input type='text' name='kelurahan' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Kecamatan</label>";
					echo "<input type='text' name='kecamatan' class='form-control'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Kota/Kabupaten</label>";
					echo "<input type='text' name='kota_kabupaten' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Kode Pos</label>";
					echo "<input type='text' name='kodepos' class='form-control'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
				echo "<label>Jenis tinggal</label>";
				echo "<select name='jenis_tinggal' class='custom-select'>";
					foreach($jenis_tinggal as $key=>$val){
						echo "<option value='{$key}'";
						if($this->request->getVar('jenis_tinggal') == $key) echo " selected='selected'";
						echo ">{$val}</option>";
					}				  
				echo "</select>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nomor Handphone</label>";
					echo "<input type='text' name='hp' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>E-mail Pribadi</label>";
					echo "<input type='text' name='email' class='form-control'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nomor Kartu Indonesia Sehat (KIS)</label>";
					echo "<input type='text' name='no_kis' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nomor Kartu Indonesia Pintar (KIP)</label>";
					echo "<input type='text' name='no_kip' class='form-control'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nomor Kartu Pra Sejahtera (KPS)</label>";
					echo "<input type='text' name='no_kps' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nomor Kartu Keluarga Sejahtera (KKS) </label>";
					echo "<input type='text' name='no_kks' class='form-control'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group'>";
				echo "<label>Kewarganegaraan </label>";
				echo "<select name='kewarganegaraan' class='custom-select'>";
					foreach($kewarganegaraan as $key=>$val){
						echo "<option value='{$key}'";
						if($this->request->getVar('kewarganegaraan') == $key) echo " selected='selected'";
						echo ">{$val}</option>";
					}				  
				echo "</select>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Pendidikan Terakhir</label>";
					echo "<select name='pend_terakhir' class='custom-select'>";
						foreach($pend_terakhir as $key=>$val){
							echo "<option value='{$key}'";
							if($this->request->getVar('pend_terakhir') == $key) echo " selected='selected'";
							echo ">{$val}</option>";
						}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama Sekolah Asal</label>";
					echo "<input type='text' name='sekolah_asal' class='form-control'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-2'>";
				  echo "<div class='form-group'>";
					echo "<label>Tahun Lulus</label>";
					echo "<select name='tahun_lulus' class='custom-select'>";
						for($th=1900; $th<=date("Y"); $th++){
							echo "<option value='{$th}'";
							if(date("Y") == $th) echo " selected='selected'";
							echo ">{$th}</option>";
						}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group'>";
				echo "<label>Prestasi yang pernah diraih </label>";
				echo "<textarea name='prestasi' class='form-control'></textarea>";
			echo "</div>";	
		  echo "</div>";//end bo	  
		echo "</div>"; // end card
		
		
		//DATA Orang Tua
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA ORANG TUA/WALI</h3>";
            echo "<div class='card-tools'>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='remove'><i class='fas fa-times'></i></button>";
			echo "</div>";
          echo "</div>";
		  echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama Wali</label>";
					echo "<input type='text' class='form-control' name='wali_nama'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>KTP Wali</label>";
					echo "<input type='text' class='form-control' name='wali_ktp'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Telepon Wali</label>";
					echo "<input type='text' class='form-control' name='wali_hp'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Tempat Lahir</label>";
					echo "<input type='text' class='form-control' name='wali_tempat_lahir'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Tanggal Lahir</label>";
					echo "<input type='date' class='form-control' name='wali_tanggal_lahir'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
					echo "<div class='form-group'>";
						echo "<label>Agama</label>";
						echo "<select name='wali_agama' class='custom-select'>";
						foreach($agama as $key=>$val){
							echo "<option value='{$key}'";
							if($this->request->getVar('wali_agama') == $key) echo " selected='selected'";
							echo ">{$val}</option>";
						}			  
						echo "</select>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group'>";
				echo "<label>Jalan</label>";
				echo "<input type='text' class='form-control' name='wali_alamat'>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-2'>";
				  echo "<div class='form-group'>";
					echo "<label>RT</label>";
					echo "<input type='text' class='form-control' name='wali_rt'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-2'>";
				  echo "<div class='form-group'>";
					echo "<label>RW</label>";
					echo "<input type='text' class='form-control' name='wali_rw'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama Dusun</label>";
					echo "<input type='text' class='form-control' name='wali_dusun'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Kodepos</label>";
					echo "<input type='text' class='form-control' name='wali_kodepos'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama Kelurahan/ Desa</label>";
					echo "<input type='text' class='form-control' name='wali_kelurahan'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Kecamatan </label>";
					echo "<input type='text' class='form-control' name='wali_kecamatan'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Kabupaten </label>";
					echo "<input type='text' class='form-control' name='wali_kota_kabupaten'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Pendidikan Wali</label>";
					echo "<input type='text' class='form-control' name='wali_pendidikan'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Pekerjaan Wali</label>";
					echo "<input type='text' class='form-control' name='wali_pekerjaan'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";			
		  echo "</div>";
		echo "</div>";
		//DATA Pekesrjaaan
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA PEKERJAAAN (JIKA BEKERJA)</h3>";
            echo "<div class='card-tools'>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='remove'><i class='fas fa-times'></i></button>";
			echo "</div>";
          echo "</div>";
		  echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama Perusahaan</label>";
					echo "<input type='text' class='form-control' name='pekerjaan_perusahaan'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Telepon</label>";
					echo "<input type='text' class='form-control' name='pekerjaan_telepon'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group'>";
				echo "<label>Alamat</label>";
				echo "<input type='text' class='form-control' name='pekerjaan_alamat'>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-2'>";
				  echo "<div class='form-group'>";
					echo "<label>RT</label>";
					echo "<input type='text' class='form-control' name='pekerjaan_rt'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-2'>";
				  echo "<div class='form-group'>";
					echo "<label>RW</label>";
					echo "<input type='text' class='form-control' name='pekerjaan_rw'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama Dusun</label>";
					echo "<input type='text' class='form-control' name='pekerjaan_dusun'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Kodepos</label>";
					echo "<input type='text' class='form-control' name='pekerjaan_kodepos'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama Kelurahan/ Desa</label>";
					echo "<input type='text' class='form-control' name='pekerjaan_kelurahan'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Kecamatan </label>";
					echo "<input type='text' class='form-control' name='pekerjaan_kecamatan'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Kabupaten </label>";
					echo "<input type='text' class='form-control' name='pekerjaan_kabupaten'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
					
		  echo "</div>";
		echo "</div>";
		//DATA MAHASISWA PINDAHAN
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA PINDAHAN (JIKA PINDAHAN)</h3>";
            echo "<div class='card-tools'>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='remove'><i class='fas fa-times'></i></button>";
			echo "</div>";
          echo "</div>";
		  echo "<div class='card-body'>";
			echo "<div class='form-group'>";
				echo "<label>Nama Perguruan Tinggi</label>";
				echo "<input type='text' class='form-control' name='pindahan_pt'>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Fakultas</label>";
					echo "<input type='text' class='form-control' name='pindahan_fakultas'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Program Studi</label>";
					echo "<input type='text' class='form-control' name='pindahan_prodi'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Akreditasi Program Studi</label>";
					echo "<input type='text' class='form-control' name='pindahan_akreditasi'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Jenjang Pendidikan</label>";
					echo "<input type='text' class='form-control' name='pindahan_jenjang'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Semester Terakhir</label>";
					echo "<input type='text' class='form-control' name='pindahan_semester'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>SKS Yang Telah Ditempuh</label>";
					echo "<input type='text' class='form-control' name='pindahan_sks'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
					
		  echo "</div>";
		echo "</div>";
		echo "<hr><button class='btn btn-primary' name='kirim' type='submit'>Simpan data</button><br><br>";
		echo "</form>";
	}
	public function ubah(){
		$profile 			= $this->msiakad_setting->getdata(); 
		$ret=array("success"=>false,"messages"=>array());
		
		$validation =  \Config\Services::validation();
		//cek data lama
		$id 		= $this->request->getVar('id');
		//dd($id);
		$nik		= $this->request->getVar('nik');
		$datalama 	= $this->msiakad_mahasiswadaftar->getdata($id);
		if($datalama->id == $id){
			$builder = $this->db->table($this->siakad_mahasiswa_mendaftar);
			$builder->where("nik",$nik);
			$builder->where("id !=",$id);
			$qcek = $builder->get();
			if($qcek->getRowArray() > 0){
				$rule_nik = 'required|is_unique[siakad_mahasiswa_mendaftar.nik]';
			}else{
				$rule_nik = 'required';
			}			
		}else{			
			$rule_nik = 'required|is_unique[siakad_mahasiswa_mendaftar.nik]';
		}
		if (!$this->validate([
			'nama' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nama harus diisi.'
				]
			],
			'tempat_lahir'=>[
				'rules' => 'required',
				'errors' => [
					'required' => 'Tempat lahir harus diisi.'
				]
			],
			'nik'=>[
				'rules' => $rule_nik,
				'errors' => [
					'required' => 'NIK harus diisi.',
					'is_unique' => 'Data sudah ada'
				]
			],
			'tanggal_lahir'=>[
				'rules' => 'required',
				'errors' => [
					'required' => 'Tanggal lahir harus dipilih.'
				]
			]
		]))
		{			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{
			$id = $this->request->getVar("id");
			/*
			$semester 			= $this->request->getVar("semester");
			$jenis_pendaftaran 	= $this->request->getVar("jenis_pendaftaran");
			$jalur_pendaftaran	= $this->request->getVar("jalur_pendaftaran");
			$kelas_pendaftaran	= $this->request->getVar("kelas_pendaftaran");
			
			$nama			= $this->request->getVar("nama");
			$jenis_kelamin	= $this->request->getVar("jenis_kelamin");
			$tempat_lahir	= $this->request->getVar("tempat_lahir");
			$tanggal_lahir	= $this->request->getVar("tanggal_lahir");
			$nik			= $this->request->getVar("nik");
			$agama			= $this->request->getVar("agama");
			$alamat			= $this->request->getVar("alamat");
			$rt				= $this->request->getVar("rt");
			$rw				= $this->request->getVar("rw");
			$dusun			= $this->request->getVar("dusun");
			$kelurahan		= $this->request->getVar("kelurahan");
			$kecamatan		= $this->request->getVar("kecamatan");
			$kota_kabupaten	= $this->request->getVar("kota_kabupaten");
			$kodepos		= $this->request->getVar("kodepos");
			$jenis_tinggal	= $this->request->getVar("jenis_tinggal");
			$hp				= $this->request->getVar("hp");
			$email			= $this->request->getVar("email");
			$no_kis			= $this->request->getVar("no_kis");
			$no_kip			= $this->request->getVar("no_kip");
			$no_kps			= $this->request->getVar("no_kps");
			$no_kks			= $this->request->getVar("no_kks");
			$kewarganegaraan	= $this->request->getVar("kewarganegaraan");
			$pend_terakhir	= $this->request->getVar("pend_terakhir");
			$sekolah_asal	= $this->request->getVar("sekolah_asal");
			$tahun_lulus	= $this->request->getVar("tahun_lulus");
			$prestasi		= $this->request->getVar("prestasi");
			
			$wali_nama		= $this->request->getVar("wali_nama");
			$wali_ktp		= $this->request->getVar("wali_ktp");
			$no_kip			= $this->request->getVar("no_kip");
			*/
			$id_prodi	= $this->request->getVar("id_prodi");
			$datain=array();
			foreach($this->request->getVar() as $key=>$val){
				if($key != "csrf_test_name"){
					$datain[$key] =  $this->request->getVar($key);
				}
			}
			$prodi = $this->msiakad_prodi->getdata($id_prodi,false,$profile->kodept);
			if($prodi){
				if(strlen($prodi->kode_prodi) > 0){
					$datain["kode_prodi"] = $prodi->kode_prodi;
				}
			}
			$query = $this->db->table($this->siakad_mahasiswa_mendaftar)->update($datain,array('id' => $id));		
			if($query){	
				$ret['messages'] = "Data berhasil diupdate";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal dimasukan";
			}			
		}	
		echo json_encode($ret);
	}
}
