<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;

class Matakuliah extends BaseController
{
	protected $siakad_matakuliah = 'siakad_matakuliah';
	protected $feeder_matakuliah = 'feeder_matakuliah';

	public function index()
	{

		$data = [
			'title' => 'Data Akademik',
			'judul' => 'Mahasiswa',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_matakuliah'=>true
			
		];
		return view('akademik/matakuliah',$data);
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
		$data 		= $this->msiakad_matakuliah->getdata(false,false,false,$profile->kodept);
		
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Kode Matakuliah</th><th>Nama Mata Kuliah</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='4'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->kode_matakuliah}</td>";
				echo "<td>{$val->nama_matakuliah}</td>";
				echo "<td>";
					echo "<a href='#modalku' data-toggle='modal' class='modalButton' data-src='".base_url()."/akademik/matakuliah/edit/{$val->id_matakuliah}' title='Edit data'>edit</a>";
					echo " - <a>hapus</a>";
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function tambah(){
		$profile 	= $this->msiakad_setting->getdata(); 
		$jenjang_pendidikan = $this->mreferensi->GetJenjangPendidikan();
		$GetJenisMatakuliah = $this->mreferensi->GetJenisMatakuliah();
		$prodi = $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		
		echo "<form method='post' id='form_tambah' action='".base_url()."/akademik/matakuliah/create'>";
		echo csrf_field(); 
		echo "<div class='row'>";
			echo "<div class='col-sm-3'>";
				echo "<div class='form-group'>";
					echo "<label for='kode_matakuliah'>Kode matakuliah</label>";
					echo "<input type='text' class='form-control' name='kode_matakuliah' id='kode_matakuliah'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-9'>";
				echo "<div class='form-group'>";
					echo "<label for='nama_matakuliah'>Nama Matakuliah</label>";
					echo "<input type='text' name='nama_matakuliah' class='form-control' id='nama_matakuliah'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		
		echo "<div class='form-group'>";
			echo "<label for='id_prodi'>Program studi pengampu</label>";
			echo "<select name='id_prodi' class='form-control' id='id_prodi'>";
			if($prodi){
				foreach($prodi as $key=>$val){
					echo "<option value='{$val->id_prodi}'>{$val->nama_prodi}</option>";
				}
			}
			echo "</select>";
		echo "</div>";
		echo "<div class='form-group'>";
			echo "<label for='id_jenis_matakuliah'>Jenis Matakuliah</label>";
			echo "<select name='id_jenis_matakuliah' class='form-control' id='id_jenis_matakuliah'>";
			if($GetJenisMatakuliah){
				foreach($GetJenisMatakuliah as $key=>$val){
					echo "<option value='{$key}'>{$val}</option>";
				}
			}
			echo "</select>";
		echo "</div>";
		
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='sks_tatapmuka'>Bobot Tatap Muka</label>";
					echo "<input type='text' class='form-control' name='sks_tatapmuka' id='sks_tatapmuka'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='sks_praktek'>Bobot Praktikum</label>";
					echo "<input type='text' class='form-control' name='sks_praktek' id='sks_praktek'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";		
				echo "<div class='form-group'>";
					echo "<label for='sks_praktek_lapangan'>Bobot Praktek Lapangan</label>";
					echo "<input type='text' class='form-control' name='sks_praktek_lapangan' id='sks_praktek_lapangan'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='sks_simulasi'>Bobot Simulasi</label>";
					echo "<input type='text' class='form-control' name='sks_simulasi' id='sks_simulasi'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
				
		echo "<div class='form-group'>";
			echo "<label for='metode_kuliah'>Metode Pembelajaran</label>";
			echo "<input type='text' class='form-control' name='metode_kuliah' id='metode_kuliah'>";
		echo "</div>";
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='tanggal_mulai_efektif'>Tanggal Mulai Efektif</label>";
					echo "<input type='date' class='form-control' name='tanggal_mulai_efektif' id='tanggal_mulai_efektif'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='tanggal_akhir_efektif'>Tanggal Akhir Efektif</label>";
					echo "<input type='date' class='form-control' name='tanggal_akhir_efektif' id='tanggal_akhir_efektif'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
			
		echo "<div><button type='submit' class='btn btn-success' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	
	public function create(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata(); 
		$id_prodi 	= $this->request->getVar("id_prodi"); 
		//cek dulu apakah sudah ada
		
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'kode_matakuliah' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'kode matakuliah harus diisi.'
				]
			],
			'nama_matakuliah'=>[
				'rules' => 'required',
				'errors' => [
					'required' => 'nama matakuliah harus diisi.'
				]
			]
		]))
		{			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{
			
			$datain=array();
			foreach($this->request->getVar() as $key=>$val){
				if(!in_array($key,array("csrf_test_name","id_prodi"))){
					$datain[$key] =  $this->request->getVar($key);
				}
			}
			$datain["kodept"] = $profile->kodept;
			
			$prodi = $this->msiakad_prodi->getdata($id_prodi,false,$profile->kodept);
			if($prodi){
				if(strlen($prodi->kode_prodi) > 0){
					$datain["kode_prodi"] = $prodi->kode_prodi;
				}
				if(strlen($prodi->id_prodi_ws) > 0){
					$datain["id_prodi_ws"] = $prodi->id_prodi_ws;
				}
			}
			
			$query = $this->db->table($this->siakad_matakuliah)->insert($datain);		
			if($query){	
				$ret['messages'] = "Data berhasil dimasukan";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal dimasukan";
			}			
		}	
		echo json_encode($ret);
	}
	
	public function edit($id=false){
		$profile 	= $this->msiakad_setting->getdata();
		if(!$id){
			echo "Error data.."; exit();
		}
		$data	= $this->msiakad_matakuliah->getdata($id,false,false,$profile->kodept);
		$jenjang_pendidikan = $this->mreferensi->GetJenjangPendidikan();
		$GetJenisMatakuliah = $this->mreferensi->GetJenisMatakuliah();
		$prodi	= $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		
		echo "<form method='post' id='form_ubah' action='".base_url()."/akademik/matakuliah/update'>";
		echo "<input type='hidden' name='id_matakuliah' value='{$data->id_matakuliah}'>";
		echo csrf_field(); 
		echo "<div class='row'>";
			echo "<div class='col-sm-3'>";
				echo "<div class='form-group'>";
					echo "<label for='kode_matakuliah'>Kode matakuliah</label>";
					echo "<input type='text' class='form-control' name='kode_matakuliah' id='kode_matakuliah' value='{$data->kode_matakuliah}'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-9'>";
				echo "<div class='form-group'>";
					echo "<label for='nama_matakuliah'>Nama Matakuliah</label>";
					echo "<input type='text' name='nama_matakuliah' class='form-control' id='nama_matakuliah' value='{$data->nama_matakuliah}'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		
		echo "<div class='form-group'>";
			echo "<label for='id_prodi'>Program studi pengampu</label>";
			echo "<select name='id_prodi' class='form-control' id='id_prodi'>";
			if($prodi){
				foreach($prodi as $key=>$val){
					echo "<option value='{$val->id_prodi}'";
					if($data->kode_prodi == $val->kode_prodi) echo " selected='selected'";
					echo ">{$val->nama_prodi}</option>";
				}
			}
			echo "</select>";
		echo "</div>";
		echo "<div class='form-group'>";
			echo "<label for='id_jenis_matakuliah'>Jenis Matakuliah</label>";
			echo "<select name='id_jenis_matakuliah' class='form-control' id='id_jenis_matakuliah'>";
			if($GetJenisMatakuliah){
				foreach($GetJenisMatakuliah as $key=>$val){
					echo "<option value='{$key}'";
					if($data->id_jenis_matakuliah == $key) echo " selected='selected'";
					echo ">{$val}</option>";
				}
			}
			echo "</select>";
		echo "</div>";
		
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='sks_tatapmuka'>Bobot Tatap Muka</label>";
					echo "<input type='text' class='form-control' name='sks_tatapmuka' id='sks_tatapmuka' value='{$data->sks_tatapmuka}'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='sks_praktek'>Bobot Praktikum</label>";
					echo "<input type='text' class='form-control' name='sks_praktek' id='sks_praktek' value='{$data->sks_praktek}'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";		
				echo "<div class='form-group'>";
					echo "<label for='sks_praktek_lapangan'>Bobot Praktek Lapangan</label>";
					echo "<input type='text' class='form-control' name='sks_praktek_lapangan' id='sks_praktek_lapangan' value='{$data->sks_praktek_lapangan}'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='sks_simulasi'>Bobot Simulasi</label>";
					echo "<input type='text' class='form-control' name='sks_simulasi' id='sks_simulasi' value='{$data->sks_simulasi}'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
				
		echo "<div class='form-group'>";
			echo "<label for='metode_kuliah'>Metode Pembelajaran</label>";
			echo "<input type='text' class='form-control' name='metode_kuliah' id='metode_kuliah' value='{$data->metode_kuliah}'>";
		echo "</div>";
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='tanggal_mulai_efektif'>Tanggal Mulai Efektif</label>";
					echo "<input type='date' class='form-control' name='tanggal_mulai_efektif' id='tanggal_mulai_efektif' value='{$data->tanggal_mulai_efektif}'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='tanggal_akhir_efektif'>Tanggal Akhir Efektif</label>";
					echo "<input type='date' class='form-control' name='tanggal_akhir_efektif' id='tanggal_akhir_efektif' value='{$data->tanggal_akhir_efektif}'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
			
		echo "<div><button type='submit' class='btn btn-success' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	public function update(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata(); 
		$id_prodi 	= $this->request->getVar("id_prodi"); 
		//cek dulu apakah sudah ada
		$id_matakuliah = $this->request->getVar("id_matakuliah");
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'kode_matakuliah' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'kode matakuliah harus diisi.'
				]
			],
			'nama_matakuliah'=>[
				'rules' => 'required',
				'errors' => [
					'required' => 'nama matakuliah harus diisi.'
				]
			]
		]))
		{			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{
			
			$datain=array();
			foreach($this->request->getVar() as $key=>$val){
				if(!in_array($key,array("csrf_test_name","id_prodi"))){
					$datain[$key] =  $this->request->getVar($key);
				}
			}
			$datain["kodept"] = $profile->kodept;
			
			$prodi = $this->msiakad_prodi->getdata($id_prodi,false,$profile->kodept);
			if($prodi){
				if(strlen($prodi->kode_prodi) > 0){
					$datain["kode_prodi"] = $prodi->kode_prodi;
				}
				if(strlen($prodi->id_prodi_ws) > 0){
					$datain["id_prodi_ws"] = $prodi->id_prodi_ws;
				}
			}
			
			$query = $this->db->table($this->siakad_matakuliah)->update($datain,array("id_matakuliah"=>$id_matakuliah));		
			if($query){	
				$ret['messages'] = "Data berhasil diupdate";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal diupdate";
			}			
		}	
		echo json_encode($ret);
	}
	public function getmatakuliahpddikti(){		
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$data_matakuliah_feeder = $this->msiakad_matakuliah->getdatapddikti(false,$profile->kodept);
		if(!$data_matakuliah_feeder){
			$ret["messages"] = "Tidak ada data PDDIKTI";
		}else{
			$jum=0;
			foreach($data_matakuliah_feeder as $key=>$val){
				//cek data dulu
				$cekdata = $this->msiakad_matakuliah->getdata(false,$val->id_matkul,false,$profile->kodept);
				if(!$cekdata){// jika data belum ada
					$dataprodi = $this->msiakad_prodi->getdata(false,$val->id_prodi);
					
					$datain = array("id_matkul_ws"=>$val->id_matkul,
									"kodept"=>$val->kode_perguruan_tinggi,
									"id_prodi_ws"=>$val->id_prodi,
									"kode_prodi"=>$dataprodi->kode_prodi,
									"ada_acara_praktek"=>$val->ada_acara_praktek,
									"ada_bahan_ajar"=>$val->ada_bahan_ajar,
									"ada_diktat"=>$val->ada_diktat,
									"ada_sap"=>$val->ada_sap,
									"ada_silabus"=>$val->ada_silabus,
									"id_jenis_matakuliah"=>$val->id_jenis_mata_kuliah,
									"id_kelompok_matakuliah"=>$val->id_kelompok_mata_kuliah,
									"kode_matakuliah"=>$val->kode_mata_kuliah,
									"metode_kuliah"=>$val->metode_kuliah,
									"nama_matakuliah"=>$val->nama_mata_kuliah,
									"sks_matakuliah"=>$val->sks_mata_kuliah,
									"sks_praktek"=>$val->sks_praktek,
									"sks_praktek_lapangan"=>$val->sks_praktek_lapangan,
									"sks_simulasi"=>$val->sks_simulasi,
									"sks_tatapmuka"=>$val->sks_tatap_muka,
									"tanggal_mulai_efektif"=>$val->tanggal_mulai_efektif,
									"tanggal_akhir_efektif"=>$val->tanggal_selesai_efektif);
					$query = $this->db->table($this->siakad_matakuliah)->insert($datain);
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
}
