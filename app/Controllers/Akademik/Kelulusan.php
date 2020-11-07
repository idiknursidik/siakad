<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
 
class Kelulusan extends BaseController
{
	protected $siakad_lulusan = 'siakad_lulusan';
	protected $feeder_lulusan = 'feeder_lulusan';
	
	public function index()
	{
		
		$data = [
			'title' => 'Data Akademik',
			'judul' => 'Status keluar Mahasiswa',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_kelulusan'=>true
			
		];
		return view('akademik/kelulusan',$data);
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
		$data 		= $this->msiakad_kelulusan->getdata();
		echo "<pre>";
		//print_r($data);
		echo "</pre>";
	//	exit();
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>NIM</th><th>Nama</th><th>Prodi</th><th>Status Keluar</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='7'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nim}</td>";
				echo "<td>{$val->nama_mahasiswa}</td>";
				echo "<td>{$val->nama_prodi}-{$val->nama_jenjang_didik}</td>";
				
				echo "<td>{$val->id_jenis_keluar}</td>";
				echo "<td>";
					echo "<a href='#modalku' data-toggle='modal' class='modalButton' data-src='".base_url()."/akademik/nilai/edit/{$val->id_keluar}' title='Edit data nilai'>edit</a>";
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
		
		echo "<form method='post' id='form_tambah' action='".base_url()."/akademik/kelulusan/create'>";
		echo csrf_field(); 
		
		
					
		echo "<div><button type='submit' class='btn btn-success' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	
	public function create(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata(); 
		
		echo json_encode($ret);
	}
	
	public function edit($id_keluar=false){
		$profile 	= $this->msiakad_setting->getdata();
		if(!$id_keluar){
			echo "Error ID nilai"; exit();
		}
		$data	= $this->msiakad_kelulusan->getdata($id_keluar,false,$profile->kodept);
				
		echo "<form method='post' id='form_ubah' action='".base_url()."/akademik/kelulusan/update'>";
		echo "<input type='hidden' name='id_keluar' value='{$data->id_keluar}'";
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
	
	public function getkelulusanpddikti(){		
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$data_kelulusan_feeder = $this->msiakad_kelulusan->getdatapddikti(false,$profile->kodept);
		
		if(!$data_kelulusan_feeder){
			$ret["messages"] = "Tidak ada data PDDIKTI";
		}else{
			$jum=0;
			foreach($data_kelulusan_feeder as $key=>$val){
				//cek data dulu
				$arraywhere = ['id_mahasiswa_ws' => $val->id_mahasiswa];
				$builder = $this->db->table($this->siakad_lulusan);
				$builder->where($arraywhere);				
				$cekdata = $builder->countAllResults();
				
				if($cekdata == 0){// jika data belum ada
					$datain = array("nim"=>$val->nim,									
									"kodept"=>$val->kode_perguruan_tinggi,
									"id_prodi_ws"=>$val->id_prodi,
									"id_jenis_keluar"=>$val->id_jenis_keluar,
									"id_mahasiswa_ws"=>$val->id_mahasiswa,
									"id_periode_keluar"=>$val->id_periode_keluar,
									"id_registrasi_mahasiswa"=>$val->id_registrasi_mahasiswa,
									"ipk"=>$val->ipk,
									"jalur_skripsi"=>$val->jalur_skripsi,
									"judul_skripsi"=>$val->judul_skripsi,									
									"asal_ijazah"=>$val->asal_ijazah,
									"nomor_ijazah"=>$val->nomor_ijazah,
									"nomor_sk_yudisium"=>$val->nomor_sk_yudisium,
									"tanggal_keluar"=>$val->tanggal_keluar,
									"tanggal_sk_yudisium"=>$val->tanggal_sk_yudisium,
									"date_created"=>date("Y-m-d H:i:s")
									);
					
					$prodi = $this->msiakad_prodi->getdata(false,$val->id_prodi,$profile->kodept,false);
					if($prodi){				
						$datain["kode_prodi"]=$prodi->kode_prodi;
						$datain["id_prodi"]=$prodi->id_prodi;
					}
					
					$query = $this->db->table($this->siakad_lulusan)->insert($datain);
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
