<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Datadosen extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Data Dosen',
			'judul' => 'Data Dosen',
			'mn_feeder_a'=>true,
			'mn_datadosen'=>true
		];
		return view('feeder/datadosen',$data);
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
		
		$data = $this->mfeeder_data->getdatadosen(false,false,false,$dataptws->data[0]->id_perguruan_tinggi);
		if(!$data){
			echo "<a class='btn btn-primary' href='#' id='ambildata' data-src='".base_url()."/feeder/datadosen/inputdata'>Ambil data</a>";
		}else{
			echo "<a class='btn btn-primary' id='ambildata' style='float:right' href='#' data-src='".base_url()."/feeder/datadosen/inputdata'>Update data</a>";
			echo "<div class='clearfix'></div><hr>";
			echo "<table class='table' id='datatable'>";
			echo "<thead><tr><th width='1'>No</th><th>NIDN</th><th>Nama Dosen</th></tr></thead>";
			echo "<tbody>";
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nidn}</td>";
				echo "<td>{$val->nama_dosen}</td>";
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
			
			$datadosen = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetListDosen');			
			$dataptws = $this->mfungsi->object_to_array($dataptws->data[0]);
			$jumlahupdate=0;
			$jumlahinsert=0;
			foreach($datadosen->data as $key=>$val){
				$datain = $this->mfungsi->object_to_array($val);		
				$datain['id_perguruan_tinggi'] = $dataptws['id_perguruan_tinggi'];
				$datain['kode_perguruan_tinggi'] = $dataptws['kode_perguruan_tinggi'];
				
				$cekdata = $this->mfeeder_data->getdatadosen($val->id_dosen);
				if(!$cekdata){
					$query = $this->db->table('feeder_dosen')->insert($datain);
					$jumlahinsert++;
				}else{
					//update
					$query = $this->db->table('feeder_dosen')->update($datain, array("id_dosen"=>$val->id_dosen));
					$jumlahupdate++;
				}
				
			}
			$jum = $jumlahinsert + $jumlahupdate;
			if($jum>0){
				$ret['messages'] = "{$jumlahinsert} Data berhasil dimasukan dan {$jumlahupdate} data berhasil diupdate";
				$ret['success'] = true;
			}else{
				$ret['messages'] = "Tidak ada data yang dimasukan";
			}
		}			
		echo json_encode($ret);
		
	}
	

}
