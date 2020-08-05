<?php 
namespace App\Controllers\Impor;
use App\Controllers\BaseController;

class Mahasiswa extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Data Mahasiswa',
			'judul' => 'Data Mahasiswa',
			'mn_feeder_b'=>true,
			'mn_b_mahasiswa'=>true
		];
		return view('impor/mahasiswa',$data);
	}
	public function show()
	{
		$profile 	= $this->msiakad_setting->getdata(); 
		$data 		= $this->msiakad_mahasiswa->getdata(false,false,false,$profile->kodept);
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
		$profile 	= $this->msiakad_setting->getdata(); 
		$data 		= $this->msiakad_mahasiswa->getdata(false,false,false,$profile->kodept);
		
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Nama</th><th>Tanggal lahir</th><th>Jenis Kelamin</th><th>NIK</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='2'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nama_mahasiswa}</td>";
				echo "<td>{$val->tanggal_lahir}</td>";
				echo "<td>{$val->jenis_kelamin}</td>";
				echo "<td>{$val->nik}</td>";
				echo "<td><a href='#' name='impormahasiswa_{$val->id_pendaftaran}' data-src='".base_url()."/impor/mahasiswa/prosesimpor' idpendaftaran='{$val->id_pendaftaran}'>Kirim ke Feeder</a></td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function prosesimpor(){
		$ret=array("success"=>false,"messages"=>array());
		$id_pendaftaran = $this->request->getVar("idpendaftaran");
		$data 		= $this->msiakad_mahasiswa->getdata($id_pendaftaran);
		
		$session 		= \Config\Services::session();
		$feeder_akun = $session->get("feeder_akun");
		
		$InsertBiodataMahasiswa = $this->mdictionary->InsertBiodataMahasiswa();
		$record=array();
		foreach($InsertBiodataMahasiswa as $value){
			if(strlen($data->$value) > 0){
				$field = $value;
				$record[$field] = ($data->$value != '0000-00-00')?$data->$value:"";
			}
		}
		$insertdataws = $this->mfeeder_ws->insertws($feeder_akun->token,'InsertBiodataMahasiswa',$record);
		$insertdataws = json_decode($insertdataws);
		if($insertdataws->error_code){
			$ret["messages"] = $insertdataws->error_desc;
		}else{
			//update mahasiswa di local
			$dataup = array("id_mahasiswa"=>$insertdataws->data->id_mahasiswa);
			$this->db->table('siakad_mahasiswa')->update($dataup, array('id_pendaftaran' => $id_pendaftaran));
			$ret["success"] = true;
			$ret["messages"] = "Data berhasil dimasukan.";
		}
		echo json_encode($ret);
	}
	
}
