<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
use App\Models\Msiakad_kurikulum;
 
class Kurikulum extends BaseController
{
	protected $siakad_kurikulum = 'siakad_kurikulum';
	protected $siakad_kurikulummatakuliah = 'siakad_kurikulummatakuliah';
	protected $feeder_kurikulum = 'feeder_kurikulum';
	public function __construct()
    {
        $this->msiakad_kurikulum = new Msiakad_kurikulum();
    }
	public function index()
	{
		
		$data = [
			'title' => 'Data Akademik',
			'judul' => 'Kurikulum',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_kurikulum'=>true
			
		];
		return view('akademik/kurikulum',$data);
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
		$data 		= $this->msiakad_kurikulum->getdata(false,false,$profile->kodept);
		
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Nama kurikulum</th><th>Program Studi</th><th>Mulai Berlaku</th><th>SKS wajib</th><th>SKS pilihan</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='4'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				$prodi = $this->msiakad_prodi->getdata(false,$val->id_prodi_ws);
				$jenjang = $this->mreferensi->GetJenjangPendidikan($prodi->id_jenjang);
				
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td><a href='".base_url()."/akademik/kurikulummatakuliah/index/{$val->id_kurikulum}/{$val->id_kurikulum_ws}'>{$val->nama_kurikulum}</a></td>";
				echo "<td>{$prodi->nama_prodi} {$jenjang->nama_jenjang_didik}</td>";
				echo "<td>{$val->id_semester}</td>";
				echo "<td>{$val->jumlah_sks_wajib}</td>";
				echo "<td>{$val->jumlah_sks_pilihan}</td>";
				echo "<td>";
					echo "<a href='#modalku' data-toggle='modal' class='modalButton' data-src='".base_url()."/akademik/kurikulum/edit/{$val->id_kurikulum}' title='Edit data'>edit</a>";
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
	public function getkurikulumpddikti(){		
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$data_kurikulum_feeder = $this->msiakad_kurikulum->getdatapddikti(false,$profile->kodept);
		
		if(!$data_kurikulum_feeder){
			$ret["messages"] = "Tidak ada data PDDIKTI";
		}else{
			$jum=0;
			foreach($data_kurikulum_feeder as $key=>$val){
				//cek data dulu
				$cekdata = $this->msiakad_kurikulum->getdata(false,$val->id_kurikulum,false,$profile->kodept);
				if(!$cekdata){// jika data belum ada
					$datain = array("id_kurikulum_ws"=>$val->id_kurikulum,
									"kodept"=>$val->kode_perguruan_tinggi,
									"id_prodi_ws"=>$val->id_prodi,
									"id_semester"=>$val->id_semester,
									"jumlah_sks_lulus"=>$val->jumlah_sks_lulus,
									"jumlah_sks_pilihan"=>$val->jumlah_sks_pilihan,
									"jumlah_sks_wajib"=>$val->jumlah_sks_wajib,
									"nama_kurikulum"=>$val->nama_kurikulum,
									"semester_mulai_berlaku"=>$val->semester_mulai_berlaku
									);
					$query = $this->db->table($this->siakad_kurikulum)->insert($datain);
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
	public function getkurikulummatakuliahpddikti(){		
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$data_kurikulummatakuliah_feeder = $this->msiakad_kurikulummatakuliah->getdatapddikti(false,false,false,false,false,$profile->kodept);
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
