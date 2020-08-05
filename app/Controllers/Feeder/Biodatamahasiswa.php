<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Biodatamahasiswa extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Biodata Mahasiswa PDDIKTI',
			'judul' => 'Biodata Mahasiswa PDDIKTI',
			'mn_feeder_a'=>true,
			'mn_biodatamahasiswa'=>true
		];
		return view('feeder/biodatamahasiswa',$data);
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
		
		//$databiodatamahasiswaws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetBiodataMahasiswa');
		$data = $this->mfeeder_data->getbiodatadatamahasiswa(false,$dataptws->data[0]->id_perguruan_tinggi);
		if(!$data){
			echo "<a class='btn btn-primary' id='ambilbiodatamahasiswa' href='#' data-src='".base_url()."/feeder/biodatamahasiswa/inputdata'>Ambil data</a>";
		}else{
			echo "<a href='#' class='btn btn-primary' id='ambilbiodatamahasiswa' style='float:right' data-src='".base_url()."/feeder/biodatamahasiswa/inputdata'>Update data</a>";
			echo "<div class='clearfix'></div><hr>";
			echo "<table class='table' id='datatable'>";
			echo "<thead><tr><th width='1'>No</th><th>Nama</th><th>Jenis Kelamin</th><th>Tempat Lahir</th><th>Tanggal Lahir</th></tr></thead>";
			echo "<tbody>";
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nama_mahasiswa}</td>";
				echo "<td>{$val->jenis_kelamin}</td>";
				echo "<td>{$val->tempat_lahir}</td>";
				echo "<td>{$val->tanggal_lahir}</td>";
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
		//dd($dataptws);
		$databiodatamahasiswaws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetBiodataMahasiswa');		
		
		$dataptws = $this->mfungsi->object_to_array($dataptws->data[0]);
	
		foreach($databiodatamahasiswaws->data as $key=>$val){
			$datain = $this->mfungsi->object_to_array($val);
			$datain['id_perguruan_tinggi'] = $dataptws['id_perguruan_tinggi'];
			$datain['kode_perguruan_tinggi'] = $dataptws['kode_perguruan_tinggi'];
			
			$cekdata = $this->mfeeder_data->getbiodatadatamahasiswa($val->id_mahasiswa);
			if(!$cekdata){
				$query = $this->db->table('feeder_biodatamahasiswa')->insert($datain);
				$ret = "Data berhasil dimasukan";
			}else{
				//update
				$query = $this->db->table('feeder_biodatamahasiswa')->update($datain, array('id_mahasiswa' => $val->id_mahasiswa));
				$ret = "Data berhasil diupdate";
			}
			
		}		
		echo $ret;
		//return redirect()->to(base_url().'/feeder/biodatamahasiswa');		
	}
	

}
