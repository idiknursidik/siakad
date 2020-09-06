<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;

class Riwayatpendidikan extends BaseController
{
	protected $siakad_riwayatpendidikan = 'siakad_riwayatpendidikan';
	protected $feeder_riwayatpendidikan = 'feeder_riwayatpendidikan';
	
	public function index()
	{

		$data = [
			'title' => 'Data Akademik',
			'judul' => 'Riwayat Pendidikan',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_riwayatpendidikan'=>true
			
		];
		return view('akademik/riwayatpendidikan',$data);
	}
	public function listdata()
	{
		?>
		<script>
		  $(function () {
			   // Setup - add a text input to each footer cell
			$('#datatable thead tr').clone(true).appendTo( '#datatable thead' );
			$('#datatable thead tr:eq(1) th').each( function (i) {
				
				var title = $(this).text();
				if(i!=0 && i!=8){
					$(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
				}else{
					$(this).html("");
				}
				$( 'input', this ).on( 'keyup change', function () {
					if ( table.column(i).search() !== this.value ) {
						table
							.column(i)
							.search( this.value )
							.draw();
					}
				} );
			});
			
			var table = $('#datatable').DataTable({
			  "paging": true,
			  "lengthChange": true,
			  "searching": true,
			  "ordering": true,
			  "info": true,
			  "autoWidth": false,
			  "responsive": true,
			   "orderCellsTop": true
			});
		  });
		</script>
		<?php
		
		$profile 	= $this->msiakad_setting->getdata(); 
		$data 		= $this->msiakad_riwayatpendidikan->getdata(false,false,$profile->kodept);
		
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>NIM</th><th>Nama</th><th>Jenis Pendaftaran</th><th>Periode</th><th>Tanggal Masuk</th><th>Prodi</th><th>Status</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='2'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				$mahasiswa = $this->msiakad_mahasiswa->getdata(false,$val->id_mahasiswa,false,false,$profile->kodept);
				$jenis_pendaftaran = $this->mfungsi->jenis_pendaftaran($val->id_jenis_daftar);
				$dataprodi	= $this->msiakad_prodi->getdata($val->id_prodi,false,false,false);
				$referensi 	= $this->mreferensi->GetJenisKeluar($val->id_jenis_keluar);
				if(strlen($val->id_jenis_keluar) > 0){
					$jeniskeluar = ($referensi)?$referensi->jenis_keluar:$val->id_jenis_keluar;
				}else{
					$jeniskeluar = "Aktif";
				}
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nim}</td>";
				echo "<td>{$mahasiswa->nama_mahasiswa}</td>";
				echo "<td>{$jenis_pendaftaran}</td>";
				echo "<td>{$val->id_periode_masuk}</td>";
				echo "<td>{$val->tanggal_daftar}</td>";
				echo "<td>{$dataprodi->nama_prodi} - {$dataprodi->nama_jenjang_didik}</td>";
				echo "<td>{$jeniskeluar}</td>";
				echo "<td><a href='".base_url()."/akademik/mahasiswa/detail/{$val->id_mahasiswa}'>detail</a></td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function detail($id_riwayatpendidikan){
		$data = [
			'title' => 'Data Akademik',
			'judul' => 'riwayatpendidikan',
			'mn_akademik' => true,
			'mn_akademik_riwayatpendidikan'=>true,
			'id_riwayatpendidikan'=>$id_riwayatpendidikan
			
		];
		return view('akademik/riwayatpendidikan_detail',$data);
	}
	public function getriwayatpendidikanpddikti(){		
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata();
		$data_riwayatpendidikan_feeder = $this->msiakad_riwayatpendidikan->getdatapddikti(false,$profile->kodept);
		if(!$data_riwayatpendidikan_feeder){
			$ret["messages"] = "Tidak ada data PDDIKTI";
		}else{
			$jum=0;
			foreach($data_riwayatpendidikan_feeder as $key=>$val){
				//cek data dulu
				$cekdata = $this->msiakad_riwayatpendidikan->getdata(false,$val->id_registrasi_mahasiswa,$profile->kodept);
				if(!$cekdata){
					
					$datain = array("kodept"=>$val->kode_perguruan_tinggi,
									"biaya_masuk"=>$val->biaya_masuk,
									"id_bidang_minat"=>$val->id_bidang_minat,
									"id_jalur_daftar"=>$val->id_jalur_daftar,
									"id_jenis_daftar"=>$val->id_jenis_daftar,
									"id_jenis_keluar"=>$val->id_jenis_keluar,
									"id_mahasiswa_ws"=>$val->id_mahasiswa,
									"id_pembiayaan"=>$val->id_pembiayaan,
									"id_perguruan_tinggi"=>$val->id_perguruan_tinggi,
									"id_perguruan_tinggi_asal"=>$val->id_perguruan_tinggi_asal,
									"id_periode_masuk"=>$val->id_periode_masuk,
									"id_prodi_ws"=>$val->id_prodi,
									"id_prodi_asal"=>$val->id_prodi_asal,
									"id_registrasi_mahasiswa"=>$val->id_registrasi_mahasiswa,
									"keterangan_keluar"=>$val->keterangan_keluar,
									"nama_jenis_daftar"=>$val->nama_jenis_daftar,
									"nama_pembiayaan_awal"=>$val->nama_pembiayaan_awal,
									"nama_perguruan_tinggi"=>$val->nama_perguruan_tinggi,
									"nama_perguruan_tinggi_asal"=>$val->nama_perguruan_tinggi_asal,
									"nama_periode_masuk"=>$val->nama_periode_masuk,
									"nama_program_studi"=>$val->nama_program_studi,
									"nama_program_studi_asal"=>$val->nama_program_studi_asal,
									"nim"=>$val->nim,
									"nm_bidang_minat"=>$val->nm_bidang_minat,
									"sks_diakui"=>$val->sks_diakui,
									"tanggal_daftar"=>$val->tanggal_daftar);
					$prodi = $this->msiakad_prodi->getdata(false,$val->id_prodi,$profile->kodept,false);				
					$datain["kode_prodi"] = $prodi->kode_prodi;
					$datain["id_prodi"] = $prodi->id_prodi;
					$mahasiswa = $this->msiakad_mahasiswa->getdata(false,false,$val->id_mahasiswa,false,$profile->kodept);
					$datain["id_mahasiswa"] = $mahasiswa->id_mahasiswa;
					$query = $this->db->table($this->siakad_riwayatpendidikan)->insert($datain);
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
