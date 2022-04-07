<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Kurikulummatakuliah extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Kurikulummatakuliah PDDIKTI',
			'judul' => 'Kurikulummatakuliah PDDIKTI',
			'mn_feeder_a'=>true,
			'mn_kurikulum_matakuliah'=>true
		];
		return view('feeder/kurikulummatakuliah',$data);
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
		
		//$dataKurikulummatakuliahws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetListKurikulummatakuliah',false,false,5);
		//dd($dataKurikulummatakuliahws);
		
		$data = $this->mfeeder_data->getkurikulummatakuliah(false,false,false,$dataptws->data[0]->id_perguruan_tinggi);
		if(!$data){
			echo "<a class='btn btn-primary' href='#' name='ambildata' id='btnSubmit_ambildata' data-src='".base_url()."/feeder/kurikulummatakuliah/inputdata'>Ambil data</a>";
		}else{
			echo "<a class='btn btn-primary' name='ambildata' id='btnSubmit_ambildata' style='float:right' href='#' data-src='".base_url()."/feeder/kurikulummatakuliah/inputdata'>Update data</a>";
			echo "<div class='clearfix'></div><hr>";
			echo "<table class='table' id='datatable'>";
			echo "<thead><tr><th width='1'>No</th><th>Kurikulum</th><th>Semester</th><th>Matakuliah</th></tr></thead>";
			echo "<tbody>";
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nama_kurikulum}</td>";
				echo "<td>{$val->id_semester}</td>";
				echo "<td>{$val->kode_mata_kuliah} {$val->nama_mata_kuliah}</td>";
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
			
			$datakurikulummatakuliahws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetMatkulKurikulum');
	
			$dataptws = $this->mfungsi->object_to_array($dataptws->data[0]);
			
			foreach($datakurikulummatakuliahws->data as $key=>$val){
				$datain = $this->mfungsi->object_to_array($val);		
				$datain['id_perguruan_tinggi'] = $dataptws['id_perguruan_tinggi'];
				$datain['kode_perguruan_tinggi'] = $dataptws['kode_perguruan_tinggi'];
				
				$cekdata = $this->mfeeder_data->getkurikulummatakuliah($val->id_kurikulum,$val->id_semester,$val->id_matkul);
				//dd($datain);
				if(!$cekdata){
					$query = $this->db->table('feeder_kurikulummatakuliah')->insert($datain);
					$ret=array('success'=>true,'messages'=> "Data berhasil dimasukan");
				}else{
					//update
					$query = $this->db->table('feeder_kurikulummatakuliah')->update($datain, array("id_kurikulum"=>$val->id_kurikulum,"id_matkul"=>$val->id_matkul,"id_semester"=>$val->id_semester));
					$ret=array('success'=>true,'messages'=> "Data berhasil diupdate");
				}
				
			}
		}			
		echo json_encode($ret);
		
	}
	

}
