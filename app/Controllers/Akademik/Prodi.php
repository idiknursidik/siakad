<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;

class Prodi extends BaseController
{
	private $siakad_prodi = "siakad_prodi";
	public function index()
	{

		$data = [
			'title' => 'Data Akademik',
			'judul' => 'Data Program Studi',
			'mn_akademik' => true,
			'mn_akademik_prodi' => true
			
		];
		return view('akademik/prodi',$data);
	}
	public function listdata()
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
		$profile 	= $this->msiakad_setting->getdata(); 
		if(!$profile){
			echo "Kelola dahulu <b>Setting Profile</b> -> pada menu <b>Setting Sistem</ab> ";
			exit();
		}
		$data 		= $this->msiakad_prodi->getdata(false,false,$profile->kodept,false);
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th width='1'>No</th><th>Kode Prodi</th><th>Nama Prodi</th><th>Jenjang</th><th>Status</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='6'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				$jenjang_pendidikan = $this->mreferensi->GetJenjangPendidikan($val->id_jenjang);
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->kode_prodi}</td>";
				echo "<td>{$val->nama_prodi}</td>";
				echo "<td>{$jenjang_pendidikan->nama_jenjang_didik}</td>";
				echo "<td>{$val->status}</td>";
				echo "<td>{";
					echo "<a href='#modalku' data-toggle='modal' name='ubah' title='Ubah Data' class='modalButton' data-src='".base_url()."/akademik/prodi/ubah/{$val->id_prodi}'>ubah</a>";
					echo "- <a href='#' name='hapus' data-src='".base_url()."/akademik/prodi/hapus' id_prodi='{$val->id_prodi}'>hapus</a>}";
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function hapus(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$id_prodi = $this->request->getVar("id_prodi");
		//cek data yang diacu
		$cekdataprodi = $this->msiakad_riwayatpendidikan->getdata(false,false,false,false,false,$id_prodi);
		if($cekdataprodi){
			$ret["messages"] = "Data tidak dapat dihapus sudah diacu oleh mahasiswa";
		}else{
			$query = $this->db->table($this->siakad_prodi)->delete(['id_prodi'=>$id_prodi,'kodept'=>$profile->kodept]);
			if($query){
				$ret["messages"] = "Data berhasil dihapus";
				$ret["success"] = true;
			}else{
				$ret["messages"] = "Data gagal dihapus";
			}
		}
		echo json_encode($ret);	
	}
	public function tambah(){
		$jenjang_pendidikan = $this->mreferensi->GetJenjangPendidikan();
		echo "<form method='post' id='form_tambah' action='".base_url()."/akademik/prodi/create'>";
		echo csrf_field(); 		
		echo "<div class='form-group'>";
			echo "<label for='kodeprodi'>Kode Prodi</label>";
			echo "<input type='text' class='form-control' name='kodeprodi' id='kodeprodi'>";
		echo "</div>";
		echo "<div class='form-group'>";
			echo "<label for='namaprodi'>Nama Prodi</label>";
			echo "<input type='text' name='namaprodi' class='form-control' id='namaprodi'>";
		echo "</div>";
		echo "<div class='form-group'>";
			echo "<label for='jenjang'>Jenjang Prodi</label>";
			echo "<select name='jenjang' class='form-control' id='jenjang'>";
			if($jenjang_pendidikan){
				foreach($jenjang_pendidikan as $key=>$val){
					echo "<option value='{$val->id_jenjang_didik}'>{$val->nama_jenjang_didik}</option>";
				}
			}
			echo "</select>";
		echo "</div>";
		echo "<div><button type='submit' class='btn btn-success' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	public function create(){
		$ret=array("success"=>false,"messages"=>array());
		$validation =  \Config\Services::validation();
		$profile 	= $this->msiakad_setting->getdata();
		
		$kodept	= $profile->kodept;
		$kode_prodi	= $this->request->getVar("kodeprodi");
		$nama_prodi	= $this->request->getVar("namaprodi");
		$id_jenjang	= $this->request->getVar("jenjang");
		if (! $this->validate([
			'kodeprodi' =>[
				'rules' => 'required|is_unique[siakad_prodi.kode_prodi,kodept]',
				'errors' => [
					'required' => 'Kode prodi harus diisi.',
					'is_unique'=> 'Data sudah ada didatabase'
				]
			],
			'namaprodi'  => [
				'rules' => 'required',
				'errors' => [
					'required' => 'namaprodi harus diisi.'
				]
			],
			'jenjang'  => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Jenjang harus diisi.'
				]
			]
		]))
		{
			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
			
		}else{
			if(!$kodept){
				$ret['messages'] = "Data gagal ditambahkan kodept belum di set";
			}else{
				$datain = array("kodept"=>$kodept,
								"kode_prodi"=>$kode_prodi,
								"nama_prodi"=>$nama_prodi,
								"id_jenjang"=>$id_jenjang);
				$query = $this->db->table($this->siakad_prodi)->insert($datain);
				if($query){
					$ret['success'] = true;
					$ret['messages'] = "Data berhasil ditambahkan";
				}else{
					$ret['messages'] = "Data gagal ditambahkan";
				}
			}
		}
		echo json_encode($ret);
	}
	
	public function ubah($id_prodi){
		$profile 	= $this->msiakad_setting->getdata();
		$data = $this->msiakad_prodi->getdata($id_prodi,false,false,false);
		$jenjang_pendidikan = $this->mreferensi->GetJenjangPendidikan();
		echo "<form method='post' id='form_ubah' action='".base_url()."/akademik/prodi/update'>";
		echo "<input type='hidden' name='id_prodi' value='{$id_prodi}'>";
		echo csrf_field(); 		
		echo "<div class='form-group'>";
			echo "<label for='kodeprodi'>Kode Prodi</label>";
			echo "<input type='text' class='form-control' name='kodeprodi' id='kodeprodi' value='{$data->kode_prodi}'>";
		echo "</div>";
		echo "<div class='form-group'>";
			echo "<label for='namaprodi'>Nama Prodi</label>";
			echo "<input type='text' name='namaprodi' class='form-control' id='namaprodi' value='{$data->nama_prodi}'>";
		echo "</div>";
		echo "<div class='form-group'>";
			echo "<label for='jenjang'>Jenjang Prodi</label>";
			echo "<select name='jenjang' class='form-control' id='jenjang'>";
			if($jenjang_pendidikan){
				foreach($jenjang_pendidikan as $key=>$val){
					echo "<option value='{$val->id_jenjang_didik}'";
					if($data->id_jenjang == $val->id_jenjang_didik) echo " selected='selected'";
					echo ">{$val->nama_jenjang_didik}</option>";
				}
			}
			echo "</select>";
		echo "</div>";
		echo "<div><button type='submit' class='btn btn-success' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	public function update(){
		$ret=array("success"=>false,"messages"=>array());
		$validation =  \Config\Services::validation();
		$profile 	= $this->msiakad_setting->getdata();
		
		$kodept	= $profile->kodept;
		$id_prodi	= $this->request->getVar("id_prodi");
		$kode_prodi	= $this->request->getVar("kodeprodi");
		$nama_prodi	= $this->request->getVar("namaprodi");
		$id_jenjang	= $this->request->getVar("jenjang");
		//cek data dulu
		$cekdata = $this->db->table($this->siakad_prodi)->getWhere(['id_prodi' => $id_prodi,'kodept'=>$kodept]);
		if($cekdata->getRowArray() > 0){
			$data_cek = $cekdata->getResult();
			if($data_cek[0]->kode_prodi != $kode_prodi){
				$rule_kodeprodi = 'required|is_unique[siakad_prodi.kode_prodi,kodept]';
			}else{
				$rule_kodeprodi = 'required';
			}
		}else{
			$rule_kodeprodi = 'required|is_unique[siakad_prodi.kode_prodi,kodept]';
		}
		
		if (! $this->validate([
			'kodeprodi' =>[
				'rules' => $rule_kodeprodi,
				'errors' => [
					'required' => 'Kode prodi harus diisi.',
					'is_unique'=> 'Data sudah ada didatabase'
				]
			],
			'namaprodi'  => [
				'rules' => 'required',
				'errors' => [
					'required' => 'namaprodi harus diisi.'
				]
			],
			'jenjang'  => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Jenjang harus diisi.'
				]
			]
		]))
		{
			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
			
		}else{
			$datain = array("kodept"=>$kodept,
							"kode_prodi"=>$kode_prodi,
							"nama_prodi"=>$nama_prodi,
							"id_jenjang"=>$id_jenjang);
			$query = $this->db->table($this->siakad_prodi)->update($datain, array('id_prodi' => $id_prodi,'kodept'=>$kodept));
			if($query){
				$ret['success'] = true;
				$ret['messages'] = "Data berhasil diupdate";
			}else{
				$ret['messages'] = "Data gagal diupdate";
			}
		}
		echo json_encode($ret);
	}
	public function getprodipddikti(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$data_prodi_feeder = $this->msiakad_prodi->getdatapddikti(false,$profile->kodept);
		if(!$data_prodi_feeder){
			$ret["messages"] = "Tidak ada data PDDIKTI";
		}else{
			$jum=0;
			foreach($data_prodi_feeder as $key=>$val){
				//cek data dulu
				$cekdata = $this->msiakad_prodi->getdata(false,$val->id_prodi,$profile->kodept,false);
				if(!$cekdata){// jika data belum ada
					$datain = array("id_prodi_ws"=>$val->id_prodi,
									"kodept"=>$val->kode_perguruan_tinggi,
									"kode_prodi"=>$val->kode_program_studi,
									"nama_prodi"=>$val->nama_program_studi,
									"status"=>$val->status,
									"id_jenjang"=>$val->id_jenjang_pendidikan);
					$query = $this->db->table('siakad_prodi')->insert($datain);
					if($query){
						$jum++;
					}
				}
			}
			if($jum > 0){
				$ret["messages"] = "{$jum} data berhasil dimasukan";
				$ret["success"] = true;
			}else{
				$ret["messages"] = "tidak ada data yang dimasukan";
			}
		}		
		echo json_encode($ret);		
	}
	
}
