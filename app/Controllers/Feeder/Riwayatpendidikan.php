<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Riwayatpendidikan extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Riwayat Pendidikan Mahasiswa PDDIKTI',
			'judul' => 'Riwayat Pendidikan Mahasiswa PDDIKTI',
			'mn_feeder_a'=>true,
			'mn_riwayatpendidikan'=>true
		];
		return view('feeder/riwayatpendidikan',$data);
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
		
		$datariwayatpendidikanws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetListRiwayatPendidikanMahasiswa');
		//dd($datariwayatpendidikanws);
		
		$data = $this->mfeeder_data->getriwayatpendidikan(false,$dataptws->data[0]->id_perguruan_tinggi);
		if(!$data){
			echo "<a class='btn btn-primary' href='#' id='ambilriwayatpendidikan' data-src='".base_url()."/feeder/riwayatpendidikan/inputdata'>Ambil data</a>";
		}else{
			echo "<a class='btn btn-primary' id='ambilriwayatpendidikan' style='float:right' href='#' data-src='".base_url()."/feeder/riwayatpendidikan/inputdata'>Update data</a>";
			echo "<div class='clearfix'></div><hr>";
			echo "<table class='table' id='datatable'>";
			echo "<thead><tr><th width='1'>No</th><th>NIM</th><th>Nama</th><th>Program Studi</th><th>Semester Masuk</th><th>Status</th></tr></thead>";
			echo "<tbody>";
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nim}</td>";
				echo "<td>{$val->nama_mahasiswa}</td>";
				echo "<td>{$val->nama_program_studi}</td>";
				echo "<td>{$val->nama_periode_masuk}</td>";
				echo "<td>{$val->keterangan_keluar}</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";			
		}
		
		//echo "<pre>";
		//print_r($datamahasiswaws->data);
		//echo "</pre>";
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
			
			$datariwayatpendidikanws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetListRiwayatPendidikanMahasiswa');		
			$dataptws = $this->mfungsi->object_to_array($dataptws->data[0]);
		
			foreach($datariwayatpendidikanws->data as $key=>$val){
				$datain = $this->mfungsi->object_to_array($val);	
				$datain['kode_perguruan_tinggi'] = $dataptws['kode_perguruan_tinggi'];
			
				$cekdata = $this->mfeeder_data->getriwayatpendidikan($val->id_mahasiswa,$val->id_perguruan_tinggi,$val->id_prodi);
				if(!$cekdata){
					$query = $this->db->table('feeder_riwayatpendidikan')->insert($datain);
					$ret['messages'] = "Data berhasil dimasukan";
					$ret['success'] = true;
				}else{
					//update
					$query = $this->db->table('feeder_riwayatpendidikan')->update($datain, array("id_mahasiswa"=>$val->id_mahasiswa,"id_perguruan_tinggi"=>$val->id_perguruan_tinggi,"id_prodi"=>$val->id_prodi));
					$ret['messages'] = "Data berhasil diupdate";
					$ret['success'] = true;
				}
				
			}
		}			
		echo json_encode($ret);
		
	}
	

}
