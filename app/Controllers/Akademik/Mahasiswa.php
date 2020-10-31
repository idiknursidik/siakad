<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
		
class Mahasiswa extends BaseController
{
	protected $siakad_mahasiswa = 'siakad_mahasiswa';
	protected $feeder_biodatamahasiswa = 'feeder_biodatamahasiswa';
	protected $siakad_riwayatpendidikan = 'siakad_riwayatpendidikan';
	
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
		echo "<hr>";
		echo "<div class='btn-group'>";
			 echo "<a name='importmahasiswa' href='#modalku' data-toggle='modal' title='Import data Mahasiswa' data-src='".base_url()."/akademik/mahasiswa/importmahasiswa' class='btn btn-success modalButton'> Import</a>";
			 echo "<a href='".base_url()."/akademik/mahasiswa/exportmahasiswa' class='btn btn-primary'> Exsport</a>";
		echo "</div>";
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
			echo "<hr>";
			echo "<a href='#modalku' class='btn btn-primary modalButton' data-src='".base_url()."/akademik/mahasiswa/formhistorypendidikan/{$id_mahasiswa}' data-toggle='modal' title='Tambah riwayat pendidikan'>tambah data</a>";
		}
		
	}
	public function formhistorypendidikan($id_mahasiswa){
		?>
		<script>
		$(function(){
			$('.select2').select2();
		})
		</script>
		<?php
		$profile 	= $this->msiakad_setting->getdata();
		$jenispendaftaran	= $this->mreferensi->GetJenisPendaftaran();
		$jalurpendaftaran	= $this->mreferensi->GetJalurMasuk();
		$pembiayaanawal		= $this->mreferensi->GetPembiayaan();
		$prodi 				= $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		if($this->request->isAJAX()){
			echo "<form id='form_tambahpendidikan' method='post' action='".base_url()."/akademik/mahasiswa/proseshistorypendidikan'>";
			echo "<input type='hidden' name='id_mahasiswa' value='{$id_mahasiswa}'>";
			echo "<table class='table table-striped'>";
			echo "<tr><th width='30%'>NIM</th><td><input type='text' class='form-control' name='nim'></td></tr>";
			echo "<tr><th>Jenis Pendaftaran</th><td><select class='form-control select2' name='id_jenis_daftar' style='width:100%'>";
			if($jenispendaftaran){
				foreach($jenispendaftaran as $key=>$val){
					echo "<option value='{$val->id_jenis_daftar}'";
					if($this->request->getVar('jenispendaftaran') == $val->id_jenis_daftar) echo " selected='selected'";
					echo ">{$val->nama_jenis_daftar}</option>";
				}
			}
			echo "</select></td></tr>";
			echo "<tr><th>Jalur Pendaftaran</th><td><select class='form-control select2' name='id_jalur_daftar' style='width:100%'>";
			if($jalurpendaftaran){
				foreach($jalurpendaftaran as $key=>$val){
					echo "<option value='{$val->id_jalur_masuk}'";
					if($this->request->getVar('jalurpendaftaran') == $val->id_jalur_masuk) echo " selected='selected'";
					echo ">{$val->nama_jalur_masuk}</option>";
				}
			}
			echo "</select></td></tr>";
			echo "<tr><th>Periode Pendaftaran</th><td><select class='form-control' name='periodependaftaran'>";
			for($periode='2000'; $periode<=date("Y"); $periode++){
				foreach(array("1","2") as $value){
					$periodependaftaran = $periode.$value;					
					echo "<option value='{$periodependaftaran}'";
					if(date("Y") == $periode) echo " selected='selected'";
					echo ">{$periodependaftaran}</option>";
				}
			}
			echo "</select></td></tr>";
			echo "<tr><th>Tanggal Masuk</th><td><input type='date' class='form-control' name='tanggalmasuk'></td></tr>";
			echo "<tr><th>Pembiayaan Awal</th><td><select class='form-control' name='id_pembiayaan'>";
			if($pembiayaanawal){
				foreach($pembiayaanawal as $key=>$val){
					echo "<option value='{$val->id_pembiayaan}'";
					if($this->request->getVar('pembiayaanawal') == $val->id_pembiayaan) echo " selected='selected'";
					echo ">{$val->nama_pembiayaan}</option>";
				}
			}
			echo "</select></td></tr>";
			echo "<tr><th>Biaya Masuk</th><td><input type='text' class='form-control' name='biayamasuk'></td></tr>";
			echo "<tr><th>Perguruan Tinggi </th><td>{$profile->kodept}</td></tr>";
			echo "<tr><th>Program Studi</th><td><select class='form-control select2' name='prodi' style='width:100%'>";
			if($prodi){
				foreach($prodi as $key=>$val){
					echo "<option value='{$val->id_prodi}'";
					if($this->request->getVar('prodi') == $val->id_prodi) echo " selected='selected'";
					echo ">{$val->nama_prodi} - {$val->nama_jenjang_didik}</option>";
				}
			}
			echo "</select></td></tr>";
			echo "<tr><th colspan='2'>Selain jenis pendaftaran peserta didik baru, Silakan lengkapi data berikut </th></tr>";
			echo "<tr><th>Jumlah sks di akui</th><td><input type='text' class='form-control' name='sksdiakui'></td></tr>";
			echo "<tr><th>Asal Perguruan Tinggi</th><td><input type='text' class='form-control' name='ptasal'></td></tr>";
			echo "<tr><th>Asal Program Studi </th><td><input type='text' class='form-control' name='prodiasal'></td></tr>";
			echo "</table>";
			echo "<div class='float-right'> <button class='btn bg-maroon pull-right' type='submit' id='btnKirim_form_tambahpendidikan'>Simpan</button></div>";
		}
	}
	public function proseshistorypendidikan(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'nim'=>[
				'rules' => 'required|is_unique[siakad_riwayatpendidikan.nim]',
				'errors' => [
					'required' => 'NIM harus diisi.',
					'is_unique' => 'NIM sudah ada.'
				]
			],
			'tanggalmasuk'=>[
				'rules' => 'required',
				'errors' => [
					'required' => 'Tanggal masuk harus diisi.'
				]
			],
			'biayamasuk'=>[
				'rules' => 'required',
				'errors' => [
					'required' => 'Biaya Masuk masuk harus diisi.'
				]
			]
		]))
		{			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{
		
			$prodi			= $this->request->getVar("prodi");
			$id_mahasiswa	= $this->request->getVar("id_mahasiswa");
			$kodept			= $this->request->getVar("kodept");
			
			$biayamasuk		= $this->request->getVar("biayamasuk");
			$id_jenis_daftar	= $this->request->getVar("id_jenis_daftar");
			$id_jalur_daftar	= $this->request->getVar("id_jalur_daftar");
			$id_pembiayaan	= $this->request->getVar("id_pembiayaan");
			$tanggal_daftar	= $this->request->getVar("tanggalmasuk");
			$id_periode_masuk	= $this->request->getVar("periodependaftaran");
			$nim			= $this->request->getVar("nim");
			
			$sksdiakui		= $this->request->getVar("sksdiakui");
			$ptasal			= $this->request->getVar("ptasal");
			$prodiasal		= $this->request->getVar("prodiasal");
			
			$getprodi = $this->msiakad_prodi->getdata($prodi,false,$profile->kodept);
			$datain = array("id_prodi"=>$prodi,
							"id_mahasiswa"=>$id_mahasiswa,
							"kodept"=>$profile->kodept,
							"kode_prodi"=>$getprodi->kode_prodi,
							"biaya_masuk"=>$biayamasuk,
							"id_jalur_daftar"=>$id_jalur_daftar,
							"id_jenis_daftar"=>$id_jenis_daftar,
							"id_pembiayaan"=>$id_pembiayaan,
							"id_periode_masuk"=>$id_periode_masuk,
							"tanggal_daftar"=>$tanggal_daftar,
							"nim"=>$nim
							);
			if($id_jenis_daftar != 1){
				$datain = array("sksdiakui"=>$sksdiakui,
								"ptasal"=>$ptasal,
								"prodiasal"=>$prodiasal
								);
			}				
			//insert data
			$insert = $this->db->table($this->siakad_riwayatpendidikan)->insert($datain);
			if($insert){
				$ret['messages'] = "Data sudah dimasukan";
				$ret['success'] = true;
			}
		}
		echo json_encode($ret);
	}
	public function getkrs($id_mahasiswa){
		echo "H KRS {$id_mahasiswa}";
	}
	
	public function getbiodata($id_mahasiswa){
		if($this->request->isAJAX()){
			$data  = $this->msiakad_mahasiswa->getdata(false,$id_mahasiswa);
			echo "<table class='table table-head-fixed text-nowrap'>";
			echo "<tbody>";
				echo "<tr><td>Nama</td><td>{$data->nama_mahasiswa}</td></tr>";
			echo "</tbody>";
			echo "</table>";
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}
	}
	
	public function importmahasiswa(){
		if($this->request->isAJAX()){
			echo "<div class='alert alert-info'><a href='".base_url()."/public/template/sample_mhs_baru.xlsx'>Contoh File</a></div>";
			echo form_open_multipart(base_url().'/akademik/mahasiswa/proses_importmahasiswa',array('id'=>'form_importmahasiswa'));
				
			echo form_label('File Excel');
			$trx_file = [
				'type'  => 'file',
				'name'  => 'trx_file',
				'id'    => 'trx_file',
				'class' => 'form-control'
			];
			echo form_upload($trx_file); 
			
			echo "<hr><button type='submit' id='btnSubmit_form_importmahasiswa' class='btn btn-primary float-right'>Import Data</button>";
			echo form_close();
		}
	}
	
	public function proses_importmahasiswa(){
		$ret=array("success"=>false,"messages"=>array());
		$validation =  \Config\Services::validation();	 
		$file = $this->request->getFile('trx_file');	 
		$data = array(
			'trx_file'           => $file,
		);	 
		if($validation->run($data, 'transaction') == FALSE){
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}	 
		} else {	 
			// ambil extension dari file excel
			$extension = $file->getClientExtension();
			 
			// format excel 2007 ke bawah
			if('xls' == $extension){
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			// format excel 2010 ke atas
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			 
			$spreadsheet = $reader->load($file);
			$data = $spreadsheet->getActiveSheet()->toArray();
			
			
			foreach($data as $idx => $val){				 
				// lewati baris ke 0 pada file excel
				// dalam kasus ini, array ke 0 adalahpara title
				if($idx == 0) {
					continue;
				}
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
				//cek data
				$cekmhs = $this->db->table($this->siakad_mahasiswa,array("nama_mahasiswa"=>$val[1],"nik"=>$val[5]))->get();
				if($cekmhs->getRowArray() == 0){
					$simpan = $this->db->table($this->siakad_mahasiswa)->insert($datain);
				}				
			}
	 
			if($simpan)
			{
				$ret = array('success'=>true,'messages'=>'Imported Transaction successfully');
				 
			}
		}
		echo json_encode($ret);
	}
	public function exportmahasiswa(){		
		// ambil data transaction dari database
		$profile 	= $this->msiakad_setting->getdata(); 
		$data 		= $this->msiakad_mahasiswa->getdata(false,false,false,false,$profile->kodept);
		// panggil class Sreadsheet baru
		$spreadsheet = new Spreadsheet;
		// Buat custom header pada file excel
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A1', 'No')
					->setCellValue('B1', 'Nama')
					->setCellValue('C1', 'Nik')
					->setCellValue('D1', 'Nik');
		// define kolom dan nomor
		$kolom = 2;
		$nomor = 1;
		// tambahkan data transaction ke dalam file excel
		foreach($data as $key=>$val) {
	 
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue('A' . $kolom, $nomor)
						->setCellValue('B' . $kolom, $val->nama_mahasiswa)
						->setCellValueExplicit('C' . $kolom, $val->nik,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
						->setCellValueExplicit('D' . $kolom, $val->nik,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
	 
			$kolom++;
			$nomor++;
	 
		}
		$styleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
		];
		$kolom = $kolom-1;
		$spreadsheet->getActiveSheet()->getStyle('A1:D'.$kolom)->applyFromArray($styleArray);
		
		// download spreadsheet dalam bentuk excel .xlsx
		$writer = new Xlsx($spreadsheet);
		
		//header('Content-Type: application/vnd.ms-excel');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Data_mahasiswa.xlsx"');
		header('Cache-Control: max-age=0');
	 
		$writer->save('php://output');
		exit();
	}
}
