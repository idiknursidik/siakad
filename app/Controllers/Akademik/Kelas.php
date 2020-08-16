<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
use App\Models\Msiakad_kelas;
 
class Kelas extends BaseController
{
	protected $siakad_kelas = 'siakad_kelas';
	protected $feeder_kelas = 'feeder_kelas';
	protected $siakad_nilai = 'siakad_nilai';
	public function __construct()
    {
        $this->msiakad_kelas = new Msiakad_kelas();
    }
	public function index()
	{
		
		$data = [
			'title' => 'Data Akademik',
			'judul' => 'kelas',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_kelas'=>true
			
		];
		return view('akademik/kelas',$data);
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
		$data 		= $this->msiakad_kelas->getdata(false,false,$profile->kodept);
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Kode MK</th><th>Nama MK</th><th>Kelas</th><th>Prodi</th><th>Semester</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='7'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				$prodi = $this->msiakad_prodi->getdata(false,$val->id_prodi_ws);
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
				echo "<td>{$val->kode_mata_kuliah}</td>";
				echo "<td>{$matakuliah->nama_matakuliah}</td>";
				echo "<td>{$val->nama_kelas_kuliah}</td>";
				echo "<td>{$namaprodi}</td>";
				echo "<td>{$val->id_semester}</td>";
				echo "<td>";
					echo "<a href='#modalku' data-toggle='modal' class='modalButton' data-src='".base_url()."/akademik/kelas/edit/{$val->id_kelas}' title='Edit data'>edit</a>";
					echo " - <a href='#' name='hapuskelas' data-src='".base_url()."/akademik/kelas/hapuskelas' id_kelas='{$val->id_kelas}'>hapus</a>";
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function hapuskelas(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$id_kelas	= $this->request->getVar("id_kelas");
		if(!$profile){
			$ret["messages"] = "Error data.."; 
		}else{
			$data = $this->msiakad_kelas->getdata($id_kelas,false,$profile->kodept);
			//cek dulu di data nila
			$builder = $this->db->table($this->siakad_nilai);
			$cekdata = $builder->getWhere(['kode_matakuliah' => $data->kode_mata_kuliah,'semester'=>$data->id_semester,'kelas'=>$data->nama_kelas_kuliah,'kode_prodi'=>$data->kode_prodi]);
			if($cekdata->getResult()){
				$ret["messages"] = "Hapus dulu data.. terkait"; 
			}else{
				$query = $this->db->table($this->siakad_kelas)->delete(array('id_kelas' => $id_kelas));		
				if($query){	
					$ret['messages'] = "Data berhasil dihapus";
					$ret['success'] = true;	
				}else{
					$ret['messages'] = "Data gagal dihapus";
				}
			}
		}
		echo json_encode($ret);
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
		echo "<form method='post' id='form_tambah' action='".base_url()."/akademik/kelas/create'>";
		echo csrf_field(); 
		
		echo "<div class='form-group'>";
			echo "<label for='nama_kelas_kuliah'>Nama kelas</label>";
			echo "<input type='text' class='form-control' name='nama_kelas_kuliah' id='nama_kelas_kuliah'>";
		echo "</div>";	

		
		echo "<div class='form-group'>";
		  echo "<label>Matakuliah</label>";
		  echo "<select name='id_matakuliah' class='form-control select2 select2-hidden-accessible' style='width: 100%;' data-select2-id='1' tabindex='-1' aria-hidden='true'>";
			echo "<option selected='selected'>Pilih</option>";
			if($matakuliah){
				foreach($matakuliah as $key=>$val){
					echo "<option value='{$val->id_matakuliah}'>{$val->kode_matakuliah} {$val->nama_matakuliah}</option>";
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
					echo "<label for='tanggal_mulai_efektif'>Tanggal mulai efektif</label>";
					echo "<input type='date' class='form-control' name='tanggal_mulai_efektif' id='tanggal_mulai_efektif'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='tanggal_akhir_efektif'>Tanggal akhir efektif</label>";
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
		$nama_kelas_kuliah	= $this->request->getVar("nama_kelas_kuliahnama_kelas_kuliah");
		$id_semester 	= 	$this->request->getVar("id_semester");
		$id_matakuliah 	= 	$this->request->getVar("id_matakuliah");
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'nama_kelas_kuliah'=>[
				'rules' => 'required|is_unique[siakad_kelas.nama_kelas_kuliah,id_prodi_ws]',
				'errors' => [
					'required' => 'nama kelas harus diisi.',
					'is_unique' => 'Data sudah ada.'
				]
			]
		]))
		{			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{
			$matakuliah = $this->msiakad_matakuliah->getdata($id_matakuliah,false,false,$profile->kodept);
			
			$datain=array();
			foreach($this->request->getVar() as $key=>$val){
				if(!in_array($key,array("csrf_test_name","id_prodi","id_matakuliah"))){
					$datain[$key] =  $this->request->getVar($key);
				}
			}
			$datain["kodept"] = $profile->kodept;
			$datain["id_prodi"] = $id_prodi;
			if($matakuliah){
				$datain["id_matkul_ws"] = (strlen($matakuliah->id_matkul_ws) > 0)?$matakuliah->id_matkul_ws:"";
				$datain["kode_mata_kuliah"] = $matakuliah->kode_matakuliah;
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
			
			$query = $this->db->table($this->siakad_kelas)->insert($datain);		
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
		?>
		<script>
		$('.select2').select2({
			dropdownParent: $("#modalku")
			
		})
		</script>
		<?php
		
		$data	= $this->msiakad_kelas->getdata($id,false,$profile->kodept);
		
		$profile 	= $this->msiakad_setting->getdata(); 		
		$jenjang_pendidikan = $this->mreferensi->GetJenjangPendidikan();		
		$prodi = $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		$semester = $this->mreferensi->GetSemester();
		$matakuliah = $this->msiakad_matakuliah->getdata(false,false,false,$profile->kodept);
		echo "<form method='post' id='form_ubah' action='".base_url()."/akademik/kelas/update'>";
		echo "<input type='hidden' name='id_kelas' value='{$data->id_kelas}'";
		echo csrf_field(); 
		
		echo "<div class='form-group'>";
			echo "<label for='nama_kelas_kuliah'>Nama kelas</label>";
			echo "<input type='text' class='form-control' name='nama_kelas_kuliah' id='nama_kelas_kuliah' value='{$data->nama_kelas_kuliah}'>";
		echo "</div>";
		
		echo "<div class='form-group'>";
		  echo "<label>Matakuliah</label>";
		  echo "<select name='id_matakuliah' class='form-control select2 select2-hidden-accessible' style='width: 100%;' data-select2-id='1' tabindex='-1' aria-hidden='true'>";
			echo "<option selected='selected'>Pilih</option>";
			if($matakuliah){
				foreach($matakuliah as $key=>$val){
					echo "<option value='{$val->id_matakuliah}'";
					if($data->kode_mata_kuliah == $val->kode_matakuliah) echo " selected='selected'";
					echo ">{$val->kode_matakuliah} {$val->nama_matakuliah}</option>";
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
							if(in_array($val->id_prodi,explode(",",session()->akses))){
								echo "<option value='{$val->id_prodi}'";
								if($data->kode_prodi == $val->kode_prodi) echo " selected='selected'";
								echo ">{$val->nama_prodi} {$val->nama_jenjang_didik}</option>";
							}
						}
					}
					echo "</select>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='id_semester'>Semester</label>";
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
					echo "<label for='tanggal_mulai_efektif'>Tanggal mulai efektif</label>";
					echo "<input type='date' class='form-control' name='tanggal_mulai_efektif' id='tanggal_mulai_efektif' value='{$data->tanggal_mulai_efektif}'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='tanggal_akhir_efektif'>Tanggal akhir efektif</label>";
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
		$id_kelas 		= $this->request->getVar("id_kelas");
		$nama_kelas_kuliah = $this->request->getVar("nama_kelas_kuliah");
		$id_semester 	= $this->request->getVar("id_semester");
		$id_matakuliah	= $this->request->getVar("id_matakuliah");
			//cek dulu apakah sudah ada
		$cekdata = $this->db->table($this->siakad_kelas)->getWhere(['id_kelas' => $id_kelas]);
		if($cekdata->getRowArray() > 0){
			$data_cek = $cekdata->getResult();
			if($data_cek[0]->nama_kelas_kuliah != $nama_kelas_kuliah){
				$rule_nama_kelas = 'required|is_unique[siakad_kelas.nama_kelas_kuliah,id_prodi_ws]';
			}else{
				$rule_nama_kelas = 'required';
			}
		}else{
			$rule_nama_kelas = 'required|is_unique[siakad_kelas.nama_kelas_kuliah,id_prodi_ws]';
		}
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'nama_kelas_kuliah' => [
				'rules' => $rule_nama_kelas,
				'errors' => [
					'required' => 'kode kelas harus diisi.',
					'is_unique' => 'Data sudah ada.'
				]
			]
		]))
		{			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{
			$matakuliah = $this->msiakad_matakuliah->getdata($id_matakuliah,false,false,$profile->kodept);
			$datain=array();
			foreach($this->request->getVar() as $key=>$val){
				if(!in_array($key,array("csrf_test_name","id_prodi","id_matakuliah"))){
					$datain[$key] =  $this->request->getVar($key);
				}
			}
			$datain["kodept"] = $profile->kodept;
			$datain["id_prodi"] = $id_prodi;
			if($matakuliah){
				$datain["id_matkul_ws"] = (strlen($matakuliah->id_matkul_ws) > 0)?$matakuliah->id_matkul_ws:"";
				$datain["kode_mata_kuliah"] = $matakuliah->kode_matakuliah;
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
			
			$query = $this->db->table($this->siakad_kelas)->update($datain,array("id_kelas"=>$id_kelas));		
			if($query){	
				$ret['messages'] = "Data berhasil diupdate";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal diupdate";
			}			
		}	
		echo json_encode($ret);
	}
	public function getkelaspddikti(){		
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$data_kelas_feeder = $this->msiakad_kelas->getdatapddikti(false,$profile->kodept);
		
		if(!$data_kelas_feeder){
			$ret["messages"] = "Tidak ada data PDDIKTI";
		}else{
			$jum=0;
			foreach($data_kelas_feeder as $key=>$val){
				//cek data dulu
				$cekdata = $this->msiakad_kelas->getdata(false,$val->id_kelas_kuliah,$profile->kodept);
				 
				if(!$cekdata){// jika data belum ada
					$prodi = $this->msiakad_prodi->getdata(false,$val->id_prodi,$profile->kodept,false);
					$datain = array("id_kelas_kuliah_ws"=>$val->id_kelas_kuliah,
									"kodept"=>$val->kode_perguruan_tinggi,
									"kode_prodi"=>$prodi->kode_prodi,
									"id_prodi"=>$prodi->id_prodi,
									"bahasan"=>$val->bahasan,
									"id_matkul_ws"=>$val->id_matkul,
									"id_prodi_ws"=>$val->id_prodi,
									"id_semester"=>$val->id_semester,
									"kode_mata_kuliah"=>$val->kode_mata_kuliah,
									"nama_kelas_kuliah"=>$val->nama_kelas_kuliah,
									"nama_program_studi"=>$val->nama_program_studi,
									"nama_semester"=>$val->nama_semester,
									"tanggal_akhir_efektif"=>$val->tanggal_akhir_efektif,
									"tanggal_mulai_efektif"=>$val->tanggal_mulai_efektif									
									);
					$query = $this->db->table($this->siakad_kelas)->insert($datain);
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
