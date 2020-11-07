<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
 
class Akm extends BaseController
{
	protected $siakad_akm = 'siakad_akm';
	protected $feeder_akm = 'feeder_akm';
	
	public function index()
	{
		
		$data = [
			'title' => 'Data Akademik',
			'judul' => 'Aktifitas Kuliah Mahasiswa',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_akm'=>true
			
		];
		return view('akademik/akm',$data);
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
		$data 		= $this->msiakad_akm->getdata();
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>NIM</th><th>Nama</th><th>Prodi</th><th>Semester</th><th>Status</th><th>IPS</th><th>IPK</th><th>sks Semester</th><th>sks Total</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='7'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				$statusmahasiswa = $this->mreferensi->GetStatusMahasiswa($val->id_status_mahasiswa);
				$statusmahasiswa = ($statusmahasiswa)?$statusmahasiswa->nama_status_mahasiswa:$val->id_status_mahasiswa;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nim}</td>";
				echo "<td>{$val->nama_mahasiswa}</td>";
				echo "<td>{$val->nama_prodi}-{$val->nama_jenjang_didik}</td>";
				//echo "<td>{$val->id_periode_masuk}</td>";
				echo "<td>{$val->id_semester}</td>";
				echo "<td>{$statusmahasiswa}</td>";
				echo "<td>{$val->ips}</td>";
				echo "<td>{$val->ipk}</td>";
				echo "<td>{$val->sks_semester}</td>";
				echo "<td>{$val->sks_total}</td>";
				echo "<td>";
					echo "<a href='#modalku' data-toggle='modal' class='modalButton' data-src='".base_url()."/akademik/nilai/edit/{$val->id_akm}' title='Edit data nilai'>edit</a>";
					echo " - <a>hapus</a>";
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function tambah(){
		echo "Tambah dari excel";
		$profile 	= $this->msiakad_setting->getdata(); 		
		
		echo "<form method='post' id='form_tambah' action='".base_url()."/akademik/nilai/create'>";
		echo csrf_field(); 
		
		
					
		echo "<div><button type='submit' class='btn btn-success' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	
	public function create(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata(); 
		
		echo json_encode($ret);
	}
	
	public function edit($id_nilai=false){
		$profile 	= $this->msiakad_setting->getdata();
		if(!$id_nilai){
			echo "Error ID nilai"; exit();
		}
		$data	= $this->msiakad_nilai->getdata($id_nilai,false,false,false,false,$profile->kodept);
				
		echo "<form method='post' id='form_ubah' action='".base_url()."/akademik/nilai/update'>";
		echo "<input type='hidden' name='id_nilai' value='{$data->id_nilai}'";
		echo csrf_field(); 
		
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='nilai_huruf'>Nilai Huruf</label>";
					echo "<input type='text' class='form-control' name='nilai_huruf' id='nilai_huruf' value='{$data->nilai_huruf}'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='nilai_indeks'>Nilai Indeks </label>";
					echo "<input type='text' class='form-control' name='nilai_indeks' id='nilai_indeks' value='{$data->nilai_indeks}'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
			
		echo "<div><button type='submit' class='btn btn-success' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	public function update(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata(); 
		//cek dulu apakah sudah ada
		$id_nilai = $this->request->getVar("id_nilai");
				
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'nilai_huruf' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nilai huruf harus diisi.'
				]
			],
			'nilai_indeks' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nilai indeks harus diisi.'
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
				if(!in_array($key,array("csrf_test_name"))){
					$datain[$key] =  $this->request->getVar($key);
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
	
	public function getakmpddikti(){		
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$data_akm_feeder = $this->msiakad_akm->getdatapddikti(false,false,$profile->kodept);
		
		if(!$data_akm_feeder){
			$ret["messages"] = "Tidak ada data PDDIKTI";
		}else{
			$jum=0;
			foreach($data_akm_feeder as $key=>$val){
				//cek data dulu
				$arraywhere = ['nim' => $val->nim, 'id_semester' => $val->id_semester];
				$builder = $this->db->table($this->siakad_akm);
				$builder->where($arraywhere);				
				$cekdata = $builder->countAllResults();
				
				if($cekdata == 0){// jika data belum ada
					$datain = array("nim"=>$val->nim,
									"kodept"=>$val->kode_perguruan_tinggi,									
									"id_semester"=>$val->id_semester,
									"id_status_mahasiswa"=>$val->id_status_mahasiswa,
									"ips"=>$val->ips,
									"sks_semester"=>$val->sks_semester,
									"ipk"=>$val->ipk,
									"sks_total"=>$val->sks_total,
									"angkatan"=>$val->angkatan,
									"id_prodi_ws"=>$val->id_prodi,
									"biaya_kuliah_smt"=>$val->biaya_kuliah_smt,									
									"id_mahasiswa_ws"=>$val->id_mahasiswa,
									"id_status_mahasiswa_ws"=>$val->id_status_mahasiswa,
									"date_created"=>date("Y-m-d H:i:s")
									);
				
					$prodi = $this->msiakad_prodi->getdata(false,$val->id_prodi,$profile->kodept,false);
					if($prodi){				
						$datain["kode_prodi"]=$prodi->kode_prodi;
						$datain["id_prodi"]=$prodi->id_prodi;
					}
					
					$query = $this->db->table($this->siakad_akm)->insert($datain);
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
