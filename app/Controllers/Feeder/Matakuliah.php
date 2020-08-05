<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Matakuliah extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Matakuliah PDDIKTI',
			'judul' => 'Matakuliah PDDIKTI',
			'mn_feeder_a'=>true,
			'mn_matakuliah'=>true
		];
		return view('feeder/matakuliah',$data);
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
		
		//$datamatakuliahws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetListMataKuliah',false,false,5);
		//dd($datamatakuliahws);
		
		$data = $this->mfeeder_data->getmatakuliah(false,false,$dataptws->data[0]->id_perguruan_tinggi);
		if(!$data){
			echo "<a class='btn btn-primary' href='#' id='ambildata' data-src='".base_url()."/feeder/matakuliah/inputdata'>Ambil data</a>";
		}else{
			echo "<a class='btn btn-primary' id='ambildata' style='float:right' href='#' data-src='".base_url()."/feeder/matakuliah/inputdata'>Update data</a>";
			echo "<div class='clearfix'></div><hr>";
			echo "<table class='table' id='datatable'>";
			echo "<thead><tr><th width='1'>No</th><th>Program Studi</th><th>KodeMK</th><th>Matakuliah</th></tr></thead>";
			echo "<tbody>";
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nama_program_studi}</td>";
				echo "<td>{$val->kode_mata_kuliah}</td>";
				echo "<td>{$val->nama_mata_kuliah}</td>";
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
			
			$datamatakuliahws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetDetailMataKuliah');			
			$dataptws = $this->mfungsi->object_to_array($dataptws->data[0]);
		
			foreach($datamatakuliahws->data as $key=>$val){
				$datain = $this->mfungsi->object_to_array($val);		
				$datain['id_perguruan_tinggi'] = $dataptws['id_perguruan_tinggi'];
				$datain['kode_perguruan_tinggi'] = $dataptws['kode_perguruan_tinggi'];
				
				$cekdata = $this->mfeeder_data->getmatakuliah($val->id_matkul);
				if(!$cekdata){
					$query = $this->db->table('feeder_matakuliah')->insert($datain);
					$ret['messages'] = "Data berhasil dimasukan";
					$ret['success'] = true;
				}else{
					//update
					$query = $this->db->table('feeder_matakuliah')->update($datain, array("id_matkul"=>$val->id_matkul));
					$ret['messages'] = "Data berhasil diupdate";
					$ret['success'] = true;
				}
				
			}
		}			
		echo json_encode($ret);
		
	}
	

}
