<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
use App\Models\Msiakad_nilai;
 
class Nilai extends BaseController
{
	protected $siakad_nilai = 'siakad_nilai';
	protected $feeder_nilai = 'feeder_nilai';
	public function __construct()
    {
        $this->msiakad_nilai = new Msiakad_nilai();
    }
	public function index()
	{
		
		$data = [
			'title' => 'Data Akademik',
			'judul' => 'nilai',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_nilai'=>true
			
		];
		return view('akademik/nilai',$data);
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
		$data 		= $this->msiakad_nilai->getdata(false,false,false,false,$profile->kodept);
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Semester</th><th>NIM</th><th>Kode MK</th><th>Nama MK</th><th>Nilai Huruf</th><th>Nilai Indeks</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='7'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				$prodi = $this->msiakad_prodi->getdata(false,$val->id_prodi);
				if($prodi){				
					$jenjang = $this->mreferensi->GetJenjangPendidikan($prodi->id_jenjang);
					if($jenjang){
						$namaprodi = $prodi->nama_prodi."".$jenjang->nama_jenjang_didik;
					}else{
						$namaprodi = $prodi->nama_prodi;
					}
				}else{
					$namaprodi = "-";
				}
				$matakuliah = $this->msiakad_matakuliah->getdata(false,$val->id_matkul_ws);
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->semester}</td>";
				echo "<td>{$val->nim}</td>";
				echo "<td>{$val->kode_matakuliah}</td>";
				echo "<td>{$matakuliah->nama_matakuliah}</td>";
				echo "<td>{$val->nilai_huruf}</td>";
				echo "<td>{$val->nilai_indeks}</td>";
				echo "<td>";
					echo "<a href='#modalku' data-toggle='modal' class='modalButton' data-src='".base_url()."/akademik/nilai/edit/{$val->id_nilai}' title='Edit data'>edit</a>";
					echo " - <a>hapus</a>";
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function tambah(){
		?>
		<script>
		$('.select2').select2({
			dropdownParent: $("#modalku")
			
		})
		</script>
		<?php
		$profile 	= $this->msiakad_setting->getdata(); 		
		$jenjang_pendidikan = $this->mreferensi->GetJenjangPendidikan();		
		$prodi = $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		$semester = $this->mreferensi->GetSemester();
		$matakuliah = $this->msiakad_matakuliah->getdata(false,false,false,$profile->kodept);
		echo "<form method='post' id='form_tambah' action='".base_url()."/akademik/nilai/create'>";
		echo csrf_field(); 
		
		echo "<div class='form-group'>";
			echo "<label for='nama_nilai'>Nama nilai</label>";
			echo "<input type='text' class='form-control' name='nama_nilai' id='nama_nilai'>";
		echo "</div>";	

		
		echo "<div class='form-group'>";
		  echo "<label>Matakuliah</label>";
		  echo "<select name='kode_mata_kuliah' class='form-control select2 select2-hidden-accessible' style='width: 100%;' data-select2-id='1' tabindex='-1' aria-hidden='true'>";
			echo "<option selected='selected'>Pilih</option>";
			if($matakuliah){
				foreach($matakuliah as $key=>$val){
					echo "<option value='{$val->id_matkul_ws}'>{$val->kode_matakuliah} {$val->nama_matakuliah}</option>";
				}
			}
		  echo "</select>";
		echo "</div>";
		
		
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='id_prodi'>Program Studi</label>";
					echo "<select name='id_prodi' class='form-control' id='id_prodi'>";
					if($prodi){
						foreach($prodi as $key=>$val){
							echo "<option value='{$val->id_prodi}'>{$val->nama_prodi}</option>";
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
		$nama_nilai	= $this->request->getVar("nama_nilai");
		$id_semester = 	$this->request->getVar("id_semester");
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'nama_nilai'=>[
				'rules' => 'required|is_unique[siakad_nilai.nama_nilai,id_prodi_ws]',
				'errors' => [
					'required' => 'nama nilai harus diisi.',
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
			
			$query = $this->db->table($this->siakad_nilai)->insert($datain);		
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
		$data	= $this->msiakad_nilai->getdata($id,false,false,$profile->kodept);
		//dd($data);
		
		$profile 	= $this->msiakad_setting->getdata(); 		
		$jenjang_pendidikan = $this->mreferensi->GetJenjangPendidikan();		
		$prodi = $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		$semester = $this->mreferensi->GetSemester();
		
		echo "<form method='post' id='form_ubah' action='".base_url()."/akademik/nilai/update'>";
		echo "<input type='hidden' name='id_nilai' value='{$data->id_nilai}'";
		echo csrf_field(); 
		
		echo "<div class='form-group'>";
			echo "<label for='nama_nilai'>Nama nilai</label>";
			echo "<input type='text' class='form-control' name='nama_nilai' id='nama_nilai' value='{$data->nama_nilai}'>";
		echo "</div>";	
		
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='id_prodi'>Program Studi</label>";
					echo "<select name='id_prodi' class='form-control' id='id_prodi'>";
					if($prodi){
						foreach($prodi as $key=>$val){
							echo "<option value='{$val->id_prodi}'";
							if($data->id_prodi == $val->id_prodi) echo " selected='selected'";
							echo ">{$val->nama_prodi}</option>";
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
		$id_nilai = $this->request->getVar("id_nilai");
		$nama_nilai = $this->request->getVar("nama_nilai");
		$id_semester = 	$this->request->getVar("id_semester");
			//cek dulu apakah sudah ada
		$cekdata = $this->db->table($this->siakad_nilai)->getWhere(['id_nilai' => $id_nilai]);
		if($cekdata->getRowArray() > 0){
			$data_cek = $cekdata->getResult();
			if($data_cek[0]->nama_nilai != $nama_nilai){
				$rule_nama_nilai = 'required|is_unique[siakad_nilai.nama_nilai,id_prodi_ws]';
			}else{
				$rule_nama_nilai = 'required';
			}
		}else{
			$rule_nama_nilai = 'required|is_unique[siakad_nilai.nama_nilai,id_prodi_ws]';
		}
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'nama_nilai' => [
				'rules' => $rule_nama_nilai,
				'errors' => [
					'required' => 'kode nilai harus diisi.',
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
			
			$query = $this->db->table($this->siakad_nilai)->update($datain,array("id_nilai"=>$id_nilai));		
			if($query){	
				$ret['messages'] = "Data berhasil diupdate";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal diupdate";
			}			
		}	
		echo json_encode($ret);
	}
	public function getnilaipddikti(){		
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$data_nilai_feeder = $this->msiakad_nilai->getdatapddikti(false,false,false,false,$profile->kodept);
		
		if(!$data_nilai_feeder){
			$ret["messages"] = "Tidak ada data PDDIKTI";
		}else{
			$jum=0;
			foreach($data_nilai_feeder as $key=>$val){
				//cek data dulu
				$matakuliah = $this->msiakad_matakuliah->getdata(false,$val->id_matkul,false,$profile->kodept);
				$cekdata = $this->msiakad_nilai->getdata(false,$val->nim,$matakuliah->kode_matakuliah,$val->id_periode,$profile->kodept);
			
				if(!$cekdata){// jika data belum ada
					$datain = array("nim"=>$val->nim,
									"kodept"=>$val->kode_perguruan_tinggi,									
									"semester"=>$val->id_periode,
									"kelas"=>$val->nama_kelas_kuliah,
									"id_prodi"=>$val->id_prodi,
									"nilai_huruf"=>$val->nilai_huruf,
									"nilai_indeks"=>$val->nilai_indeks,
									"id_kelas_ws"=>$val->id_kelas,
									"id_matkul_ws"=>$val->id_matkul,
									"id_periode_ws"=>$val->id_periode,									
									"id_registrasi_mahasiswa"=>$val->id_registrasi_mahasiswa									
									);
					$datain["kode_matakuliah"]=$matakuliah->kode_matakuliah;				
					$prodi = $this->msiakad_prodi->getdata(false,$val->id_prodi,$profile->kodept,false);				
					$datain["kode_prodi"]=$prodi->kode_prodi;
					
					$query = $this->db->table($this->siakad_nilai)->insert($datain);
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
