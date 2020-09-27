<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
use App\Models\Msiakad_kelas;
 
class Kelas extends BaseController
{
	protected $siakad_kelas = 'siakad_kelas';
	protected $feeder_kelas = 'feeder_kelas';
	protected $siakad_nilai = 'siakad_nilai';
	protected $siakad_dosenmengajar = 'siakad_dosenmengajar';
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
			     // Setup - add a text input to each footer cell
			$('#datatable thead tr').clone(true).appendTo( '#datatable thead' );
			$('#datatable thead tr:eq(1) th').each( function (i) {
				
				var title = $(this).text();
				if(i != 0 && i != 7){
					$(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
				}else{
					$(this).html("");
				}
				$( 'input', this ).on( 'keyup change', function () {
					if ( table.column(i).search() !== this.value ) {
						table
							.column(i)
							.search( this.value )
							.draw();
					}
				} );
			} );
			
			var table = $('#datatable').DataTable({
			  "paging": true,
			  "lengthChange": true,
			  "searching": true,
			  "ordering": true,
			  "info": true,
			  "autoWidth": false,
			  "responsive": true,
			   "orderCellsTop": true
			});
			
		  });
		</script>
		<?php
		$profile 	= $this->msiakad_setting->getdata(); 
		$data 		= $this->msiakad_kelas->getdata(false,false,false,$profile->kodept);
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Kode MK</th><th>Nama MK</th><th>Kelas</th><th>Prodi</th><th>Semester</th><th>Peserta</th><th width='10%'>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='7'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				$prodi = $this->msiakad_prodi->getdata($val->id_prodi);				
				$matakuliah = $this->msiakad_matakuliah->getdata(false,$val->id_matkul_ws);
				$pesertakuliah = $this->msiakad_nilai->getdata(false,false,false,false,$val->id_kelas);
				$jumlahpeserta = ($pesertakuliah)?count($pesertakuliah):0;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td><a href='".base_url()."/akademik/kelas/peserta/{$val->id_kelas}'>{$val->kode_mata_kuliah}</a></td>";
				echo "<td>{$matakuliah->nama_matakuliah}</td>";
				echo "<td>{$val->nama_kelas_kuliah}</td>";
				echo "<td>{$prodi->nama_prodi}-{$prodi->nama_jenjang_didik}</td>";
				echo "<td>{$val->id_semester}</td>";
				echo "<td>{$jumlahpeserta}</td>";				
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
			$data = $this->msiakad_kelas->getdata($id_kelas,false,false,$profile->kodept);
			//cek dulu di data nilai
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
		$profile 			= $this->msiakad_setting->getdata(); 		
		$jenjang_pendidikan = $this->mreferensi->GetJenjangPendidikan();		
		$prodi				= $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		$semester 			= $this->mreferensi->GetSemester();
		$setperkuliahan		= $this->msiakad_setting->setperkuliahan("Y");
		$semester_aktif 	= ($setperkuliahan)?$setperkuliahan->semester_aktif:"";
		$kurikulummatakuliah = $this->msiakad_kurikulummatakuliah->getdata(false,false,false,false,false,false,$profile->kodept);
		
		echo "<form method='post' id='form_tambah' action='".base_url()."/akademik/kelas/create'>";
		echo csrf_field(); 
		
		echo "<div class='form-group'>";
			echo "<label for='nama_kelas_kuliah'>Nama kelas</label>";
			echo "<input type='text' class='form-control' name='nama_kelas_kuliah' id='nama_kelas_kuliah'>";
		echo "</div>";	

		
		echo "<div class='form-group'>";
		  echo "<label>Matakuliah</label>";
		  echo "<select name='id_kurikulummatakuliah' class='form-control select2 select2-hidden-accessible' style='width: 100%;' data-select2-id='1' tabindex='-1' aria-hidden='true'>";
			if($kurikulummatakuliah){
				foreach($kurikulummatakuliah as $key=>$val){
					echo "<option value='{$val->id_kurikulummatakuliah}'";
					if($semester_aktif == $val->id_semester) echo " selected='selected'";
					echo ">{$val->kode_mata_kuliah}-{$val->nama_matakuliah}-Kurikulum: {$val->nama_kurikulum}</option>";
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
					echo "<label for='id_semester'>Semester</label>";
					echo "<select name='id_semester' class='form-control' id='id_semester'>";
					if($semester){
						foreach($semester as $key=>$val){
							echo "<option value='{$val->id_semester}'";
							if($semester_aktif == $val->id_semester) echo " selected='selected'";
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
		$id_semester 		= $this->request->getVar("id_semester");
		$id_kurikulummatakuliah	= $this->request->getVar("id_kurikulummatakuliah");
		$kurikulummatakuliah = $this->msiakad_kurikulummatakuliah->getdata($id_kurikulummatakuliah,false,false,false,false,false,$profile->kodept);
		
		$id_matakuliah 	= 	$kurikulummatakuliah->id_matakuliah;
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'nama_kelas_kuliah'=>[
				'rules' => 'required|is_unique[siakad_kelas.nama_kelas_kuliah,id_matakuliah,id_semester]',
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
				if(!in_array($key,array("csrf_test_name","id_prodi"))){
					$datain[$key] =  $this->request->getVar($key);
				}
			}
			
			$datain["date_create"] = date('Y-m-d H:i:s');
			$datain["kodept"] = $profile->kodept;
			$datain["id_prodi"] = $id_prodi;
			if($matakuliah){
				$datain["id_matkul_ws"] = (strlen($matakuliah->id_matkul_ws) > 0)?$matakuliah->id_matkul_ws:"";
				$datain["kode_mata_kuliah"] = $matakuliah->kode_matakuliah;
				$datain["id_matakuliah"] = $matakuliah->id_matakuliah;
				$datain["id_kelas_kuliah_ws"] = uniqid();
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
		
		$data	= $this->msiakad_kelas->getdata($id,false,false,$profile->kodept);
		
		$profile 	= $this->msiakad_setting->getdata(); 		
		$jenjang_pendidikan = $this->mreferensi->GetJenjangPendidikan();		
		$prodi = $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		$semester = $this->mreferensi->GetSemester();
		$kurikulummatakuliah = $this->msiakad_kurikulummatakuliah->getdata(false,false,false,false,false,false,$profile->kodept);
		$setperkuliahan		= $this->msiakad_setting->setperkuliahan("Y");
		
		echo "<form method='post' id='form_ubah' action='".base_url()."/akademik/kelas/update'>";
		echo "<input type='hidden' name='id_kelas' value='{$data->id_kelas}'";
		echo csrf_field(); 
		
		echo "<div class='form-group'>";
			echo "<label for='nama_kelas_kuliah'>Nama kelas</label>";
			echo "<input type='text' class='form-control' name='nama_kelas_kuliah' id='nama_kelas_kuliah' value='{$data->nama_kelas_kuliah}'>";
		echo "</div>";
		
		echo "<div class='form-group'>";
		  echo "<label>Matakuliah</label>";
		  echo "<select name='id_kurikulummatakuliah' class='form-control select2 select2-hidden-accessible' style='width: 100%;' data-select2-id='1' tabindex='-1' aria-hidden='true'>";
			echo "<option selected='selected'>Pilih</option>";
			if($kurikulummatakuliah){
				foreach($kurikulummatakuliah as $key=>$val){
					echo "<option value='{$val->id_kurikulummatakuliah}'";
					if($data->id_kurikulummatakuliah == $val->id_kurikulummatakuliah) echo " selected='selected'";
					echo ">{$val->kode_mata_kuliah}-{$val->nama_matakuliah} - Kurikulum: {$val->nama_kurikulum}</option>";
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
		$id_kurikulummatakuliah	= $this->request->getVar("id_kurikulummatakuliah");
		$kurikulummatakuliah = $this->msiakad_kurikulummatakuliah->getdata($id_kurikulummatakuliah,false,false,false,false,false,$profile->kodept);
		
		$id_matakuliah 	= 	$kurikulummatakuliah->id_matakuliah;
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
				if(!in_array($key,array("csrf_test_name","id_prodi"))){
					$datain[$key] =  $this->request->getVar($key);
				}
			}
			$datain["date_update"] = date('Y-m-d H:i:s');
			$datain["kodept"] = $profile->kodept;
			$datain["id_prodi"] = $id_prodi;
			if($matakuliah){
				$datain["id_matkul_ws"] = (strlen($matakuliah->id_matkul_ws) > 0)?$matakuliah->id_matkul_ws:"";
				$datain["kode_mata_kuliah"] = $matakuliah->kode_matakuliah;
				$datain["id_matakuliah"] = $matakuliah->id_matakuliah;
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
			$jumupdate=0;
			$juminsert=0;
			foreach($data_kelas_feeder as $key=>$val){
				$prodi = $this->msiakad_prodi->getdata(false,$val->id_prodi,$profile->kodept,false);
				$kodeprodi	= ($prodi)?$prodi->kode_prodi:'';
				$id_prodi	= ($prodi)?$prodi->id_prodi:'';
					
				$datain = array("id_kelas_kuliah_ws"=>$val->id_kelas_kuliah,
								"kodept"=>$val->kode_perguruan_tinggi,
								"kode_prodi"=>$kodeprodi,
								"id_prodi"=>$id_prodi,
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
				
				$kurikulummatakuliah = $this->msiakad_kurikulummatakuliah->getdata(false,false,false,$val->id_prodi,$val->id_matkul,$val->id_semester);
				if($kurikulummatakuliah){
					$datain['id_kurikulummatakuliah'] = $kurikulummatakuliah->id_kurikulummatakuliah;
				}
				$matakuliah = $this->msiakad_matakuliah->getdata(false,$val->id_matkul,false,$profile->kodept);
				if($matakuliah){
					$datain['id_matakuliah'] = $matakuliah->id_matakuliah;
				}
				//cek data dulu
				$cekdata = $this->msiakad_kelas->getdata(false,$val->id_kelas_kuliah,$val->id_semester,$profile->kodept);			 
				if($cekdata){// jika data belum ada				
					$query = $this->db->table($this->siakad_kelas)->update($datain,array('id_kelas_kuliah_ws'=>$val->id_kelas_kuliah));
					if($query){
						$jumupdate++;
					}					
				}else{
					$query = $this->db->table($this->siakad_kelas)->insert($datain);
					if($query){
						$juminsert++;
					}
				}
			}
			$jum = $jumupdate+$juminsert;
			$info = $jumupdate.' data berhasil diupdate & '.$juminsert.' data berhasil dimasukan';
			if($jum > 0){
				$ret["messages"] = "{$info}";
				$ret["success"] = true;
			}else{
				$ret["messages"] = "tidak ada data yang dimasukan";
			}
		}		
		echo json_encode($ret);		
	}
	public function peserta($id_kelas=false){
		$profile 	= $this->msiakad_setting->getdata(); 
		if(!$id_kelas){
			echo "error ID kelas"; exit();
		}
		$data = [
			'title' => 'Data Akademik',
			'judul' => 'kelas',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_kelas'=>true,
			'id_kelas'=>$id_kelas
			
		];
		return view('akademik/kelas_peserta',$data);
	}
	public function listpeserta($id_kelas=false){
		$profile 	= $this->msiakad_setting->getdata(); 
		if(!$id_kelas){
			echo "error ID kelas"; exit();
		}
		$datakelas = $this->msiakad_kelas->getdata($id_kelas);
		echo "Prodi : {$datakelas->nama_prodi} - {$datakelas->nama_jenjang_didik}<br>"; 
		echo "Semester : {$datakelas->id_semester}<br>"; 
		echo "Matakuliah : {$datakelas->kode_mata_kuliah} - {$datakelas->nama_matakuliah}<br>";
		echo "Kelas : {$datakelas->nama_kelas_kuliah}";
		echo "<hr>";
		echo "<h4 class='text-primary'>Dosen Penganjar</h4>";
		$datapengajar = $this->msiakad_dosenmengajar->getdata(false,false,$profile->kodept,$id_kelas);
		echo "<table class='table'>";
		echo "<thead><tr><th>No</th><th>NIDN</th><th>Nama</th><th>Bobot (sks)</th><th>Rencana Pertemuan</th><th>Realisasi Pertemuan</th><th>Jenis Evaluasi</th><th width='10%'>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$datapengajar){
			echo "<tr><td colspan='7'>Belum ada dosen pengajar</td></tr>";
		}else{
			$no=0;
			foreach($datapengajar as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nidn}</td>";
				echo "<td>{$val->nama_dosen}</td>";
				echo "<td>{$val->sks_substansi_total}</td>";
				echo "<td>{$val->rencana_tatap_muka}</td>";
				echo "<td>{$val->realisasi_tatap_muka}</td>";
				echo "<td>{$val->id_jenis_evaluasi}</td>";
				echo "<td><a href='#' name='hapusdosenmengajar_{$no}' data-src='".base_url()."/akademik/kelas/hapusdosenmengajar' id_aktivitas_mengajar='{$val->id_aktivitas_mengajar}'>Hapus</a></td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
		echo "<hr>";
		$data = $this->msiakad_nilai->getdata(false,false,false,false,$id_kelas,$profile->kodept);
		echo "<h4 class='text-primary'>Peserta kelas</h4>";
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Nim</th><th>Nama</th><th>Jurusan</th><th>Angkatan</th><th width='10%'>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='7'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				$prodi = $this->msiakad_prodi->getdata($val->id_prodi);				
				$matakuliah = $this->msiakad_matakuliah->getdata(false,$val->id_matkul_ws);
				
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nim}</td>";
				echo "<td>{$val->nama_mahasiswa}</td>";
				echo "<td>{$prodi->nama_prodi} {$prodi->nama_jenjang_didik}</td>";
				echo "<td>{$val->id_periode_masuk}</td>";
				echo "<td>";
					echo "<a href='#' name='hapuspeserta' data-src='".base_url()."/akademik/kelas/hapuspeserta' id_nilai='{$val->id_nilai}'>hapus</a>";
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function hapuspeserta(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$id_nilai = $this->request->getVar("id_nilai");
		$query = $this->db->table($this->siakad_nilai)->delete(['id_nilai'=>$id_nilai]);
		if($query){
			$ret['messages'] = "Data berhasil dihapus";
			$ret['success'] = true;
		}else{
			$ret['messages']="Data gagal dihapus";
		}
		echo json_encode($ret);
	}
	public function tambahpeserta($id_kelas=false){
		if(!$id_kelas){
			echo "error ID kelas"; exit();
		}
		?>
		<script>
		$('.select2').select2({
			dropdownParent: $("#modalku")
			
		})
		</script>
		<?php
		$mahasiswa = $this->msiakad_riwayatpendidikan->getdata(false,false,false,array(" "));
		echo "<form method='post' id='form_tambah_peserta' action='".base_url()."/akademik/kelas/prosestambahpeserta'>";
		echo "<input type='hidden' name='id_kelas' value='{$id_kelas}'";
		echo csrf_field(); 
		
		echo "<div class='form-group'>";
			echo "<label for='id_riwayatpendidikan'>Mahasiswa</label>";
			echo "<select class='form-control select2' name='id_riwayatpendidikan' id='id_riwayatpendidikan'>";
			if($mahasiswa){
				foreach($mahasiswa as $key=>$val){
					echo "<option value='{$val->id_riwayatpendidikan}'>{$val->nim} - {$val->nama_mahasiswa} - {$val->id_periode_masuk}</option>";
				}
			}
			echo "</select>";
		echo "</div>";
		echo "<div><button type='submit' class='btn btn-success' id='btnSubmit' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	public function prosestambahpeserta(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$id_kelas	= $this->request->getVar("id_kelas");
		$id_riwayatpendidikan	= $this->request->getVar("id_riwayatpendidikan");
		$mahasiswa	= $this->msiakad_riwayatpendidikan->getdata($id_riwayatpendidikan);
		
		$datakelas	= $this->msiakad_kelas->getdata($id_kelas);
		
		$datain = array("kodept"=>$profile->kodept,
						"nim"=>$mahasiswa->nim,
						"kode_matakuliah"=>$datakelas->kode_mata_kuliah,
						"semester"=>$datakelas->id_semester,
						"kelas"=>$datakelas->nama_kelas_kuliah,
						"id_kelas"=>$datakelas->id_kelas,
						"kode_prodi"=>$mahasiswa->kode_prodi,
						"id_prodi"=>$mahasiswa->id_prodi,
						"id_kelas_ws"=>$datakelas->id_kelas_kuliah_ws,
						"id_matkul_ws"=>$datakelas->id_matkul_ws,
						"id_periode_ws"=>$datakelas->id_semester,
						"id_registrasi_mahasiswa"=>$mahasiswa->id_registrasi_mahasiswa,
						"date_created"=>date("Y-m-d H:i:s"));
		$builder = $this->db->table($this->siakad_nilai);
		$builder->where("nim",$mahasiswa->nim);
		$builder->where("kode_matakuliah",$datakelas->kode_mata_kuliah);
		$builder->where("id_kelas",$datakelas->id_kelas);
		$builder->where("kelas",$datakelas->nama_kelas_kuliah);
		$builder->where("semester",$datakelas->id_semester);
		$cekdata = $builder->get();
		if($cekdata->getRowArray() > 0){
			$ret['messages']['id_riwayatpendidikan']="<div class='invalid-feedback'>Data sudah ada</div>";
		}else{
			$query = $this->db->table($this->siakad_nilai)->insert($datain);
			if($query){
				$ret['messages'] = "Data berhasil dimasukan";
				$ret['success'] = true;
			}else{
				$ret['messages']['id_riwayatpendidikan']="<div class='invalid-feedback'>Data tidak dapat dimasukan</div>";
			}				
		}
		echo json_encode($ret);
	}
	//tambah dosen mengajar
	public function tambahdosen($id_kelas=false){
		$profile 	= $this->msiakad_setting->getdata();
		if(!$id_kelas){
			echo "error ID kelas"; exit();
		}
		?>
		<script>
		$('.select2').select2({
			dropdownParent: $("#modalku")
			
		})
		</script>
		<?php
		$dosen = $this->msiakad_dosen->getdata(false,false,false,$profile->kodept);
		$jenisevaluasi = $this->mreferensi->GetJenisEvaluasi();
		echo "<form method='post' id='form_tambah_dosenmengajar' action='".base_url()."/akademik/kelas/prosestambahdosenmengajar'>";
		echo "<input type='hidden' name='id_kelas' value='{$id_kelas}'";
		echo csrf_field(); 
		
		echo "<div class='form-group'>";
			echo "<label for='nidn'>Dosen</label>";
			echo "<select class='form-control select2' name='nidn' id='nidn'>";
			if($dosen){
				foreach($dosen as $key=>$val){
					echo "<option value='{$val->nidn}'>{$val->nidn} - {$val->nama_dosen}</option>";
				}
			}
			echo "</select>";
		echo "</div>";
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='id_jenis_evaluasi'>Jenis Evaluasi</label>";
					echo "<select class='form-control select2' name='id_jenis_evaluasi' id='id_jenis_evaluasi'>";
					if($jenisevaluasi){
						foreach($jenisevaluasi as $key=>$val){
							echo "<option value='{$val->id_jenis_evaluasi}'>{$val->nama_jenis_evaluasi}</option>";
						}
					}
					echo "</select>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='sks_substansi_total'>Bobot sks</label>";
					echo "<input type='text' name='sks_substansi_total' class='form-control'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='rencana_tatap_muka'>Jumlah Rencana Tatap Muka</label>";
					echo "<input type='text' name='rencana_tatap_muka' class='form-control'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='realisasi_tatap_muka'>Jumlah Realisasi Tatap Muka</label>";
					echo "<input type='text' name='realisasi_tatap_muka' class='form-control'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		
		echo "<div><button type='submit' class='btn btn-success' id='btnSubmit' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	public function prosestambahdosenmengajar(){
		if ($this->request->isAJAX()){
			$ret=array("success"=>false,"messages"=>array());
			$profile 	= $this->msiakad_setting->getdata();
			$id_kelas	= $this->request->getVar("id_kelas");
			$nidn 					= $this->request->getVar("nidn");
			$id_jenis_evaluasi 		= $this->request->getVar("id_jenis_evaluasi");
			$realisasi_tatap_muka 	= $this->request->getVar("realisasi_tatap_muka");
			$rencana_tatap_muka 	= $this->request->getVar("rencana_tatap_muka");
			$sks_substansi_total 	= $this->request->getVar("sks_substansi_total");
			
			$datakelas	= $this->msiakad_kelas->getdata($id_kelas);
			$validation =  \Config\Services::validation();   
			
			if (!$this->validate([
				'nidn'=>[
					'rules' => 'trim|required',
					'errors' => [
						'required' => 'NIDN harus dipilih.'
					]
				],
				'sks_substansi_total'=>[
					'rules' => 'required|numeric',
					'errors' => [
						'required' => 'Jumlah bobot sks wajib harus diisi.',
						'numeric'=>'Jumlah sks harus angka'
					]
				],
				'rencana_tatap_muka'=>[
					'rules' => 'required|numeric',
					'errors' => [
						'required' => 'Rencana tatap muka sks wajib harus diisi.',
						'numeric'=>'Rencana tatap muka harus angka'
					]
				]
			]))
			{			
				foreach($validation->getErrors() as $key=>$value){
					$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
				}
			}else{
				//cek data dulu
				$builder = $this->db->table($this->siakad_dosenmengajar);
				$builder->where("nidn",$nidn);
				$builder->where("id_kelas",$id_kelas);
				$query = $builder->get();
				if($query->getRowArray() > 0){
					$ret['messages']['nidn']="<div class='invalid-feedback'>NIDN sudah terdata di kelas ini</div>";
				}else{				
					$datain=array("id_kelas"=>$id_kelas,
								  "nidn"=>$nidn,
								  "kodept"=>$profile->kodept,
								  "id_jenis_evaluasi"=>$id_jenis_evaluasi,
								  "realisasi_tatap_muka"=>$realisasi_tatap_muka,
								  "rencana_tatap_muka"=>$rencana_tatap_muka,
								  "sks_substansi_total"=>$sks_substansi_total,
								  "date_created"=>date("Y-m-d H:i:s"));
					if($this->db->table($this->siakad_dosenmengajar)->insert($datain)){
						$ret["messages"] = "Data sudah dimasuka";
						$ret["success"] = true;
					}
				}
			}
			
			echo json_encode($ret);
		}else{
			echo "Tidak diizinkan..!!!!";
		}
	}
	public function hapusdosenmengajar(){
		if ($this->request->isAJAX()){
			$ret=array("success"=>false,"messages"=>array());
			$profile 	= $this->msiakad_setting->getdata();
			$id_aktivitas_mengajar = $this->request->getVar("id_aktivitas_mengajar");
			if($this->db->table($this->siakad_dosenmengajar)->delete(['id_aktivitas_mengajar'=>$id_aktivitas_mengajar])){
				$ret["messages"] = "Data sudah dihapus";
				$ret["success"] = true;
			}
			echo json_encode($ret);
		}else{
			echo "Tidak diizinkan..!!!!";
		}
	}
}
