<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
use App\Models\Msiakad_nilai;
use App\Libraries\Datatables;


class Nilai extends BaseController
{
	protected $siakad_nilai = 'siakad_nilai';
	protected $feeder_nilai = 'feeder_nilai';
	protected $siakad_riwayatpendidikan = 'siakad_riwayatpendidikan';
	protected $siakad_mahasiswa = 'siakad_mahasiswa';
	public function __construct()
    {
        $this->msiakad_nilai = new Msiakad_nilai();
    }
	public function index()
	{
		
		$data = [
			'title' => 'Data Akademik',
			'judul' => 'nilai',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_nilai'=>true
			
		];
		return view('akademik/nilai',$data);
	}
	public function listdataserverside(){
		$datatables = new Datatables;
		
		
		$datatables->table("{$this->siakad_nilai} a");
		$datatables->select('a.id_nilai,a.semester,a.nilai_huruf,a.nilai_indeks,a.nim as nim_mahasiswa,a.kode_matakuliah,b.id_periode_masuk,c.nama_mahasiswa');
		$datatables->join("{$this->siakad_riwayatpendidikan} b", 'a.nim = b.nim','LEFT JOIN');
		$datatables->join("{$this->siakad_mahasiswa} c",'b.id_mahasiswa = c.id_mahasiswa','LEFT JOIN');

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
				"url": "<?php echo base_url('/akademik/nilai/listdataserverside')?>",
				"type": "POST"
			},
			"dataType": "json",
		    "type": "POST",
		    "columns": [
		          { "data": "id_nilai" },
		          { "data": "semester" },
		          { "data": "nim_mahasiswa" },
		          { "data": "nama_mahasiswa" },
				  { "data": "kode_matakuliah" },
				  { "data": "nilai_huruf" },
				  { "data": "nilai_indeks" },
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
      <thead><tr><th>No</th><th>Semester</th><th>NIM</th><th>Nama Mahasiswa</th><th>Nama Matakuliah</th><th>Nilai Indeks</th><th>Nilai Huruf</th></tr></thead>
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
		$data 		= $this->msiakad_nilai->getdata();
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Semester</th><th>NIM</th><th>Kode MK</th><th>Nama MK</th><th>Nilai Huruf</th><th>Nilai Indeks</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='7'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				$prodi = $this->msiakad_prodi->getdata(false,$val->id_prodi);
				if($prodi){				
					$jenjang = $this->mreferensi->GetJenjangPendidikan($prodi->id_jenjang);
					if($jenjang){
						$namaprodi = $prodi->nama_prodi."".$jenjang->nama_jenjang_didik;
					}else{
						$namaprodi = $prodi->nama_prodi;
					}
				}else{
					$namaprodi = "-";
				}
				$matakuliah = $this->msiakad_matakuliah->getdata(false,$val->id_matkul_ws);
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->semester}</td>";
				echo "<td>{$val->nim}</td>";
				echo "<td>{$val->kode_matakuliah}</td>";
				echo "<td>{$matakuliah->nama_matakuliah}</td>";
				echo "<td>{$val->nilai_huruf}</td>";
				echo "<td>{$val->nilai_indeks}</td>";
				echo "<td>";
					echo "<a href='#modalku' data-toggle='modal' class='modalButton' data-src='".base_url()."/akademik/nilai/edit/{$val->id_nilai}' title='Edit data nilai'>edit</a>";
					echo " - <a>hapus</a>";
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function tambah(){
		echo "Tambah dari excel";
		$profile 	= $this->msiakad_setting->getdata(); 		
		
		echo "<form method='post' id='form_tambah' action='".base_url()."/akademik/nilai/create'>";
		echo csrf_field(); 
		
		
					
		echo "<div><button type='submit' class='btn btn-success' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	
	public function create(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata(); 
		
		echo json_encode($ret);
	}
	
	public function edit($id_nilai=false){
		$profile 	= $this->msiakad_setting->getdata();
		if(!$id_nilai){
			echo "Error ID nilai"; exit();
		}
		$data	= $this->msiakad_nilai->getdata($id_nilai,false,false,false,false,$profile->kodept);
				
		echo "<form method='post' id='form_ubah' action='".base_url()."/akademik/nilai/update'>";
		echo "<input type='hidden' name='id_nilai' value='{$data->id_nilai}'";
		echo csrf_field(); 
		
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='nilai_huruf'>Nilai Huruf</label>";
					echo "<input type='text' class='form-control' name='nilai_huruf' id='nilai_huruf' value='{$data->nilai_huruf}'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='nilai_indeks'>Nilai Indeks </label>";
					echo "<input type='text' class='form-control' name='nilai_indeks' id='nilai_indeks' value='{$data->nilai_indeks}'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
			
		echo "<div><button type='submit' class='btn btn-success' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	public function update(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata(); 
		//cek dulu apakah sudah ada
		$id_nilai = $this->request->getVar("id_nilai");
				
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'nilai_huruf' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nilai huruf harus diisi.'
				]
			],
			'nilai_indeks' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nilai indeks harus diisi.'
				]
			]
		]))
		{			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{
			
			$datain=array();
			foreach($this->request->getVar() as $key=>$val){
				if(!in_array($key,array("csrf_test_name"))){
					$datain[$key] =  $this->request->getVar($key);
				}
			}				
			$query = $this->db->table($this->siakad_nilai)->update($datain,array("id_nilai"=>$id_nilai));		
			if($query){	
				$ret['messages'] = "Data berhasil diupdate";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal diupdate";
			}			
		}	
		echo json_encode($ret);
	}
	
	public function getnilaipddikti(){		
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$data_nilai_feeder = $this->msiakad_nilai->getdatapddikti(false,false,false,false,$profile->kodept);
		
		if(!$data_nilai_feeder){
			$ret["messages"] = "Tidak ada data PDDIKTI";
		}else{
			$jum=0;
			foreach($data_nilai_feeder as $key=>$val){
				//cek data dulu
				$matakuliah = $this->msiakad_matakuliah->getdata(false,$val->id_matkul,false,$profile->kodept);
				//print_r($matakuliah->kode_matakuliah);
				//exit();
				//cek data dulu
				$arraywhere = ['nim' => $val->nim, 'id_matkul_ws' => $val->id_matkul, 'id_kelas_ws' => $val->id_kelas,'id_periode_ws'=>$val->id_periode];
				$builder = $this->db->table($this->siakad_nilai);
				$builder->where($arraywhere);				
				$cekdata = $builder->countAllResults();
				
				if($cekdata == 0){// jika data belum ada
					$datain = array("nim"=>$val->nim,
									"kodept"=>$val->kode_perguruan_tinggi,									
									"semester"=>$val->id_periode,
									"kelas"=>$val->nama_kelas_kuliah,
									"id_prodi"=>$val->id_prodi,
									"nilai_huruf"=>$val->nilai_huruf,
									"nilai_indeks"=>$val->nilai_indeks,
									"id_kelas_ws"=>$val->id_kelas,
									"id_matkul_ws"=>$val->id_matkul,
									"id_periode_ws"=>$val->id_periode,									
									"id_registrasi_mahasiswa"=>$val->id_registrasi_mahasiswa,
									"date_created"=>date("Y-m-d H:i:s")
									);
					$datain["kode_matakuliah"]=$matakuliah->kode_matakuliah;
					$kelas_kuliah = $this->msiakad_kelas->getdata(false,$val->id_kelas);
					if($kelas_kuliah){
						$datain["id_kelas"]=$kelas_kuliah->id_kelas;
					}						
					$mahasiswa = $this->msiakad_riwayatpendidikan->getdata(false,false,$val->kode_perguruan_tinggi,false,$val->nim);
					
					if($mahasiswa){
						$datain["id_riwayatpendidikan"]=$mahasiswa->id_riwayatpendidikan;
					}						
					$prodi = $this->msiakad_prodi->getdata(false,$val->id_prodi,$profile->kodept,false);
					if($prodi){				
						$datain["kode_prodi"]=$prodi->kode_prodi;
						$datain["id_prodi"]=$prodi->id_prodi;
					}
					
					$query = $this->db->table($this->siakad_nilai)->insert($datain);
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
