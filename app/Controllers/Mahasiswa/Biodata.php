<?php 
namespace App\Controllers\Mahasiswa;
use App\Controllers\BaseController;

class Biodata extends BaseController
{
	protected $siakad_mahasiswa = 'siakad_mahasiswa';
	protected $feeder_biodatamahasiswa = 'feeder_biodatamahasiswa';
	
	public function index()
	{

		$data = [
			'title' => 'Data Mahasiswa',
			'judul' => 'Biodata Mahasiswa',
			'mn_biodata' => true
			
		];
		return view('mahasiswa/biodata',$data);
	}
	public function viewdata()
	{
		$profile			= $this->msiakad_setting->getdata();
		$dataprodi			= $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		$jenis_kelamin		= $this->mfungsi->jenis_kelamin();
		$agama				= $this->mreferensi->GetAgama();
		$jenis_tinggal		= $this->mfungsi->jenis_tinggal();
		$kewarganegaraan	= $this->mreferensi->GetNegara();
		$pend_terakhir		= $this->mreferensi->GetJenjangPendidikan();
		$penghasilan		= $this->mreferensi->GetPenghasilan();
		$alattransportasi	= $this->mreferensi->GetAlatTransportasi();
		$kebutuhankhusus	= $this->mreferensi->GetKebutuhanKhusus();
		
		
		$infoakun 			= $this->msiakad_akun->getakunmahasiswa(false,$this->session->username);
		
		$data 				= $this->msiakad_mahasiswa->getdata(false,$infoakun->id_mahasiswa);
		//echo "<pre>";
		//print_r($kebutuhankhusus);
		//echo "</pre>";
		
		echo "<form id='form_ubah' action='".base_url()."/akademik/mahasiswadaftar/ubah' method='post'>";
		echo "<input type='hidden' name='id_mahasiswa' value='{$data->id_mahasiswa}'>";
		echo "<input type='hidden' name='kodept' value='{$profile->kodept}'>";
		echo csrf_field();
		
		
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
				echo "<div class='col-sm-5'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama</label>";
					echo "<input type='text' name='nama' class='form-control' value='{$data->nama_mahasiswa}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-3'>";
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
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama Ibu</label>";
					echo "<input type='text' name='nama_ibu_kandung' class='form-control' value='{$data->nama_ibu_kandung}'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-5'>";
					echo "<div class='form-group'>";
						echo "<label>Tempat lahir</label>";
						echo "<input type='text' name='tempat_lahir' class='form-control' value='{$data->tempat_lahir}'>";
					echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-3'>";
					echo "<div class='form-group'>";
						echo "<label>Tanggal lahir</label>";
						echo "<input type='date' name='tanggal_lahir' class='form-control' value='{$data->tanggal_lahir}'>";
					echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Agama</label>";
					echo "<select name='id_agama' class='custom-select'>";
					foreach($agama as $key=>$val){
						echo "<option value='{$val->id_agama}'";
						if($data->id_agama == $val->id_agama) echo " selected='selected'";
						echo ">{$val->nama_agama}</option>";
					}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group'>";
				echo "<label>Kewarganegaraan </label>";
				echo "<select name='kewarganegaraan' class='custom-select'>";
					foreach($kewarganegaraan as $key=>$val){
						echo "<option value='{$val->id_negara}'";
						if($data->kewarganegaraan == $val->id_negara) echo " selected='selected'";
						echo ">{$val->nama_negara}</option>";
					}				  
				echo "</select>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>NIK</label>";
					echo "<input type='text' name='nik' class='form-control' value='{$data->nik}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>NISN</label>";
					echo "<input type='text' name='nisn' class='form-control' value='{$data->nisn}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>NPWP</label>";
					echo "<input type='text' name='npwp' class='form-control' value='{$data->npwp}'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='form-group'>";
				echo "<label>Jalan</label>";
				echo "<input type='text' name='alamat' class='form-control' value='{$data->jalan}'>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-3'>";
				  echo "<div class='form-group'>";
					echo "<label>RT</label>";
					echo "<input type='text' name='rt' class='form-control' value='{$data->rt}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-3'>";
				  echo "<div class='form-group'>";
					echo "<label>RW</label>";
					echo "<input type='text' name='rw' class='form-control' value='{$data->rw}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Dusun</label>";
					echo "<input type='text' name='dusun' class='form-control'  value='{$data->dusun}'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Kelurahan</label>";
					echo "<input type='text' name='kelurahan' class='form-control' value='{$data->kelurahan}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Kode Pos</label>";
					echo "<input type='text' name='kodepos' class='form-control' value='{$data->kode_pos}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Kecamatan</label>";
					echo "<input type='text' name='kecamatan' class='form-control' value='{$data->kecamatan}'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
					echo "<div class='form-group'>";
						echo "<label>Jenis tinggal</label>";
						echo "<select name='id_jenis_tinggal' class='custom-select'>";
							foreach($jenis_tinggal as $key=>$val){
								echo "<option value='{$key}'";
								if($data->id_jenis_tinggal == $key) echo " selected='selected'";
								echo ">{$val}</option>";
							}				  
						echo "</select>";
					echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
					echo "<div class='form-group'>";
						echo "<label>Alat Transportasi</label>";
						echo "<select name='id_alat_transportasi' class='custom-select'>";
							foreach($alattransportasi as $key=>$val){
								echo "<option value='{$val->id_alat_transportasi}'";
								if($data->id_alat_transportasi == $val->id_alat_transportasi) echo " selected='selected'";
								echo ">{$val->nama_alat_transportasi}</option>";
							}				  
						echo "</select>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Nomor Telepon</label>";
					echo "<input type='text' name='telepon' class='form-control' value='{$data->telepon}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Nomor Handphone</label>";
					echo "<input type='text' name='hp' class='form-control' value='{$data->handphone}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>E-mail Pribadi</label>";
					echo "<input type='text' name='email' class='form-control' value='{$data->email}'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Nomor Kartu Pra Sejahtera (KPS)</label>";
					echo "<input type='text' name='no_kps' class='form-control' value='{$data->penerima_kps}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Nomor Kartu Keluarga Sejahtera (KKS) </label>";
					echo "<input type='text' name='no_kks' class='form-control' value='{$data->no_kps}'>";
				  echo "</div>";
				echo "</div>";
				//kebutuhankhusus
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>ID Kebutuhan Khusus</label>";
					echo "<select name='id_kebutuhan_khusus_mahasiswa' class='custom-select'>";
						foreach($kebutuhankhusus as $key=>$val){
							echo "<option value='{$val->id_kebutuhan_khusus}'";
							if($data->id_kebutuhan_khusus_mahasiswa == $val->id_kebutuhan_khusus) echo " selected='selected'";
							echo ">{$val->nama_kebutuhan_khusus}</option>";
						}				  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";			
		  echo "</div>";//end bo	  
		echo "</div>"; // end card
		
		//DATA AYAH
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA ORANG TUA - AYAH</h3>";
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
					echo "<input type='text' class='form-control' name='nik_ayah' value='{$data->nik_ayah}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama</label>";
					echo "<input type='text' class='form-control' name='nama_ayah' value='{$data->nama_ayah}'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Tanggal Lahir</label>";
					echo "<input type='date' class='form-control' name='tanggal_lahir_ayah' value='{$data->tanggal_lahir_ayah}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Pendidikan Ayah</label>";
					echo "<select name='id_pendidikan_ayah' class='custom-select'>";
						foreach($pend_terakhir as $key=>$val){
							echo "<option value='{$val->id_jenjang_didik}'";
							if($data->id_pendidikan_ayah == $val->id_jenjang_didik) echo " selected='selected'";
							echo ">{$val->nama_jenjang_didik}</option>";
						}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Pekerjaan</label>";
					echo "<input type='text' class='form-control' name='id_pekerjaan_ayah' value='{$data->id_pekerjaan_ayah}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Penghasilan </label>";
					echo "<input type='text' class='form-control' name='id_penghasilan_ayah' value='{$data->id_penghasilan_ayah}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Kebutuhan Khusus</label>";
					echo "<select name='id_kebutuhan_khusus_ayah' class='custom-select'>";
						foreach($kebutuhankhusus as $key=>$val){
							echo "<option value='{$val->id_kebutuhan_khusus}'";
							if($data->id_kebutuhan_khusus_ayah == $val->id_kebutuhan_khusus) echo " selected='selected'";
							echo ">{$val->nama_kebutuhan_khusus}</option>";
						}				  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";					
		  echo "</div>";
		echo "</div>";
		//DATA IBU
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA ORANG TUA - IBU</h3>";
            echo "<div class='card-tools'>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='remove'><i class='fas fa-times'></i></button>";
			echo "</div>";
          echo "</div>";
		  echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12'>";
				  echo "<div class='form-group'>";
					echo "<label>NIK</label>";
					echo "<input type='text' class='form-control' name='nik_ibu' value='{$data->nik_ibu}'>";
				  echo "</div>";
				echo "</div>";
				
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Tanggal Lahir</label>";
					echo "<input type='date' class='form-control' name='tanggal_lahir_ibu' value='{$data->tanggal_lahir_ibu}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Pendidikan</label>";
					echo "<select name='id_pendidikan_ibu' class='custom-select'>";
						foreach($pend_terakhir as $key=>$val){
							echo "<option value='{$val->id_jenjang_didik}'";
							if($data->id_pendidikan_ibu == $val->id_jenjang_didik) echo " selected='selected'";
							echo ">{$val->nama_jenjang_didik}</option>";
						}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Pekerjaan</label>";
					echo "<input type='text' class='form-control' name='id_pekerjaan_ibu' value='{$data->id_pekerjaan_ibu}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Penghasilan </label>";
					echo "<input type='text' class='form-control' name='id_penghasilan_ibu' value='{$data->id_penghasilan_ibu}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-4'>";
				  echo "<div class='form-group'>";
					echo "<label>Kebutuhan Khusus </label>";
					echo "<select name='id_kebutuhan_khusus_ibu' class='custom-select'>";
						foreach($kebutuhankhusus as $key=>$val){
							echo "<option value='{$val->id_kebutuhan_khusus}'";
							if($data->id_kebutuhan_khusus_ibu == $val->id_kebutuhan_khusus) echo " selected='selected'";
							echo ">{$val->nama_kebutuhan_khusus}</option>";
						}				  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";					
		  echo "</div>";
		echo "</div>";
		//DATA WALI
		echo "<div class='card'>";
		  echo "<div class='card-header'>";
			echo "<h3 class='card-title'>DATA ORANG TUA - WALI</h3>";
            echo "<div class='card-tools'>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>";
              echo "<button type='button' class='btn btn-tool' data-card-widget='remove'><i class='fas fa-times'></i></button>";
			echo "</div>";
          echo "</div>";
		  echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-12'>";
				  echo "<div class='form-group'>";
					echo "<label>Nama</label>";
					echo "<input type='text' class='form-control' name='nama_wali' value='{$data->nama_wali}'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Tanggal Lahir</label>";
					echo "<input type='date' class='form-control' name='tanggal_lahir_wali' value='{$data->tanggal_lahir_wali}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Pendidikan</label>";
					echo "<select name='id_pendidikan_wali' class='custom-select'>";
						foreach($pend_terakhir as $key=>$val){
							echo "<option value='{$val->id_jenjang_didik}'";
							if($data->id_pendidikan_wali == $val->id_jenjang_didik) echo " selected='selected'";
							echo ">{$val->nama_jenjang_didik}</option>";
						}			  
					echo "</select>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Pekerjaan</label>";
					echo "<input type='text' class='form-control' name='id_pekerjaan_wali' value='{$data->id_pekerjaan_wali}'>";
				  echo "</div>";
				echo "</div>";
				echo "<div class='col-sm-6'>";
				  echo "<div class='form-group'>";
					echo "<label>Penghasilan </label>";
					echo "<input type='text' class='form-control' name='id_penghasilan_wali' value='{$data->id_penghasilan_wali}'>";
				  echo "</div>";
				echo "</div>";
			echo "</div>";					
		  echo "</div>";
		echo "</div>";
		
		echo "<hr><button class='btn btn-primary' name='kirim' type='submit'>Simpan data</button><br><br>";
		echo "</form>";
	}
	
}
