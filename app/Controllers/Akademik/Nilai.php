<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
use App\Models\Msiakad_nilai;
use App\Libraries\Datatables;


class Nilai extends BaseController
{
	protected $siakad_nilai = 'siakad_nilai';
	protected $feeder_nilai = 'feeder_nilai';
	protected $siakad_kelas = 'siakad_kelas';
	protected $siakad_matakuliah = 'siakad_matakuliah';

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
		return view('akademik/nilai_kelas',$data);
	}
	public function listdataserverside(){
		
		$datatables = new Datatables;	
		$datatables->table("{$this->siakad_kelas} a");		
		$datatables->select("a.id_semester,a.id_kelas,a.nama_kelas_kuliah,b.kode_matakuliah,b.nama_matakuliah,b.sks_matakuliah,(SELECT COUNT(c.nim) FROM `siakad_nilai` c WHERE c.id_kelas = a.id_kelas GROUP BY c.id_kelas) as jumpeserta,(SELECT COUNT(d.nim) FROM `siakad_nilai` d WHERE (d.id_kelas = a.id_kelas AND BIT_LENGTH(d.nilai_huruf) > 0) GROUP BY d.id_kelas) as jumpesertanilai ");		
		$datatables->join("{$this->siakad_matakuliah} b", 'a.id_matakuliah = b.id_matakuliah','LEFT JOIN');
		
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
		          { "data": "id_semester" },
		          { "data": "id_semester" },
		          { "data": "kode_matakuliah", "name": "kode_matakuliah",
					fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
						$(nTd).html("<a href='<?php echo base_url();?>/akademik/nilai/peserta/"+oData.id_kelas+"'>"+oData.kode_matakuliah+"</a>");
					}},
		          { "data": "nama_matakuliah" },
		          { "data": "nama_kelas_kuliah" },
				  { "data": "sks_matakuliah" },
				  { "data": "jumpeserta" },
				  { "data": "jumpesertanilai" },
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
      <thead><tr><th>No</th><th>Semester</th><th>Kode MK</th><th>Nama Matakuliah</th><th>Nama Kelas</th><th>Bobot MK(sks)</th><th>Peserta Kelas</th><th>Peserta Sudah dinilai</th></tr></thead>
      <tbody>
      </tbody>
    </table>
	<?php
	}
	public function peserta($id_kelas=false){
		$profile 	= $this->msiakad_setting->getdata(); 
		if(!$id_kelas){
			echo "error ID kelas"; exit();
		}
		$data = [
			'title' => 'Data Akademik',
			'judul' => 'Nilai Perkuliahan',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_kelas'=>true,
			'id_kelas'=>$id_kelas
			
		];
		return view('akademik/nilai_peserta',$data);
	}
	public function listpeserta($id_kelas=false)
	{
		$profile 	= $this->msiakad_setting->getdata(); 
		if(!$id_kelas){
			echo "error ID kelas"; exit();
		}
		$datakelas = $this->msiakad_kelas->getdata($id_kelas);
		echo "Prodi : {$datakelas->nama_prodi} - {$datakelas->nama_jenjang_didik}<br>"; 
		echo "Semester : {$datakelas->id_semester}<br>"; 
		echo "Matakuliah : {$datakelas->kode_mata_kuliah} - {$datakelas->nama_matakuliah} [$datakelas->nama_kurikulum]<br>";
		echo "Kelas : {$datakelas->nama_kelas_kuliah}";
		echo "<hr>";
		echo "<h4 class='text-primary'>Dosen Penganjar</h4>";
		$datapengajar = $this->msiakad_dosenmengajar->getdata(false,false,$profile->kodept,$id_kelas);
		echo "<table class='table'>";
		echo "<thead><tr><th>No</th><th>NIDN</th><th>Nama</th><th>Bobot (sks)</th><th>Rencana Pertemuan</th><th>Realisasi Pertemuan</th><th>Jenis Evaluasi</th></tr></thead>";
		echo "<tbody>";
		if(!$datapengajar){
			echo "<tr><td colspan='7'>Belum ada dosen pengajar</td></tr>";
		}else{
			$no=0;
			foreach($datapengajar as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nidn}</td>";
				echo "<td>{$val->nama_dosen}</td>";
				echo "<td>{$val->sks_substansi_total}</td>";
				echo "<td>{$val->rencana_tatap_muka}</td>";
				echo "<td>{$val->realisasi_tatap_muka}</td>";
				echo "<td>{$val->id_jenis_evaluasi}</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
		echo "<hr>";
		$data = $this->msiakad_nilai->getdata(false,false,false,false,$id_kelas,$profile->kodept);
		//print_r($data);
		echo "<h4 class='text-primary'>Peserta kelas</h4>";
		echo "<form method='post' action=''>";
		echo "<div class='float-right d-inline'>";
		echo "<button type='submit' class='btn btn-primary'>Simpan</button>";
		echo " <a class='btn btn-info' href='".base_url()."/akademik/nilai'>Daftar</a>";
		echo "<br><span>Nilai Angka 0 - 100 [ Bobot Nilai ]</span>";
		echo "</div>";
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Nim</th><th>Nama</th><th>Jurusan</th><th>Angkatan</th><th width='8%'>Angka</th><th width='8%'>Huruf</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='7'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				//$prodi = $this->msiakad_prodi->getdata($val->id_prodi);				
				//$matakuliah = $this->msiakad_matakuliah->getdata(false,$val->id_matkul_ws);
				
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nim}</td>";
				echo "<td>{$val->nama_mahasiswa}</td>";
				echo "<td>{$val->nama_prodi} {$val->nama_jenjang_didik}</td>";
				echo "<td>".substr($val->id_periode_masuk,0,4)."</td>";
				echo "<td><input type='text' class='form-control' name='angka' value='{$val->nilai_indeks}'></td>";
				echo "<td><input type='text' class='form-control' name='huruf' value='{$val->nilai_huruf}'></td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
		echo "</form>";
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
			$jumin=0;$jumup=0;
			foreach($data_nilai_feeder as $key=>$val){
				
				//cek data dulu
				$arraywhere = ['nim' => $val->nim, 'id_matkul_ws' => $val->id_matkul, 'id_kelas_ws' => $val->id_kelas,'id_periode_ws'=>$val->id_periode];
				$builder = $this->db->table($this->siakad_nilai);
				$builder->where($arraywhere);				
				$cekdata = $builder->countAllResults();
				
				$datain = array("nim"=>$val->nim,
									"kodept"=>$val->kode_perguruan_tinggi,									
									"semester"=>$val->id_periode,
									"kelas"=>$val->nama_kelas_kuliah,
									"nilai_huruf"=>$val->nilai_huruf,
									"nilai_indeks"=>$val->nilai_indeks,
									"id_kelas_ws"=>$val->id_kelas,
									"id_matkul_ws"=>$val->id_matkul,
									"id_periode_ws"=>$val->id_periode,									
									"id_registrasi_mahasiswa"=>$val->id_registrasi_mahasiswa,
									"date_created"=>date("Y-m-d H:i:s")
									);
				$matakuliah = $this->msiakad_matakuliah->getdata(false,$val->id_matkul,false,$profile->kodept);
				if($matakuliah){					
					$datain["kode_matakuliah"]=$matakuliah->kode_matakuliah;
					$datain["id_matkul"]=$matakuliah->id_matakuliah;
				}
				$kelas_kuliah = $this->msiakad_kelas->getdata(false,$val->id_kelas);
				if($kelas_kuliah){
					$datain["id_kelas"]=$kelas_kuliah->id_kelas;
				}						
				$mahasiswa = $this->msiakad_riwayatpendidikan->getdata(false,false,$val->kode_perguruan_tinggi,false,$val->nim);
				
				if($mahasiswa){
					$datain["id_riwayatpendidikan"]=$mahasiswa->id_riwayatpendidikan;
					
					$prodi = $this->msiakad_prodi->getdata(false,$mahasiswa->id_prodi_ws,$profile->kodept,false);
					if($prodi){				
						$datain["kode_prodi"]=$prodi->kode_prodi;
						$datain["id_prodi"]=$prodi->id_prodi;
					}
				}
				
				if($cekdata == 0){// jika data belum ada				
					$query = $this->db->table($this->siakad_nilai)->insert($datain);
					if($query){
						$jumin++;
					}
				}else{
					$query = $this->db->table($this->siakad_nilai)->where($arraywhere)->update($datain);
					if($query){
						$jumup++;
					}
				}
			}
			if(($jumin+$jumup) > 0){
				$ret["messages"] = "{$jumin} data berhasil dimasukan, {$jumup} data berhasil diupdate";
				$ret["success"] = true;
			}else{
				$ret["messages"] = "tidak ada data yang dimasukan atau diupdate.";
			}
		}		
		echo json_encode($ret);		
	}
	
}
