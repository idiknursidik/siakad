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
		$data 		= $this->msiakad_mahasiswa->getdata(false,false,false,false,$profile->kodept);
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
				if($val->id_mahasiswa_ws == ""){
					echo "<td><a href='#' name='impormahasiswa_{$val->id_mahasiswa}' data-src='".base_url()."/impor/mahasiswa/prosesimpor' id_mahasiswa='{$val->id_mahasiswa}'>Kirim ke Feeder</a></td>";
				}else{
					echo "<td>UPDATE</td>";
				}
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function prosesimpor(){
		$ret=array("success"=>false,"messages"=>array());
		$id_mahasiswa = $this->request->getVar("id_mahasiswa");
		$data 		= $this->msiakad_mahasiswa->getdata(false,$id_mahasiswa);
		
		$session 		= \Config\Services::session();
		$feeder_akun = $session->get("feeder_akun");
		
		$InsertBiodataMahasiswa = $this->mdictionary->InsertBiodataMahasiswa();
		$arrayFieldInt=array("id_agama","npwp","kode_pos","telepon","handphone","nisn","rt","rw","id_wilayah","id_jenis_tinggal","id_alat_transportasi","penerima_kps","id_pendidikan_ayah","id_pekerjaan_ayah","id_penghasilan_ayah","id_pendidikan_ibu","id_pekerjaan_ibu","id_penghasilan_ibu","id_pendidikan_wali","id_pekerjaan_wali","id_penghasilan_wali","id_kebutuhan_khusus_mahasiswa","id_kebutuhan_khusus_ayah","id_kebutuhan_khusus_ibu");
		$record=array();
		foreach($InsertBiodataMahasiswa as $value){
			$field = $value;
			if(!in_array($field,$arrayFieldInt)){
				$record[$field] = ($data->$value != '0000-00-00' || $data->$value == "")?$data->$value:null;
			}else{
				$record[$field] = ($data->$value == "")?null:(int)$data->$value;
			}
		}
		/*
		
		$ok= json_decode('{"nama_mahasiswa":"wildan tea","jenis_kelamin":"L","tempat_lahir":"Subang","tanggal_lahir":"1990-07-22","id_agama":1,"nik":"3343423423234123","nisn":654321,"npwp":123456,"kewarganegaraan":"ID","jalan":"Nanggela","dusun":"Nanggela","rt":1,"rw":5,"kelurahan":"Kertaharja","kode_pos":41284,"id_wilayah":999999,"id_jenis_tinggal":1,"id_alat_transportasi":2,"telepon":null,"handphone":85220795671,"email":"deden@uinsgd.ac.id","penerima_kps":null,"nomor_kps":null,"nik_ayah":"2342343434567568","nama_ayah":"Jamad Edi Suhendi","tanggal_lahir_ayah":"1939-04-23","id_pendidikan_ayah":6,"id_pekerjaan_ayah":5,"id_penghasilan_ayah":14,"nik_ibu":"2342342345645785","nama_ibu_kandung":"Imas Amaliah","tanggal_lahir_ibu":"1960-01-20","id_pendidikan_ibu":6,"id_pekerjaan_ibu":2,"id_penghasilan_ibu":14,"nama_wali":null,"tanggal_lahir_wali":null,"id_pendidikan_wali":null,"id_pekerjaan_wali":null,"id_penghasilan_wali":null,"id_kebutuhan_khusus_mahasiswa":0,"id_kebutuhan_khusus_ayah":0,"id_kebutuhan_khusus_ibu":0}');
		
		$ok2 = json_decode('{"nama_mahasiswa":"Pangeran Ridwan","jenis_kelamin":"L","tempat_lahir":"Banggai","tanggal_lahir":"2001-03-03","id_agama":1,"nik":"8208060305400002","nisn":1234567123,"npwp":null,"kewarganegaraan":"ID","jalan":"Jl. Raya tanjung situ","dusun":null,"rt":5,"rw":0,"kelurahan":"Kelurahan Tanjung Situ","kode_pos":null,"id_wilayah":999999,"id_jenis_tinggal":1,"id_alat_transportasi":0,"telepon":null,"handphone":null,"email":null,"penerima_kps":0,"nomor_kps":null,"nik_ayah":"8208060305400001","nama_ayah":"Ayahku","tanggal_lahir_ayah":"1980-10-01","id_pendidikan_ayah":35,"id_pekerjaan_ayah":6,"id_penghasilan_ayah":13,"nik_ibu":"8208060305400001","nama_ibu_kandung":"Ibuku","tanggal_lahir_ibu":"1982-01-04","id_pendidikan_ibu":20,"id_pekerjaan_ibu":9,"id_penghasilan_ibu":14,"nama_wali":null,"tanggal_lahir_wali":null,"id_pendidikan_wali":null,"id_pekerjaan_wali":null,"id_penghasilan_wali":null,"id_kebutuhan_khusus_mahasiswa":0,"id_kebutuhan_khusus_ayah":0,"id_kebutuhan_khusus_ibu":0}');
		//exit();
		*/
		$insertdataws = $this->mfeeder_ws->insertws($feeder_akun->token,'InsertBiodataMahasiswa',$record);
		$insertdataws = json_decode($insertdataws);
		//echo "<pre>";
		//print_r($insertdataws);
		//echo "</pre>";
		if($insertdataws->error_code){
			$ret["messages"] = $insertdataws->error_desc;
		}else{
			//update mahasiswa di local
			$dataup = array("id_mahasiswa_ws"=>$insertdataws->data->id_mahasiswa);
			$this->db->table('siakad_mahasiswa')->update($dataup, array('id_mahasiswa' => $id_mahasiswa));
			$ret["success"] = true;
			$ret["messages"] = "Data berhasil dimasukan.";
		}
		echo json_encode($ret);
	}
	
}
