<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Periode extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Data Periode Aktif Prodi PDDIKTI',
			'judul' => 'Data Periode Aktif Program Studi PDDIKTI',
			'mn_feeder_a'=>true,
			'mn_periode'=>true
		];
		return view('feeder/periode',$data);
	}
	public function show()
	{
		$session 		= \Config\Services::session();
		$feeder_akun = $session->get("feeder_akun");
		$data = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetPeriode');
		//dd($data);
		echo "<table class='table'>";
		echo "<thead><tr><th width='1'>No</th><th>Kode Prodi</th><th>Nama Prodi</th><th>Jenjang</th><th>Status</th><th>Periode</th><th>Tipe</th></tr></thead>";
		echo "<tbody>";
		$no=0;
		foreach($data->data as $key=>$val){
			$no++;
			echo "<tr>";
			echo "<td>{$no}</td>";
			echo "<td>{$val->kode_prodi}</td>";
			echo "<td>{$val->nama_program_studi}</td>";
			echo "<td>{$val->jenjang_pendidikan}</td>";
			echo "<td>{$val->status_prodi}</td>";
			echo "<td>{$val->periode_pelaporan}</td>";
			echo "<td>{$val->tipe_periode}</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}
	

}
