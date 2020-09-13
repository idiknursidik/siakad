<?php 
namespace App\Controllers\Mahasiswa;
use App\Controllers\BaseController;
use App\Models\Msiakad_nilai;
 
class Nilai extends BaseController
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
			'title' => 'Data Nilai Mahasiswa',
			'judul' => 'Nilai',
			'mn_akademik' => true,
			'mn_akademik_perkuliahan' => true,
			'mn_akademik_nilai'=>true
			
		];
		return view('mahasiswa/nilai',$data);
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
		$infoakun 	= $this->msiakad_akun->getakunmahasiswa(false,$this->session->username);
		
		$data 		= $this->msiakad_nilai->getdata(false,$infoakun->nim);
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Semester</th><th>Kode MK</th><th>Nama MK</th><th>Nilai Huruf</th><th>Nilai Indeks</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='7'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				$matakuliah = $this->msiakad_matakuliah->getdata(false,$val->id_matkul_ws);
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->semester}</td>";
				echo "<td>{$val->kode_matakuliah}</td>";
				echo "<td>{$matakuliah->nama_matakuliah}</td>";
				echo "<td>{$val->nilai_huruf}</td>";
				echo "<td>{$val->nilai_indeks}</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	
}
