<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
 
class Dosenmengajar extends BaseController
{
	protected $siakad_dosenmengajar = 'siakad_dosenmengajar';
	protected $feeder_dosenmengajar = 'feeder_dosenmengajar';
	
	public function index()
	{
		
		$data = [
			'title' => 'Data Akademik',
			'judul' => 'Data Akademik Dosen Mengajar',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_dosenmengajar'=>true
			
		];
		return view('akademik/dosenmengajar',$data);
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
		$data 		= $this->msiakad_dosenmengajar->getdata(false,false,$profile->kodept);
		
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Nama Dosen</th><th>Kelas</th><th>Matakuliah</th><th>Semester</th><th>Rencana</th><th>Realisasi</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='8'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nidn}</td>";
				echo "<td>{$val->nama_kelas_kuliah}</td>";
				echo "<td>{$val->kode_mata_kuliah}</td>";
				echo "<td>{$val->id_semester}</td>";
				echo "<td>{$val->rencana_tatap_muka}</td>";
				echo "<td>{$val->realisasi_tatap_muka}</td>";
				echo "<td>";
					echo "<a href='#modalku' data-toggle='modal' class='modalButton' data-src='".base_url()."/akademik/dosenmengajar/edit/{$val->id_aktivitas_mengajar}' title='Edit data'>edit</a>";
					echo " - <a href='#' name='hapusdata' data-src='".base_url()."/akademik/dosenmengajar/hapusdata' id_kurikulum='{$val->id_aktivitas_mengajar}'>hapus</a>";
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function hapusdata(){
		$ret=array("success"=>false,"messages"=>array());
		$id_kurikulum = $this->request->getVar("id_kurikulum");
		$this->db->table()->delete();
		echo json_encode($ret);
	}
	public function tambah(){
		$profile 	= $this->msiakad_setting->getdata(); 		
		$jenjang_pendidikan = $this->mreferensi->GetJenjangPendidikan();		
		$prodi = $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		$semester = $this->mreferensi->GetSemester();
		echo "<form method='post' id='form_tambah' action='".base_url()."/akademik/kurikulum/create'>";
		echo csrf_field(); 
		
		echo "<div class='form-group'>";
			echo "<label for='nama_kurikulum'>Nama Kurikulum</label>";
			echo "<input type='text' class='form-control' name='nama_kurikulum' id='nama_kurikulum'>";
		echo "</div>";	
		
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='id_prodi'>Program Studi</label>";
					echo "<select name='id_prodi' class='form-control' id='id_prodi'>";
					if($prodi){
						foreach($prodi as $key=>$val){
							if(in_array($val->id_prodi,explode(",",session()->akses))){
								echo "<option value='{$val->id_prodi}'>{$val->nama_prodi} {$val->nama_jenjang_didik}</option>";
							}
						}
					}
					echo "</select>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='id_semester'>Mulai Berlaku</label>";
					echo "<select name='id_semester' class='form-control' id='id_semester'>";
					if($semester){
						foreach($semester as $key=>$val){
							echo "<option value='{$val->id_semester}'>{$val->nama_semester}</option>";
						}
					}
					echo "</select>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='jumlah_sks_wajib'>Jumlah Bobot Matakuliah Wajib</label>";
					echo "<input type='text' class='form-control' name='jumlah_sks_wajib' id='jumlah_sks_wajib'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='jumlah_sks_pilihan'>Jumlah Bobot Matakuliah Pilihan </label>";
					echo "<input type='text' class='form-control' name='jumlah_sks_pilihan' id='jumlah_sks_pilihan'>";
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
		$nama_kurikulum	= $this->request->getVar("nama_kurikulum");
		$id_semester = 	$this->request->getVar("id_semester");
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'nama_kurikulum'=>[
				'rules' => 'required|is_unique[siakad_kurikulum.nama_kurikulum,id_prodi_ws]',
				'errors' => [
					'required' => 'nama kurikulum harus diisi.',
					'is_unique' => 'Data sudah ada.'
				]
			],
			'jumlah_sks_wajib'=>[
				'rules' => 'required|numeric',
				'errors' => [
					'required' => 'Jumlah sks wajib harus diisi.',
					'numeric'=>'Jumlah sks harus angka'
				]
			],
			'jumlah_sks_pilihan'=>[
				'rules' => 'required|numeric',
				'errors' => [
					'required' => 'Jumlah sks pilihan harus diisi.',
					'numeric'=>'Jumlah sks harus angka'
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
			$datain["id_prodi"] = $id_prodi;
			
			$semester = $this->mreferensi->GetSemester($id_semester);
			if($semester){
				$datain["semester_mulai_berlaku"] = $semester->nama_semester;
			}
			
			$prodi = $this->msiakad_prodi->getdata($id_prodi,false,$profile->kodept);
			if($prodi){
				if(strlen($prodi->kode_prodi) > 0){
					$datain["kode_prodi"] = $prodi->kode_prodi;
				}
				if(strlen($prodi->id_prodi_ws) > 0){
					$datain["id_prodi_ws"] = $prodi->id_prodi_ws;
				}
			}
			
			$query = $this->db->table($this->siakad_kurikulum)->insert($datain);		
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
		$data	= $this->msiakad_kurikulum->getdata($id,false,false,$profile->kodept);
		//dd($data);
		
		$profile 	= $this->msiakad_setting->getdata(); 		
		$jenjang_pendidikan = $this->mreferensi->GetJenjangPendidikan();		
		$prodi = $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		$semester = $this->mreferensi->GetSemester();
		
		echo "<form method='post' id='form_ubah' action='".base_url()."/akademik/kurikulum/update'>";
		echo "<input type='hidden' name='id_kurikulum' value='{$data->id_kurikulum}'";
		echo csrf_field(); 
		
		echo "<div class='form-group'>";
			echo "<label for='nama_kurikulum'>Nama Kurikulum</label>";
			echo "<input type='text' class='form-control' name='nama_kurikulum' id='nama_kurikulum' value='{$data->nama_kurikulum}'>";
		echo "</div>";	
		
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='id_prodi'>Program Studi</label>";
					echo "<select name='id_prodi' class='form-control' id='id_prodi'>";
					if($prodi){
						foreach($prodi as $key=>$val){
							if(in_array($val->id_prodi,explode(",",session()->akses))){
								echo "<option value='{$val->id_prodi}'";
								if($data->id_prodi == $val->id_prodi) echo " selected='selected'";
								echo ">{$val->nama_prodi} {$val->nama_jenjang_didik}</option>";
							}
						}
					}
					echo "</select>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='id_semester'>Mulai Berlaku</label>";
					echo "<select name='id_semester' class='form-control' id='id_semester'>";
					if($semester){
						foreach($semester as $key=>$val){
							echo "<option value='{$val->id_semester}'";
							if($data->id_semester == $val->id_semester) echo " selected='selected'";
							echo ">{$val->nama_semester}</option>";
						}
					}
					echo "</select>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='jumlah_sks_wajib'>Jumlah Bobot Matakuliah Wajib</label>";
					echo "<input type='text' class='form-control' name='jumlah_sks_wajib' id='jumlah_sks_wajib' value='{$data->jumlah_sks_wajib}'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='jumlah_sks_pilihan'>Jumlah Bobot Matakuliah Pilihan </label>";
					echo "<input type='text' class='form-control' name='jumlah_sks_pilihan' id='jumlah_sks_pilihan' value='{$data->jumlah_sks_pilihan}'>";
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
		$id_kurikulum = $this->request->getVar("id_kurikulum");
		$nama_kurikulum = $this->request->getVar("nama_kurikulum");
		$id_semester = 	$this->request->getVar("id_semester");
			//cek dulu apakah sudah ada
		$cekdata = $this->db->table($this->siakad_kurikulum)->getWhere(['id_kurikulum' => $id_kurikulum]);
		if($cekdata->getRowArray() > 0){
			$data_cek = $cekdata->getResult();
			if($data_cek[0]->nama_kurikulum != $nama_kurikulum){
				$rule_nama_kurikulum = 'required|is_unique[siakad_kurikulum.nama_kurikulum,id_prodi_ws]';
			}else{
				$rule_nama_kurikulum = 'required';
			}
		}else{
			$rule_nama_kurikulum = 'required|is_unique[siakad_kurikulum.nama_kurikulum,id_prodi_ws]';
		}
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'nama_kurikulum' => [
				'rules' => $rule_nama_kurikulum,
				'errors' => [
					'required' => 'kode kurikulum harus diisi.',
					'is_unique' => 'Data sudah ada.'
				]
			],
			'jumlah_sks_wajib'=>[
				'rules' => 'required|numeric',
				'errors' => [
					'required' => 'Jumlah sks wajib harus diisi.',
					'numeric'=>'Jumlah sks harus angka'
				]
			],
			'jumlah_sks_pilihan'=>[
				'rules' => 'required|numeric',
				'errors' => [
					'required' => 'Jumlah sks pilihan harus diisi.',
					'numeric'=>'Jumlah sks harus angka'
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
			$datain["id_prodi"] = $id_prodi;
			
			$semester = $this->mreferensi->GetSemester($id_semester);
			if($semester){
				$datain["semester_mulai_berlaku"] = $semester->nama_semester;
			}
			
			$prodi = $this->msiakad_prodi->getdata($id_prodi,false,$profile->kodept);
			if($prodi){
				if(strlen($prodi->kode_prodi) > 0){
					$datain["kode_prodi"] = $prodi->kode_prodi;
				}
				if(strlen($prodi->id_prodi_ws) > 0){
					$datain["id_prodi_ws"] = $prodi->id_prodi_ws;
				}
			}
			
			$query = $this->db->table($this->siakad_kurikulum)->update($datain,array("id_kurikulum"=>$id_kurikulum));		
			if($query){	
				$ret['messages'] = "Data berhasil diupdate";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal diupdate";
			}			
		}	
		echo json_encode($ret);
	}
	public function getdosenmengajarpddikti(){
		if ($this->request->isAJAX()){		
			$ret=array("success"=>false,"messages"=>array());		
			$profile 	= $this->msiakad_setting->getdata();
			$data_dosenmengajar_feeder = $this->msiakad_dosenmengajar->getdatapddikti(false,false,$profile->kodept);
			
			if(!$data_dosenmengajar_feeder){
				$ret["messages"] = "Tidak ada data PDDIKTI";
			}else{
				$jum=0;
				foreach($data_dosenmengajar_feeder as $key=>$val){
					//cek data dulu
					$arraywhere = ['id_aktivitas_mengajar_ws' => $val->id_aktivitas_mengajar, 'kodept' => $profile->kodept];
					$builder = $this->db->table($this->siakad_dosenmengajar);
					$builder->where($arraywhere);				
					$cekdata = $builder->countAllResults();
					
					if($cekdata == 0){// jika data belum ada
						$datain = array("kodept"=>$val->kode_perguruan_tinggi,
										"nidn"=>$val->nidn,
										"id_dosen_ws"=>$val->id_dosen,
										"id_aktivitas_mengajar_ws"=>$val->id_aktivitas_mengajar,
										"id_kelas_kuliah_ws"=>$val->id_kelas_kuliah,
										"id_jenis_evaluasi"=>$val->id_jenis_evaluasi,
										"id_registrasi_dosen"=>$val->id_registrasi_dosen,
										"id_substansi"=>$val->id_substansi,
										"realisasi_tatap_muka"=>$val->realisasi_tatap_muka,
										"rencana_tatap_muka"=>$val->rencana_tatap_muka,
										"sks_substansi_total"=>$val->sks_substansi_total,
										"date_created"=>date("Y-m-d H:i:s")
										);
						//id_kelas
						$kelas = $this->msiakad_kelas->getdata(false,$val->id_kelas_kuliah,$profile->kodept);
						if($kelas){
							$datain["id_kelas"] = $kelas->id_kelas;
						}
						$query = $this->db->table($this->siakad_dosenmengajar)->insert($datain);
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
		}else{
			echo "Tidak di izinkan..!!!!";
		}			
	}
	
}
