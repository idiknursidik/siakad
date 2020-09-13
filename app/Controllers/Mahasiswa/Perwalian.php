<?php 
namespace App\Controllers\Mahasiswa;
use App\Controllers\BaseController;
use App\Models\Msiakad_nilai;
 
class Perwalian extends BaseController
{
	protected $siakad_nilai = 'siakad_nilai';
	protected $feeder_nilai = 'feeder_nilai';
	
	public function __construct()
    {
        $this->msiakad_nilai = new Msiakad_nilai();
    }
	public function index()
	{
		
		$data = [
			'title' => 'Data KRS Mahasiswa',
			'judul' => 'Perwalian atau KRS',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_perwalian'=>true
			
		];
		return view('mahasiswa/perwalian',$data);
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
		$profile 		= $this->msiakad_setting->getdata();
		$setperkuliahan	= $this->msiakad_setting->setperkuliahan("Y");
		$infoakun 		= $this->msiakad_akun->getakunmahasiswa(false,$this->session->username);
		if(!$setperkuliahan){
			echo "<div class='alert alert-danger'>Maaf Belum ada jadwal perwalian</div>";
		}else{
			echo "<div class='alert alert-info'>Info dosen wali</div>";
			$data = $this->msiakad_kelas->getdata(false,false,$setperkuliahan->semester_aktif);
			
			echo "<table class='table' id='datatable'>";
			echo "<thead><tr><th width='1'>No</th><th>Tahun Akademik</th><th>Kode MK</th><th>Nama MK</th><th>Kelas</th><th>Dosen Pengajar</th><th>semester</th><th>Aksi</th></tr></thead>";
			echo "<tbody>";
			if(!$data){
				echo "<tr><td colspan='7'>Belum ada matakuliah yang disajikan</td></tr>";
			}else{
				$no=0;
				foreach($data as $key=>$val){
					$no++;
					$dosenmengajar = $this->msiakad_dosenmengajar->getdata(false,false,false,$val->id_kelas);
					if($dosenmengajar){
						$retdosenmengajar=array();
						foreach($dosenmengajar as $dosenkey=>$dosenval){
							$retdosenmengajar[] = $dosenval->nama_dosen;
						}
						$retdosenmengajar = implode(", ", $retdosenmengajar);
					}else{
						$retdosenmengajar = " - ";
					}
					echo "<tr>";
					echo "<td>{$no}</td>";
					echo "<td>{$val->id_semester}</td>";
					echo "<td>{$val->kode_mata_kuliah}</td>";
					echo "<td>{$val->nama_matakuliah}</td>";
					echo "<td>{$val->nama_kelas_kuliah}</td>";
					echo "<td>{$retdosenmengajar}</td>";
					echo "<td>{$val->semester}</td>";
					echo "<td><input type='checkbox'></td>";
					echo "</tr>";
				}
			}
			echo "</tbody>";
			echo "</table>";
		}
	}
	
}
