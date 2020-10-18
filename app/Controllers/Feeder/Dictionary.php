<?php 
namespace App\Controllers\Feeder;
use App\Controllers\BaseController;

class Dictionary extends BaseController
{
	
	public function index()
	{
		
		$data = [
			'title' => 'Dictionary PDDIKTI',
			'judul' => 'Dictionary PDDIKTI',
			'mn_dictionary'=>true
		];
		return view('feeder/dictionary',$data);
	}
	public function show()
	{
		$cekkoneksi = $this->mfeeder_ws->cekkoneksifeeder();
		if($cekkoneksi){
			echo $cekkoneksi;	
			exit();			
		}
		$session 		= \Config\Services::session();
		$feeder_akun = $session->get("feeder_akun");
		
		
		
		$dataptws = $this->mfeeder_ws->getrecordset($feeder_akun->token,'GetProfilPT','',false,'1','0');
		if($dataptws->error_code != 0){
			echo $dataptws->error_desc;
			exit();
		}
		$listcommanddic = $this->mdictionary->dictionaryFunction();
		
		if(!$listcommanddic){
			echo "Tidak ada Data";
		}else{
			echo "<table class='table'>";
			echo "<thead><tr><th width='1'>No</th><th>Perintah</th></tr></thead>";
			echo "<tbody>";
			
			foreach($listcommanddic as $value){				
				$perintah = $this->mdictionary->dictionaryFunction($value);
				echo "<tr>";
				echo "<td colspan='2'>{$value}</td>";
				echo "</tr>";
				$no=0;
				foreach($perintah as $key=>$val){
					$no++;
					echo "<tr>";
					echo "<td>{$no}</td>";				
					echo "<td><a href='#' name='showdictionary_{$val}' fungsi='{$val}' data-src='".base_url()."/feeder/dictionary/Dictionarydata/{$val}'>{$val}</a>";
					echo "<div id='showdictionary_{$val}' style='display:none;'>Loading content....</div>";
					echo "</td>";
					echo "</tr>";
				}
				
			}
			echo "</tbody>";
			echo "</table>";			
		}
	}
	public function Dictionarydata($val){
		$session 		= \Config\Services::session();
		$feeder_akun = $session->get("feeder_akun");
		$data = $this->mfeeder_ws->getdictionary($feeder_akun->token,'GetDictionary',$val);
		if($data->error_code != 0){
			echo "<hr>".$data->error_desc;
		}else{
			dd($data);
		}
	}
	
}
