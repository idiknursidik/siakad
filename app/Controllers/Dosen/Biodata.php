<?php 
namespace App\Controllers\Dosen;
use App\Controllers\BaseController;

class Biodata extends BaseController
{
	protected $siakad_dosen = 'siakad_dosen';
	
	public function index()
	{

		$data = [
			'title' => 'Data dosen',
			'judul' => 'Biodata dosen',
			'mn_biodata' => true
			
		];
		return view('dosen/biodata',$data);
	}
	public function viewdata()
	{
		
		$profile			= $this->msiakad_setting->getdata();
		$agama				= $this->mreferensi->GetAgama();
		$jenis_kelamin		= $this->mfungsi->jenis_kelamin();
		$kewarganegaraan	= $this->mreferensi->GetNegara();
		$pend_terakhir		= $this->mreferensi->GetJenjangPendidikan();
		
		$infoakun 			= $this->msiakad_akun->getakundosen(false,$this->session->username);		
		$data 				= $this->msiakad_dosen->getdata($infoakun->id_dosen);
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		exit();
		
		echo "<form id='form_ubah' action='".base_url()."/akademik/dosendaftar/ubah' method='post'>";
		echo "<input type='hidden' name='id_dosen' value='{$data->id_dosen}'>";
		echo "<input type='hidden' name='kodept' value='{$profile->kodept}'>";
		echo csrf_field();
		
				
		echo "<hr><button class='btn btn-primary' name='kirim' type='submit'>Simpan data</button><br><br>";
		echo "</form>";
	}
	
}
