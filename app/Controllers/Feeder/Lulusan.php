<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Lulusan extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Lulusan Mahasiswa PDDIKTI',
			'judul' => 'Lulusan Mahasiswa PDDIKTI',
			'mn_feeder_a'=>true,
			'mn_lulusan'=>true
		];
		return view('feeder/lulusan',$data);
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
		
		//$dataakmws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetAktivitasKuliahMahasiswa',false,false,100);
		//dd($dataakmws);
		
		$data = $this->mfeeder_data->getlulusan(false,false,$dataptws->data[0]->id_perguruan_tinggi);
		if(!$data){
			echo "<a class='btn btn-primary' href='#' id='ambildatalulusan' data-src='".base_url()."/feeder/lulusan/inputdata'>Ambil data</a>";
		}else{
			echo "<a class='btn btn-primary' id='ambildatalulusan' style='float:right' href='#' data-src='".base_url()."/feeder/lulusan/inputdata'>Update data</a>";
			echo "<div class='clearfix'></div><hr>";
			echo "<table class='table' id='datatable'>";
			echo "<thead><tr><th width='1'>No</th><th>NIM</th><th>Nama</th><th>Nama Jenis keluar</th></tr></thead>";
			echo "<tbody>";
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nim}</td>";
				echo "<td>{$val->nama_mahasiswa}</td>";
				echo "<td>{$val->nama_jenis_keluar}</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";			
		}
		
	}
	public function inputdata(){
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
			
			$dataakmws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetDetailMahasiswaLulusDO');			
			$dataptws = $this->mfungsi->object_to_array($dataptws->data[0]);
		
			foreach($dataakmws->data as $key=>$val){
				$datain = $this->mfungsi->object_to_array($val);		
				$datain['id_perguruan_tinggi'] = $dataptws['id_perguruan_tinggi'];
				$datain['kode_perguruan_tinggi'] = $dataptws['kode_perguruan_tinggi'];
				
				$cekdata = $this->mfeeder_data->getlulusan($val->id_mahasiswa);
				if(!$cekdata){
					$query = $this->db->table('feeder_lulusan')->insert($datain);
					$ret['messages'] = "Data berhasil dimasukan";
					$ret['success'] = true;
				}else{
					//update
					$query = $this->db->table('feeder_lulusan')->update($datain, array("id_mahasiswa"=>$val->id_mahasiswa));
					$ret['messages'] = "Data berhasil diupdate";
					$ret['success'] = true;
				}
				
			}
		}			
		echo json_encode($ret);
		
	}
	

}
