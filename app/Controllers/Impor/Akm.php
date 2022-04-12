<?php 
namespace App\Controllers\Impor;
use App\Controllers\BaseController;

class Akm extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Data AKM',
			'judul' => 'Data AKM',
			'mn_feeder_b'=>true,
			'mn_b_akm'=>true
		];
		return view('impor/akm',$data);
	}
	public function show()
	{
		$profile 	= $this->msiakad_setting->getdata(); 
		$data 		= $this->msiakad_akm->getdata(false,false,false,$profile->kodept);
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
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
		
		
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Nim</th><th>Nama</th><th>Prodi</th><th>Angkatan</th><th>Semester</th><th>Status</th><th>IPS</th><th>IPK</th><th>SKS Semester</th><th>SKS Total</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='11'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nim}</td>";
				echo "<td>{$val->nama_mahasiswa}</td>";
				echo "<td>{$val->nama_prodi} {$val->nama_jenjang_didik}</td>";
				echo "<td>{$val->angkatan}</td>";
				echo "<td>{$val->id_semester}</td>";
				echo "<td>{$val->id_status_mahasiswa}</td>";
				echo "<td>{$val->ips}</td>";
				echo "<td>{$val->ipk}</td>";
				echo "<td>{$val->sks_semester}</td>";
				echo "<td>{$val->sks_total}</td>";
				if($val->id_registrasi_mahasiswa_ws == ""){
					echo "<td><a href='#' name='imporakm_{$val->id_akm}' data-src='".base_url()."/impor/akm/prosesimpor' id_akm='{$val->id_akm}'>Kirim ke Feeder</a></td>";
				}else{
					echo "<td>UPDATE</td>";
				}
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function prosesimpor(){
		$ret=array("success"=>false,"messages"=>array());
		$id_akm = $this->request->getVar("id_akm");
		$data 		= $this->msiakad_akm->getdata($id_akm);
		
		$session 		= \Config\Services::session();
		$feeder_akun = $session->get("feeder_akun");
		
		$InsertPerkuliahanMahasiswa = $this->mdictionary->InsertPerkuliahanMahasiswa();
		$record=array();
		foreach($InsertPerkuliahanMahasiswa as $key=>$value){			
			$record[$key] = $data->$value;			
		}
		/*
		$ok= json_decode('{
        "id_registrasi_mahasiswa":"75E2E249-D4E5-4843-AC58-462DFEACE163",
        "id_semester":"20192",
        "id_status_mahasiswa":"C",
        "ips":0.0,
        "ipk":0.0,
        "sks_semester":0,
        "total_sks":108,
        "biaya_kuliah_smt":0
    }');
		$cek= (array)$ok;
		*/
		$insertdataws = $this->mfeeder_ws->insertws($feeder_akun->token,'InsertPerkuliahanMahasiswa',$record);
		$insertdataws = json_decode($insertdataws);
		//echo "<pre>";
		//print_r($record);
		//echo "</pre>";
		if($insertdataws->error_code){
			$ret["messages"] = $insertdataws->error_desc;
		}else{
			//update mahasiswa di local
			$dataup = array("id_registrasi_mahasiswa_ws"=>$insertdataws->data->id_registrasi_mahasiswa);
			$this->db->table('siakad_akm')->update($dataup, array('id_akm' => $id_akm));
			$ret["success"] = true;
			$ret["messages"] = "Data berhasil dimasukan.";
		}
		echo json_encode($ret);
	}
	
}
