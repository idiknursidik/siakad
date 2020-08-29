<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Dosenmengajar extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Aktivitas Mengajar Dosen',
			'judul' => 'Aktivitas Mengajar Dosen',
			'mn_feeder_a'=>true,
			'mn_dosenmengajar'=>true
		];
		return view('feeder/dosenmengajar',$data);
	}
	public function show()
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
		$cekkoneksi = $this->mfeeder_ws->cekkoneksifeeder();
		if($cekkoneksi){
			echo $cekkoneksi;	
			exit();			
		}
		$session 		= \Config\Services::session();
		$feeder_akun = $session->get("feeder_akun");
		//$token, $table, $filter, $order, $limit, $offset
		$dataptws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetProfilPT','',false,'1','0');
		if($dataptws->error_code != 0){
			echo $dataptws->error_desc;
			exit();
		}
		
		$data = $this->mfeeder_data->getdosenmengajar(false,false,false,$dataptws->data[0]->id_perguruan_tinggi);
		if(!$data){
			echo "<a class='btn btn-primary' href='#' id='ambildata' data-src='".base_url()."/feeder/dosenmengajar/inputdata'>Ambil data</a>";
		}else{
			echo "<a class='btn btn-primary' id='ambildata' style='float:right' href='#' data-src='".base_url()."/feeder/dosenmengajar/inputdata'>Update data</a>";
			echo "<div class='clearfix'></div><hr>";
			echo "<table class='table' id='datatable'>";
			echo "<thead><tr><th width='1'>No</th><th>Nama Dosen</th><th>Kelas</th><th>Rencana</th><th>Realiasi</th></tr></thead>";
			echo "<tbody>";
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nama_dosen}</td>";
				echo "<td>{$val->id_kelas_kuliah}</td>";
				echo "<td>{$val->rencana_tatap_muka}</td>";
				echo "<td>{$val->realisasi_tatap_muka}</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";			
		}
		
	}
	public function inputdata(){
		ini_set('memory_limit', '-1');
		set_time_limit(0);
		$ret=array("success"=>false,"messages"=>array());
		//cek koneksi
		$cekkoneksi = $this->mfeeder_ws->cekkoneksifeeder();
		$error=false;
		if($cekkoneksi){
			$ret['messages'] = $cekkoneksi;
			$error=true;
		}
		if(!$error){
			$session 		= \Config\Services::session();
			$feeder_akun = $session->get("feeder_akun");
			$dataptws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetProfilPT','',false,'1','0');
			
			$datakurikulumws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetDosenPengajarKelasKuliah');			
			$dataptws = $this->mfungsi->object_to_array($dataptws->data[0]);
		
			foreach($datakurikulumws->data as $key=>$val){
				$datain = $this->mfungsi->object_to_array($val);		
				$datain['id_perguruan_tinggi'] = $dataptws['id_perguruan_tinggi'];
				$datain['kode_perguruan_tinggi'] = $dataptws['kode_perguruan_tinggi'];
				
				$cekdata = $this->mfeeder_data->getdosenmengajar($val->id_aktivitas_mengajar);
				if(!$cekdata){
					$query = $this->db->table('feeder_dosenmengajar')->insert($datain);
					$ret['messages'] = "Data berhasil dimasukan";
					$ret['success'] = true;
				}else{
					//update
					$query = $this->db->table('feeder_dosenmengajar')->update($datain, array("id_aktivitas_mengajar"=>$val->id_aktivitas_mengajar));
					$ret['messages'] = "Data berhasil diupdate";
					$ret['success'] = true;
				}
				
			}
		}			
		echo json_encode($ret);
		
	}
	

}
