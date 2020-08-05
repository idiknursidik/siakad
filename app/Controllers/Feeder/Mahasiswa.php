<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Mahasiswa extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Data Mahasiswa PDDIKTI',
			'judul' => 'Data Mahasiswa PDDIKTI',
			'mn_feeder_a'=>true,
			'mn_mahasiswa'=>true
		];
		return view('feeder/mahasiswa',$data);
	}
	public function resultheader(){
		$session = \Config\Services::session();
		$value = $session->get("progress");
		if($value == 100){
			$session->set("progress",5);
			$retval = 5;
		}else{
			$retval = $value;
		}
		echo $retval;
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
		$session 		= \Config\Services::session();
		$feeder_akun = $session->get("feeder_akun");
		
		$dataptws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetProfilPT','',false,'1','0');
		//$datamahasiswaws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetListMahasiswa');
		
		$data = $this->mfeeder_data->getdatamahasiswa(false,false,$dataptws->data[0]->id_perguruan_tinggi);
		if(!$data){
			echo "<a class='btn btn-primary' href='#' id='ambilmahasiswa' data-src='".base_url()."/feeder/mahasiswa/inputdata'>Ambil data</a>";
		}else{
			echo "<a class='btn btn-primary' id='ambilmahasiswa' style='float:right' href='#' data-src='".base_url()."/feeder/mahasiswa/inputdata'>Update data</a>";
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
				echo "<td>{$val->id_periode}</td>";
				echo "<td>{$val->nama_status_mahasiswa}</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";			
		}
	}
	public function inputdata(){
		ini_set('memory_limit', '-1');
		set_time_limit(0);
		$session 		= \Config\Services::session();
		$feeder_akun = $session->get("feeder_akun");
		
		$dataptws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetProfilPT','',false,'1','0');
		$datamahasiswaws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetListMahasiswa');
		
		
		$dataptws = $this->mfungsi->object_to_array($dataptws->data[0]);
		
		$i=0;
		foreach($datamahasiswaws->data as $key=>$val){
			$i++;
			$datain = $this->mfungsi->object_to_array($val);
			$datain['kode_perguruan_tinggi'] = $dataptws['kode_perguruan_tinggi'];
			
			$cekdata = $this->mfeeder_data->getdatamahasiswa($val->id_mahasiswa);
			if(!$cekdata){
				$query = $this->db->table('feeder_mahasiswa')->insert($datain);
				$ret = "Data berhasil dimasukan";
			}else{
				//update
				$query = $this->db->table('feeder_mahasiswa')->update($datain, array('id_mahasiswa' => $val->id_mahasiswa));
				$ret = "Data berhasil diupdate";
			}
			$percent = intval($i/count($datamahasiswaws->data) * 100);
			$session->set('progress',$percent);
		}	
		echo $ret;
		//return redirect()->to(base_url().'/feeder/mahasiswa');
		
	}
	

}
