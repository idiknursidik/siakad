<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
use App\Libraries\Datatables;
use App\Models\Msiakad_akm;

class Akm extends BaseController
{
	protected $siakad_akm = 'siakad_akm';
	protected $feeder_akm = 'feeder_akm';
	protected $siakad_riwayatpendidikan = 'siakad_riwayatpendidikan';
	protected $siakad_mahasiswa = 'siakad_mahasiswa';
	protected $siakad_prodi = 'siakad_prodi';
	protected $ref_getjenjangpendidikan = 'ref_getjenjangpendidikan';
	protected $ref_getstatusmahasiswa = 'ref_getstatusmahasiswa';
	

	public function __construct()
    {
        $this->msiakad_akm = new Msiakad_akm();
    }
	public function index()
	{
		
		$data = [
			'title' => 'Data Akademik',
			'judul' => 'Aktifitas Kuliah Mahasiswa',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_akm'=>true
			
		];
		return view('akademik/akm',$data);
	}
	public function listdataserverside(){
		$datatables = new Datatables;		
		$datatables->table("{$this->siakad_akm} a");
		$datatables->join("{$this->siakad_riwayatpendidikan} b","a.nim = b.nim","LEFT JOIN");
		$datatables->join("{$this->siakad_mahasiswa} c","b.id_mahasiswa = c.id_mahasiswa","LEFT JOIN");
		$datatables->join("{$this->siakad_prodi} d","b.id_prodi = d.id_prodi","LEFT JOIN");
		$datatables->join("{$this->ref_getjenjangpendidikan} e","d.id_jenjang = e.id_jenjang_didik","LEFT JOIN");
		$datatables->join("{$this->ref_getstatusmahasiswa} f","a.id_status_mahasiswa = f.id_status_mahasiswa","LEFT JOIN");
		$datatables->select('a.id_akm,a.nim as nim_mahasiswa,a.id_semester,a.ips,a.ipk,a.sks_semester,a.sks_total,b.id_periode_masuk,b.id_registrasi_mahasiswa,c.nama_mahasiswa,d.nama_prodi,e.nama_jenjang_didik,f.nama_status_mahasiswa');
		echo $datatables->draw();
		// Automatically return json
	}
	public function showdataserverside(){
	?>
	<script type="text/javascript">
		$(document).ready( function () {
		  var table = $('#myTable').DataTable({ 
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": "<?php echo base_url('/akademik/akm/listdataserverside')?>",
				"type": "POST"
			},
			"dataType": "json",
		    "type": "POST",
		    "columns": [
		          { "data": "id_akm" },
		          { "data": "nim_mahasiswa" },
		          { "data": "nama_mahasiswa" },				  
				  { "data": "nama_prodi" },
				  { "data": "id_semester" },
		          { "data": "nama_status_mahasiswa" },
				  { "data": "ips" },
				  { "data": "ipk" },
				  { "data": "sks_semester" },
				  { "data": "sks_total" },
				  { "data": "sks_total" },
		       ],
			"order": [[ 1, "desc" ]]
		});
			table.on( 'draw.dt', function () {
			var PageInfo = $('#myTable').DataTable().page.info();
				 table.column(0, { page: 'current' }).nodes().each( function (cell, i) {
					cell.innerHTML = i + 1 + PageInfo.start;
				} );
			} );
		
		} );
		</script>
	<table id="myTable" class="table table-striped table-bordered table-hover">
      <thead><tr><th>No</th><th>NIM</th><th>Nama</th><th>Prodi</th><th>Semester</th><th>Status</th><th>IPS</th><th>IPK</th><th>sks Semester</th><th>sks Total</th><th>Aksi</th></tr></thead>
      <tbody>
      </tbody>
    </table>
	<?php
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
		$data 		= $this->msiakad_akm->getdata();
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>NIM</th><th>Nama</th><th>Prodi</th><th>Semester</th><th>Status</th><th>IPS</th><th>IPK</th><th>sks Semester</th><th>sks Total</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='7'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				$statusmahasiswa = $this->mreferensi->GetStatusMahasiswa($val->id_status_mahasiswa);
				$statusmahasiswa = ($statusmahasiswa)?$statusmahasiswa->nama_status_mahasiswa:$val->id_status_mahasiswa;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nim}</td>";
				echo "<td>{$val->nama_mahasiswa}</td>";
				echo "<td>{$val->nama_prodi}-{$val->nama_jenjang_didik}</td>";
				//echo "<td>{$val->id_periode_masuk}</td>";
				echo "<td>{$val->id_semester}</td>";
				echo "<td>{$statusmahasiswa}</td>";
				echo "<td>{$val->ips}</td>";
				echo "<td>{$val->ipk}</td>";
				echo "<td>{$val->sks_semester}</td>";
				echo "<td>{$val->sks_total}</td>";
				echo "<td>";
					echo "<a href='#modalku' data-toggle='modal' class='modalButton' data-src='".base_url()."/akademik/akm/edit/{$val->id_akm}' title='Edit data AKM'>edit</a>";
					echo " - <a href='".base_url()."/akademik/akm/destroy' name='hapusdata_{$val->id_akm}' id_akm='{$val->id_akm}'>hapus</a>";
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function destroy(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata(); 
		$id_akm = $this->request->getVar("id_akm");
		
		$res =$this->db->table($this->siakad_akm)->delete(['id_akm'=>$id_akm]);
		if($res){
			$ret=array("success"=>true,"messages"=>"Data berhasil dihapus");
		}else{
			$ret['messages'] = "Data tidak dapat dihapus";
		}
		echo json_encode($ret);
	}
	public function tambah(){
		$profile 	= $this->msiakad_setting->getdata(); 		
		$GetStatusMahasiswa = $this->mreferensi->GetStatusMahasiswa();
		echo "<form method='post' id='form_tambah' action='".base_url()."/akademik/akm/create'>";
		echo csrf_field(); 
		echo "<div class='row'>";
			echo "<div class='col-md-6'>";
				echo "<label>Mahasiswa</label>";
				echo "<input type='text' name='nim' class='form-control'>";
			echo "</div>";
			echo "<div class='col-md-6'>";
				echo "<label>Semester</label>";
				echo "<input type='text' name='id_semester' class='form-control'>";
			echo "</div>";
		echo "</div>";
		echo "<div class='row'>";
			echo "<div class='col-md-6'>";
				echo "<label>Status Mahasiswa</label>";
				echo "<select name='id_status_mahasiswa' class='form-control'>";
				if($GetStatusMahasiswa){
					foreach($GetStatusMahasiswa as $key=>$val){
						echo "<option value='{$val->id_status_mahasiswa}'";
						if($this->request->getVar('id_status_mahasiswa') == $val->id_status_mahasiswa) echo " selected='selected'";
						echo ">{$val->nama_status_mahasiswa}</option>";
					}
				}
				echo "</select>";
			echo "</div>";
			echo "<div class='col-md-6'>";
				echo "<label>IPS</label>";
				echo "<input type='text' name='ips' class='form-control'>";
			echo "</div>";
		echo "</div>";
		echo "<div class='row'>";
			echo "<div class='col-md-6'>";
				echo "<label>IPK</label>";
				echo "<input type='text' name='ipk' class='form-control'>";
			echo "</div>";
			echo "<div class='col-md-6'>";
				echo "<label>Jumlah SKS Semester</label>";
				echo "<input type='text' name='sks_semester' class='form-control'>";
			echo "</div>";
		echo "</div>";
		echo "<div class='row'>";
			echo "<div class='col-md-6'>";
				echo "<label>SKS Total</label>";
				echo "<input type='text' name='sks_total' class='form-control'>";
			echo "</div>";
			echo "<div class='col-md-6'>";
				echo "<label>Biaya Kuliah (semester)</label>";
				echo "<input type='text' name='biaya_kuliah_smt' class='form-control'>";
			echo "</div>";
		echo "</div>";
		echo "<hr>";			
		echo "<div><button type='submit' class='btn btn-success' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	
	public function create(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata(); 
		$nim = $this->request->getVar("nim");
		$id_semester = $this->request->getVar("id_semester");
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'id_status_mahasiswa' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Status mahasiswa huruf harus diisi.'
				]
			],
			'nim' => [
				'rules' => 'required|cekduplicatakm[nim,id_semester]',
				'errors' => [
					'required' => 'Nim indeks harus diisi.',
					'cekduplicatakm' => 'Data sudah ada.'
				]
			],'id_semester' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Id semester harus diisi.',
				]
			]
		]))
		{			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{
			$mahasiswa = $this->msiakad_riwayatpendidikan->getdata(false,false,$profile->kodept,false,$nim);
			
			$datain=array();
			foreach($this->request->getVar() as $key=>$val){
				if(!in_array($key,array("csrf_test_name"))){
					$datain[$key] =  $this->request->getVar($key);
				}
			}
			
			$datain['kodept']=$profile->kodept;
			$datain['kode_prodi']=$mahasiswa->kode_prodi;
			$datain['id_prodi']=$mahasiswa->id_prodi;
			$datain['angkatan']=substr($mahasiswa->id_periode_masuk,0,4);
			$datain['date_created']=date('Y-m-d H:i:s');
			
			$query = $this->db->table($this->siakad_akm)->insert($datain);		
			if($query){	
				$ret['messages'] = "Data berhasil dimasukan";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal dimasukan";
			}			
		}	
		echo json_encode($ret);
	}
	
	public function edit($id_akm=false){
		$profile 	= $this->msiakad_setting->getdata();
		if(!$id_akm){
			echo "Error AKM nilai"; exit();
		}
		$data	= $this->msiakad_akm->getdata($id_akm);
		$GetStatusMahasiswa = $this->mreferensi->GetStatusMahasiswa();
		echo "<form method='post' id='form_tambah' action='".base_url()."/akademik/akm/update'>";
		echo "<input type='hidden' name='id_akm' value='{$id_akm}'>";
		echo csrf_field(); 
		echo "<div class='row'>";
			echo "<div class='col-md-6'>";
				echo "<label>Mahasiswa</label>";
				echo "<input type='text' name='nim' value='{$data->nim}' readonly class='form-control'>";
			echo "</div>";
			echo "<div class='col-md-6'>";
				echo "<label>Semester</label>";
				echo "<input type='text' name='id_semester' class='form-control' value='{$data->id_semester}' readonly>";
			echo "</div>";
		echo "</div>";
		echo "<div class='row'>";
			echo "<div class='col-md-6'>";
				echo "<label>Status Mahasiswa</label>";
				echo "<select name='id_status_mahasiswa' class='form-control'>";
				if($GetStatusMahasiswa){
					foreach($GetStatusMahasiswa as $key=>$val){
						echo "<option value='{$val->id_status_mahasiswa}'";
						if($data->id_status_mahasiswa == $val->id_status_mahasiswa) echo " selected='selected'";
						echo ">{$val->nama_status_mahasiswa}</option>";
					}
				}
				echo "</select>";
			echo "</div>";
			echo "<div class='col-md-6'>";
				echo "<label>IPS</label>";
				echo "<input type='text' name='ips' class='form-control' value='{$data->ips}'>";
			echo "</div>";
		echo "</div>";
		echo "<div class='row'>";
			echo "<div class='col-md-6'>";
				echo "<label>IPK</label>";
				echo "<input type='text' name='ipk' class='form-control' value='{$data->ipk}'>";
			echo "</div>";
			echo "<div class='col-md-6'>";
				echo "<label>Jumlah SKS Semester</label>";
				echo "<input type='text' name='sks_semester' class='form-control' value='{$data->sks_semester}'>";
			echo "</div>";
		echo "</div>";
		echo "<div class='row'>";
			echo "<div class='col-md-6'>";
				echo "<label>SKS Total</label>";
				echo "<input type='text' name='sks_total' class='form-control' value='{$data->sks_total}'>";
			echo "</div>";
			echo "<div class='col-md-6'>";
				echo "<label>Biaya Kuliah (semester)</label>";
				echo "<input type='text' name='biaya_kuliah_smt' class='form-control' value='{$data->biaya_kuliah_smt}'>";
			echo "</div>";
		echo "</div>";
		echo "<hr>";			
		echo "<div><button type='submit' class='btn btn-success' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	public function update(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata(); 
		$id_akm = $this->request->getVar("id_akm");
		$nim = $this->request->getVar("nim");
		$id_semester = $this->request->getVar("id_semester");
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'id_status_mahasiswa' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Status mahasiswa huruf harus diisi.'
				]
			],
			'nim' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nim indeks harus diisi.'
				]
			],'id_semester' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Id semester harus diisi.',
				]
			]
		]))
		{			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{
			$mahasiswa = $this->msiakad_riwayatpendidikan->getdata(false,false,$profile->kodept,false,$nim);
			
			$datain=array();
			foreach($this->request->getVar() as $key=>$val){
				if(!in_array($key,array("csrf_test_name"))){
					$datain[$key] =  $this->request->getVar($key);
				}
			}
			
			$datain['kodept']=$profile->kodept;
			$datain['kode_prodi']=$mahasiswa->kode_prodi;
			$datain['id_prodi']=$mahasiswa->id_prodi;
			$datain['angkatan']=substr($mahasiswa->id_periode_masuk,0,4);
			$datain['date_created']=date('Y-m-d H:i:s');
			
			$query = $this->db->table($this->siakad_akm)->update($datain,array("id_akm"=>$id_akm));		
			if($query){	
				$ret['messages'] = "Data berhasil diupdate";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal diupdate";
			}			
		}	
		echo json_encode($ret);
	}
	
	public function getakmpddikti(){		
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$data_akm_feeder = $this->msiakad_akm->getdatapddikti(false,false,$profile->kodept);
		
		if(!$data_akm_feeder){
			$ret["messages"] = "Tidak ada data PDDIKTI";
		}else{
			$jum=0;
			foreach($data_akm_feeder as $key=>$val){
				//cek data dulu
				$arraywhere = ['nim' => $val->nim, 'id_semester' => $val->id_semester];
				$builder = $this->db->table($this->siakad_akm);
				$builder->where($arraywhere);				
				$cekdata = $builder->countAllResults();
				
				if($cekdata == 0){// jika data belum ada
					$datain = array("nim"=>$val->nim,
									"kodept"=>$val->kode_perguruan_tinggi,									
									"id_semester"=>$val->id_semester,
									"id_status_mahasiswa"=>$val->id_status_mahasiswa,
									"ips"=>$val->ips,
									"sks_semester"=>$val->sks_semester,
									"ipk"=>$val->ipk,
									"sks_total"=>$val->sks_total,
									"angkatan"=>$val->angkatan,
									"id_prodi_ws"=>$val->id_prodi,
									"biaya_kuliah_smt"=>$val->biaya_kuliah_smt,									
									"id_mahasiswa_ws"=>$val->id_mahasiswa,
									"id_status_mahasiswa_ws"=>$val->id_status_mahasiswa,
									"date_created"=>date("Y-m-d H:i:s")
									);
				
					$prodi = $this->msiakad_prodi->getdata(false,$val->id_prodi,$profile->kodept,false);
					if($prodi){				
						$datain["kode_prodi"]=$prodi->kode_prodi;
						$datain["id_prodi"]=$prodi->id_prodi;
					}
					
					$query = $this->db->table($this->siakad_akm)->insert($datain);
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
