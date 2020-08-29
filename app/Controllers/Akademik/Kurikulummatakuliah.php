<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
use App\Models\Msiakad_kurikulummatakuliah;
 
class Kurikulummatakuliah extends BaseController
{
	protected $siakad_kurikulummatakuliah = 'siakad_kurikulummatakuliah';
	protected $feeder_kurikulummatakuliah = 'feeder_kurikulummatakuliah';
	protected $siakad_kelas	= 'siakad_kelas';
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
			'id_kurikulum' => $id_kurikulum
			
		];
		return view('akademik/kurikulummatakuliah',$data);
	}
	public function listdata($id_kurikulum=false)
	{
		if(!$id_kurikulum){
			echo "eRROR id kurikulum"; exit();
		}
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
		echo "<thead><tr><th>No</th><th>Kode Matakuliah</th><th>Nama Matakuliah</th><th>Program Studi</th><th>Semester</th><th>Wajib?</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='7'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				$prodi = $this->msiakad_prodi->getdata(false,false,false,false,$val->kode_prodi);
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->kode_mata_kuliah}</td>";
				echo "<td>{$val->nama_matakuliah}</td>";
				echo "<td>{$prodi->nama_prodi} {$prodi->nama_jenjang_didik}</td>";
				echo "<td>{$val->semester}</td>";
				echo "<td>{$val->apakah_wajib}</td>";
				echo "<td>";
					echo "<a href='#' name='hapuskurikulummatakuliah' data-src='".base_url()."/akademik/kurikulummatakuliah/hapusdata' id_kurikulummatakuliah='{$val->id_kurikulummatakuliah}' id='hapuskurikulummatakuliah_{$val->id_kurikulummatakuliah}'>hapus</a>";
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function hapusdata(){		
		//cek dulu data di kelas
		$ret=array("success"=>false,"messages"=>array());
		$id_kurikulummatakuliah	= $this->request->getVar("id_kurikulummatakuliah");
		$profile 		= $this->msiakad_setting->getdata(); 
		$builder = $this->db->table($this->siakad_kelas);
		$builder->where("id_kurikulummatakuliah",$id_kurikulummatakuliah);
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$ret['messages'] = "Data tidak dapat dihapus karena diacu oleh kelas";
		}else{
			$query = $this->db->table($this->siakad_kurikulummatakuliah)->delete(['id_kurikulummatakuliah'=>$id_kurikulummatakuliah]);
			if($query){	
				$ret['messages'] = "Data berhasil hapus";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal dihapus";
			}	
		}
		
		echo json_encode($ret);
	}
	public function tambah($id_kurikulum=false){
		if(!$id_kurikulum){
			echo "eRROR id kurikulum"; exit();
		}
		?>
		<script>
		  $(function () {
			//Initialize Select2 Elements
			$('.select2').select2()

			//Initialize Select2 Elements
			$('.select2bs4').select2({
			  theme: 'bootstrap4'
			})
		  })
		</script>
		<?php
		$profile 		= $this->msiakad_setting->getdata(); 		
		$jenjang_pendidikan = $this->mreferensi->GetJenjangPendidikan();		
		$prodi 			= $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		$matakuliah 	= $this->msiakad_matakuliah->getdata();
		$apakah_wajib 	= array("1"=>"Wajib","0"=>"Tidak Wajib");
		
		echo "<form method='post' id='form_tambah' action='".base_url()."/akademik/kurikulummatakuliah/create'>";
		echo "<input type='hidden' name='id_kurikulum' value='{$id_kurikulum}'>";
		echo csrf_field(); 
		echo "<div class='form-group'>";
			echo "<label for='id_matakuliah'>Matakuliah</label>";
			echo "<select name='id_matakuliah' id='id_matakuliah' class='form-control select2 select2-hidden-accessible' style='width: 100%;' tabindex='-1' aria-hidden='true'>";
			if($matakuliah){
				foreach($matakuliah as $key=>$val){
					echo "<option value='{$val->id_matakuliah}'>{$val->kode_matakuliah} - {$val->nama_matakuliah} ({$val->sks_matakuliah})</option>";
				}
			}
			echo "</select>";
		echo "</div>";	
				
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='semester'>Semester</label>";
					echo "<select class='form-control' name='semester' id='semester'>";
					for($i=1;$i<=8;$i++){
						echo "<option value='{$i}'>{$i}</option>";
					}
					echo "</select>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='apakah_wajib'>Wajib</label>";
					echo "<select class='form-control' name='apakah_wajib' id='apakah_wajib'>";
					foreach($apakah_wajib as $key=>$val){
						echo "<option value='{$key}'>{$val}</option>";
					}
					echo "</select>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		
		echo "<div><button type='submit' class='btn btn-success' id='btnTambah' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	
	public function create(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 		= $this->msiakad_setting->getdata(); 
		$id_kurikulum 	= $this->request->getVar("id_kurikulum");
		$id_matakuliah	= $this->request->getVar("id_matakuliah");
		$semester		= $this->request->getVar("semester");
		$apakah_wajib	= $this->request->getVar("apakah_wajib");
		
		$kurikulum		= $this->msiakad_kurikulum->getdata($id_kurikulum);
		$matakuliah 	= $this->msiakad_matakuliah->getdata($id_matakuliah);
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'id_matakuliah'=>[
				'rules' => 'required|is_unique[siakad_kurikulummatakuliah.id_matakuliah]',
				'errors' => [
					'required' => 'Nama matakuliahharus dipilih.',
					'is_unique' => 'Data sudah ada.'
				]
			],
			'semester'=>[
				'rules' => 'required|numeric',
				'errors' => [
					'required' => 'Jumlah sks wajib harus diisi.',
					'numeric'=>'Jumlah sks harus angka'
				]
			]
		]))
		{			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{
			
			$datain=array("kodept"=>$profile->kodept,
						  "id_prodi"=>$kurikulum->id_prodi,
						  "id_matakuliah"=>$id_matakuliah,
						  "id_kurikulum"=>$id_kurikulum,
						  "id_kurikulum_ws"=>$kurikulum->id_kurikulum_ws,
						  "id_prodi_ws"=>$kurikulum->id_prodi_ws,
						  "id_matkul_ws"=>$matakuliah->id_matkul_ws,
						  "id_semester"=>$kurikulum->id_semester,
						  "kode_prodi"=>$kurikulum->kode_prodi,
						  "kode_mata_kuliah"=>$matakuliah->kode_matakuliah,
						  "semester"=>$semester,
						  "apakah_wajib"=>$apakah_wajib,
						  "date_insert"=>date("Y-m-d H:i:s"));			
						
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
	
	public function getkurikulummatakuliahpddikti($id_kurikulum){		
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$kurikulum = $this->msiakad_kurikulum->getdata($id_kurikulum);
		if(!$kurikulum->id_kurikulum_ws){
			$ret["messages"] = "Tidak ada kurikulum tersebu PDDIKTI";
		}else{
			$data_kurikulummatakuliah_feeder = $this->msiakad_kurikulummatakuliah->getdatapddikti($kurikulum->id_kurikulum_ws,$profile->kodept);
			
			if(!$data_kurikulummatakuliah_feeder){
				$ret["messages"] = "Tidak ada data PDDIKTI";
			}else{
				$jum=0;
				foreach($data_kurikulummatakuliah_feeder as $key=>$val){
					//cek data dulu
					$cekdata = $this->msiakad_kurikulummatakuliah->getdata(false,false,$val->id_kurikulum,$val->id_prodi,$val->id_matkul,$val->id_semester,$profile->kodept);
					if(!$cekdata){// jika data belum ada
						$datain = array("kodept"=>$val->kode_perguruan_tinggi,
										"id_perguruan_tinggi_ws"=>$val->id_perguruan_tinggi,
										"id_kurikulum_ws"=>$val->id_kurikulum,
										"id_prodi_ws"=>$val->id_prodi,
										"id_matkul_ws"=>$val->id_matkul,
										"id_semester"=>$val->id_semester,
										"kode_mata_kuliah"=>$val->kode_mata_kuliah,
										"semester"=>$val->semester,
										"apakah_wajib"=>$val->apakah_wajib,
										"date_insert"=>date("Y-m-d H:i:s")
										);
						//tambah
						$datain["id_kurikulum"] = $id_kurikulum;
						$prodi = $this->msiakad_prodi->getdata(false,$val->id_prodi,$profile->kodept,false);				
						if($prodi){
							$datain["kode_prodi"] = $prodi->kode_prodi;
							$datain["id_prodi"] = $prodi->id_prodi;
						}
						$matakuliah = $this->msiakad_matakuliah->getdata(false,$val->id_matkul);
						if($matakuliah){
							$datain["id_matakuliah"] = $matakuliah->id_matakuliah;
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
		}		
		echo json_encode($ret);		
	}
}
