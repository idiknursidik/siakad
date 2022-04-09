<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
 
class Dosenmengajar extends BaseController
{
	protected $siakad_dosenmengajar = 'siakad_dosenmengajar';
	protected $feeder_dosenmengajar = 'feeder_dosenmengajar';
	protected $siakad_dosen = 'siakad_dosen';
	
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
		echo "<thead><tr><th>No</th><th>NIDN, Nama Dosen</th><th>Kelas</th><th>Matakuliah</th><th>Semester</th><th>Rencana</th><th>Realisasi</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='8'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nidn} {$val->nama_dosen}</td>";
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
	
	public function getdosenmengajarpddikti(){
		if ($this->request->isAJAX()){		
			$ret=array("success"=>false,"messages"=>array());		
			$profile 	= $this->msiakad_setting->getdata();
			$data_dosenmengajar_feeder = $this->msiakad_dosenmengajar->getdatapddikti(false,false,$profile->kodept);
			//print_r($data_dosenmengajar_feeder);
			//exit();
			if(!$data_dosenmengajar_feeder){
				$ret["messages"] = "Tidak ada data PDDIKTI";
			}else{
				$jum=0;
				foreach($data_dosenmengajar_feeder as $key=>$val){
					//cek data dulu
					$arraywhere = ['id_aktivitas_mengajar_ws' => $val->id_aktivitas_mengajar,'id_kelas_kuliah_ws'=>$val->id_kelas_kuliah,'nidn'=>$val->nidn, 'kodept' => $profile->kodept];
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
	public function getdatadosenpddikti(){
		if ($this->request->isAJAX()){		
			$ret=array("success"=>false,"messages"=>array());		
			$profile 	= $this->msiakad_setting->getdata();
			$data_datadosen_feeder = $this->msiakad_dosen->getdatapddikti(false,$profile->kodept);
			
			if(!$data_datadosen_feeder){
				$ret["messages"] = "Tidak ada data PDDIKTI";
			}else{
				$jum=0;
				foreach($data_datadosen_feeder as $key=>$val){
					//cek data dulu
					$arraywhere = ['id_dosen_ws' => $val->id_dosen, 'kodept' => $profile->kodept];
					$builder = $this->db->table($this->siakad_dosen);
					$builder->where($arraywhere);				
					$cekdata = $builder->countAllResults();
					
					if($cekdata == 0){// jika data belum ada
						$datain = array("kodept"=>$val->kode_perguruan_tinggi,
										"id_agama"=>$val->id_agama,
										"id_dosen_ws"=>$val->id_dosen,
										"id_status_aktif_ws"=>$val->id_status_aktif,
										"jenis_kelamin"=>$val->jenis_kelamin,
										"nama_agama"=>$val->nama_agama,
										"nama_dosen"=>$val->nama_dosen,
										"nama_status_aktif"=>$val->nama_status_aktif,
										"nidn"=>$val->nidn,
										"nip"=>$val->nip,
										"sumberdata"=>'pddikti',
										"tanggal_lahir"=>$val->tanggal_lahir,
										"date_created"=>date("Y-m-d H:i:s")
										);
						$query = $this->db->table($this->siakad_dosen)->insert($datain);
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
