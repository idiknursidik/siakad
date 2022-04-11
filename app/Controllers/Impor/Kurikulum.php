<?php 
namespace App\Controllers\Impor;
use App\Controllers\BaseController;

class Kurikulum extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Data Kurikulum',
			'judul' => 'Data Kurikulum',
			'mn_feeder_b'=>true,
			'mn_b_kurikulum'=>true
		];
		return view('impor/kurikulum',$data);
	}
	public function show()
	{
		$profile 	= $this->msiakad_setting->getdata(); 
		$data 		= $this->msiakad_kurikulum->getdata();
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
		echo "<thead><tr><th>No</th><th>Nama Kurikulum</th><th>Program Studi</th><th>Mulai Berlaku</th><th>Lulus</th><th>Wajib</th><th>Pilihan</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='2'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nama_kurikulum}</td>";
				echo "<td>{$val->nama_prodi} {$val->id_jenjang}</td>";
				echo "<td>{$val->semester_mulai_berlaku}</td>";
				echo "<td>{$val->jumlah_sks_lulus}</td>";
				echo "<td>{$val->jumlah_sks_pilihan}</td>";
				echo "<td>{$val->jumlah_sks_wajib}</td>";
				if($val->id_kurikulum_ws == ""){
					echo "<td><a href='#' name='imporkurikulum_{$val->id_kurikulum}' data-src='".base_url()."/impor/kurikulum/prosesimpor' id_kurikulum='{$val->id_kurikulum}'>Kirim ke Feeder</a></td>";
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
		$id_kurikulum = $this->request->getVar("id_kurikulum");
		$data 		= $this->msiakad_kurikulum->getdata($id_kurikulum);
		
		$session 		= \Config\Services::session();
		$feeder_akun = $session->get("feeder_akun");
		
		$InsertKurikulum = $this->mdictionary->InsertKurikulum();
		$record=array();
		foreach($InsertKurikulum as $key=>$value){
			$record[$key] = $data->$value;
		}
		
		$insertdataws = $this->mfeeder_ws->insertws($feeder_akun->token,'InsertKurikulum',$record);
		$insertdataws = json_decode($insertdataws);
		//print_r($insertdataws);
		if($insertdataws){
			if(!isset($insertdataws->error_code)){
				$ret["messages"] = $insertdataws;
			}else{			
				//update mahasiswa di local
				$dataup = array("id_kurikulum_ws"=>$insertdataws->data->id_kurikulum);
				$this->db->table('siakad_kurikulum')->update($dataup, array('id_kurikulum' => $id_kurikulum));
				$ret["success"] = true;
				$ret["messages"] = "Data berhasil dimasukan.";
			}
		}
		echo json_encode($ret);
	}
	
}
