<?php 
namespace App\Controllers\Akademik;
use App\Controllers\BaseController;
use App\Models\Msiakad_kurikulum;
 
class Dosenwali extends BaseController
{
	protected $siakad_dosenwali = 'siakad_dosenwali';
	
	public function index()
	{
		
		$data = [
			'title' => 'Data dosen wali',
			'judul' => 'Kurikulum',
			'mn_akademik' => true,
			'mn_akademik_dosenwali'=>true
			
		];
		return view('akademik/dosenwali',$data);
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
		$datadosen	= $this->msiakad_dosen->getdata();
		
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th width='1'>No</th><th>NIDN</th><th>NIP</th><th>Nama dosen</th><th>Jumlah peserta</th></tr></thead>";
		echo "<tbody>";
		if(!$datadosen){
			echo "<tr><td colspan='5'>no data</td></tr>";
		}else{
			$no=0;
			foreach($datadosen as $key=>$val){
				$no++;	
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td><a href='".base_url()."/akademik/dosenwali/kelolapeserta/{$val->id_dosen}'>{$val->nidn}</a></td>";
				echo "<td>{$val->nip}</td>";
				echo "<td>{$val->nama_dosen}</td>";
				echo "<td>{peserta}</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function kelolapeserta(){
		$data = [
			'title' => 'Data dosen wali',
			'judul' => 'Kurikulum',
			'mn_akademik' => true,
			'mn_akademik_dosenwali'=>true
			
		];
		return view('akademik/dosenwali',$data);
	}
}
