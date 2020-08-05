<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Nilaitransfer extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Nilai Transfer Mahasiswa PDDIKTI',
			'judul' => 'Nilai Transfer Mahasiswa PDDIKTI',
			'mn_feeder_a'=>true,
			'mn_nilaitransfer'=>true
		];
		return view('feeder/nilaitransfer',$data);
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
		
		$datanilaitransferws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetNilaiTransferPendidikanMahasiswa');
		//dd($datanilaitransferws);
		
		$data = $this->mfeeder_data->getnilaitransfer(false,false,$dataptws->data[0]->id_perguruan_tinggi);
		if(!$data){
			echo "<a class='btn btn-primary' href='#' id='ambilriwayatpendidikan' data-src='".base_url()."/feeder/nilaitransfer/inputdata'>Ambil data</a>";
		}else{
			echo "<a class='btn btn-primary' id='ambilriwayatpendidikan' style='float:right' href='#' data-src='".base_url()."/feeder/nilaitransfer/inputdata'>Update data</a>";
			echo "<div class='clearfix'></div><hr>";
			echo "<table class='table' id='datatable'>";
			echo "<thead><tr><th width='1'>No</th><th>NIM</th><th>Nama</th><th>Program Studi</th><th>Matakuliah</th><th>SKS</th></tr></thead>";
			echo "<tbody>";
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nim}</td>";
				echo "<td>{$val->nama_mahasiswa}</td>";
				echo "<td>{$val->nama_program_studi}</td>";
				echo "<td>{$val->kode_matkul_diakui}</td>";
				echo "<td>{$val->sks_mata_kuliah_diakui}</td>";
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
			
			$datanilaitransferws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetNilaiTransferPendidikanMahasiswa');			
			$dataptws = $this->mfungsi->object_to_array($dataptws->data[0]);
		
			foreach($datanilaitransferws->data as $key=>$val){
				$datain = $this->mfungsi->object_to_array($val);		
				$datain['id_perguruan_tinggi'] = $dataptws['id_perguruan_tinggi'];
				$datain['kode_perguruan_tinggi'] = $dataptws['kode_perguruan_tinggi'];
				
				$cekdata = $this->mfeeder_data->getnilaitransfer($val->id_transfer);
				if(!$cekdata){
					$query = $this->db->table('feeder_nilaitransfer')->insert($datain);
					$ret['messages'] = "Data berhasil dimasukan";
					$ret['success'] = true;
				}else{
					//update
					$query = $this->db->table('feeder_nilaitransfer')->update($datain, array("id_transfer"=>$val->id_transfer));
					$ret['messages'] = "Data berhasil diupdate";
					$ret['success'] = true;
				}
				
			}
		}			
		echo json_encode($ret);
		
	}
	

}
