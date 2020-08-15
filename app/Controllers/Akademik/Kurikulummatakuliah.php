<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
use App\Models\Msiakad_kurikulummatakuliah;
 
class Kurikulummatakuliah extends BaseController
{
	protected $siakad_kurikulummatakuliah = 'siakad_kurikulummatakuliah';
	protected $feeder_kurikulummatakuliah = 'feeder_kurikulummatakuliah';
	public function __construct()
    {
        $this->msiakad_kurikulummatakuliah = new Msiakad_kurikulummatakuliah();
    }
	public function index($id_kurikulum=false,$id_kurikulum_ws=false)
	{
		$data = [
			'title' => 'Data Akademik',
			'judul' => 'Kurikulum Matakuliah',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_kurikulum'=>true,
			'id_kurikulum' => $id_kurikulum,
			'id_kurikulum_ws' => $id_kurikulum_ws
			
		];
		return view('akademik/kurikulummatakuliah',$data);
	}
	public function listdata($id_kurikulum=false,$id_kurikulum_ws=false)
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
		$data = $this->msiakad_kurikulummatakuliah->getdata(false,$id_kurikulum);
		
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Kodematakuliah</th><th>Program Studi</th><th>Semester</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='4'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				$prodi = $this->msiakad_prodi->getdata(false,false,false,false,$val->kode_prodi);
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->kode_mata_kuliah}</td>";
				echo "<td>{$prodi->nama_prodi} {$prodi->nama_jenjang_didik}</td>";
				echo "<td>{$val->id_semester}</td>";
				echo "<td>";
					echo "<a href='#modalku' data-toggle='modal' class='modalButton' data-src='".base_url()."/akademik/kurikulummatakuliah/edit/{$val->id_kurikulummatakuliah}' title='Edit data'>edit</a>";
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
		$prodi = $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		$semester = $this->mreferensi->GetSemester();
		echo "<form method='post' id='form_tambah' action='".base_url()."/akademik/kurikulummatakuliah/create'>";
		echo csrf_field(); 
		echo "BLOM";
		echo "<div class='form-group'>";
			echo "<label for='kode_mata_kuliah'>Matakuliah</label>";
			echo "<input type='text' class='form-control' name='kode_mata_kuliah' id='kode_mata_kuliah'>";
		echo "</div>";	
				
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='semester'>Semester</label>";
					echo "<input type='text' class='form-control' name='semester' id='semester'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='semester'>Wajib</label>";
					echo "<input type='text' class='form-control' name='semester' id='semester'>";
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
		$nama_kurikulummatakuliah	= $this->request->getVar("nama_kurikulummatakuliah");
		$id_semester = 	$this->request->getVar("id_semester");
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'nama_kurikulummatakuliah'=>[
				'rules' => 'required|is_unique[siakad_kurikulummatakuliah.nama_kurikulummatakuliah,id_prodi_ws]',
				'errors' => [
					'required' => 'nama kurikulummatakuliah harus diisi.',
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
			
			$query = $this->db->table($this->siakad_kurikulummatakuliah)->insert($datain);		
			if($query){	
				$ret['messages'] = "Data berhasil dimasukan";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal dimasukan";
			}			
		}	
		echo json_encode($ret);
	}
	
	public function edit($id_kurikulummatakuliah=false){
		$profile 	= $this->msiakad_setting->getdata();
		if(!$id_kurikulummatakuliah){
			echo "Error data.."; exit();
		}
		$data	= $this->msiakad_kurikulummatakuliah->getdata($id_kurikulummatakuliah,false,false,false,false,false,$profile->kodept);
		print_r($data);
		exit();
		$profile 	= $this->msiakad_setting->getdata(); 		
		$jenjang_pendidikan = $this->mreferensi->GetJenjangPendidikan();		
		$prodi = $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		$semester = $this->mreferensi->GetSemester();
		
		echo "<form method='post' id='form_ubah' action='".base_url()."/akademik/kurikulummatakuliah/update'>";
		echo "<input type='hidden' name='id_kurikulummatakuliah' value='{$data->id_kurikulummatakuliah}'>";
		echo csrf_field(); 
		
		echo "<div class='form-group'>";
			echo "<label for='nama_kurikulummatakuliah'>Nama kurikulummatakuliah</label>";
			echo "<input type='text' class='form-control' name='nama_kurikulummatakuliah' id='nama_kurikulummatakuliah' value='{$data->nama_kurikulummatakuliah}'>";
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
		$id_kurikulummatakuliah = $this->request->getVar("id_kurikulummatakuliah");
		$nama_kurikulummatakuliah = $this->request->getVar("nama_kurikulummatakuliah");
		$id_semester = 	$this->request->getVar("id_semester");
			//cek dulu apakah sudah ada
		$cekdata = $this->db->table($this->siakad_kurikulummatakuliah)->getWhere(['id_kurikulummatakuliah' => $id_kurikulummatakuliah]);
		if($cekdata->getRowArray() > 0){
			$data_cek = $cekdata->getResult();
			if($data_cek[0]->nama_kurikulummatakuliah != $nama_kurikulummatakuliah){
				$rule_nama_kurikulummatakuliah = 'required|is_unique[siakad_kurikulummatakuliah.nama_kurikulummatakuliah,id_prodi_ws]';
			}else{
				$rule_nama_kurikulummatakuliah = 'required';
			}
		}else{
			$rule_nama_kurikulummatakuliah = 'required|is_unique[siakad_kurikulummatakuliah.nama_kurikulummatakuliah,id_prodi_ws]';
		}
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'nama_kurikulummatakuliah' => [
				'rules' => $rule_nama_kurikulummatakuliah,
				'errors' => [
					'required' => 'kode kurikulummatakuliah harus diisi.',
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
			
			$query = $this->db->table($this->siakad_kurikulummatakuliah)->update($datain,array("id_kurikulummatakuliah"=>$id_kurikulummatakuliah));		
			if($query){	
				$ret['messages'] = "Data berhasil diupdate";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal diupdate";
			}			
		}	
		echo json_encode($ret);
	}
	public function getkurikulummatakuliahpddikti($id_kurikulum){		
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$data_kurikulummatakuliah_feeder = $this->msiakad_kurikulummatakuliah->getdatapddikti($id_kurikulum,$profile->kodept);
		
		if(!$data_kurikulummatakuliah_feeder){
			$ret["messages"] = "Tidak ada data PDDIKTI";
		}else{
			$jum=0;
			foreach($data_kurikulummatakuliah_feeder as $key=>$val){
				//cek data dulu
				$cekdata = $this->msiakad_kurikulummatakuliah->getdata(false,$val->id_kurikulum,$val->id_prodi,$val->id_matkul,$val->id_semester,$profile->kodept);
				if(!$cekdata){// jika data belum ada
					$datain = array("kodept"=>$val->kode_perguruan_tinggi,
									"id_perguruan_tinggi_ws"=>$val->id_perguruan_tinggi,
									"id_kurikulum_ws"=>$val->id_kurikulum,
									"id_prodi_ws"=>$val->id_prodi,
									"id_matkul_ws"=>$val->id_matkul,
									"id_semester"=>$val->id_semester,
									"kode_mata_kuliah"=>$val->kode_mata_kuliah,
									"semester"=>$val->semester
									);
					//tambah
					$prodi = $this->msiakad_prodi->getdata(false,$val->id_prodi,$profile->kodept,false);				
					if($prodi){
						$datain["kode_prodi"] = $prodi->kode_prodi;
					}
					$kurikulum = $this->msiakad_kurikulummatakuliah->getdata(false,$val->id_kurikulum);				
					if($kurikulum){
						$datain["id_kurikulum"] = $kurikulum->id_kurikulum;
					}
					$query = $this->db->table($this->siakad_kurikulummatakuliah)->insert($datain);
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
