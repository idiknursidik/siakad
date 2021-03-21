<?php 
namespace App\Controllers\Kepegawaian;
use App\Controllers\BaseController;

class Pendidik extends BaseController
{
	protected $siakad_dosen = 'siakad_dosen';
	
	public function index()
	{

		$data = [
			'title' => 'Data Pendidik',
			'judul' => 'Data Pendidik',
			'mn_kepegawaian'=>true,
			'mn_kepegawaian_pendidik' => true
			
		];
		return view('kepegawaian/pendidik',$data);
	}
	public function listdata(){
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
		$data = $this->msiakad_dosen->getdata();
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th>No</th><th>Nama</th><th>NIP</th><th>No Registrasi</th><th>Status</th><th>Aksi</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='6'>No data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nama_dosen}</td>";
				echo "<td>{$val->nip}</td>";
				echo "<td>{$val->nidn}</td>";
				echo "<td>{$val->nama_status_aktif}</td>";
				echo "<td>-</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function getdatadosenpddikti(){
		if ($this->request->isAJAX()){		
			$ret=array("success"=>false,"messages"=>array());		
			$profile 	= $this->msiakad_setting->getdata();
			$data_datadosen_feeder = $this->msiakad_dosen->getdatapddikti(false,$profile->kodept);
			
			if(!$data_datadosen_feeder){
				$ret["messages"] = "Tidak ada data PDDIKTI";
			}else{
				$jum=0;
				foreach($data_datadosen_feeder as $key=>$val){
					//cek data dulu
					$arraywhere = ['id_dosen_ws' => $val->id_dosen, 'kodept' => $profile->kodept];
					$builder = $this->db->table($this->siakad_dosen);
					$builder->where($arraywhere);				
					$cekdata = $builder->countAllResults();
					
					if($cekdata == 0){// jika data belum ada
						$datain = array("kodept"=>$val->kode_perguruan_tinggi,
										"id_agama"=>$val->id_agama,
										"id_dosen_ws"=>$val->id_dosen,
										"id_status_aktif_ws"=>$val->id_status_aktif,
										"jenis_kelamin"=>$val->jenis_kelamin,
										"nama_agama"=>$val->nama_agama,
										"nama_dosen"=>$val->nama_dosen,
										"nama_status_aktif"=>$val->nama_status_aktif,
										"nidn"=>$val->nidn,
										"nip"=>$val->nip,
										"sumberdata"=>'pddikti',
										"tanggal_lahir"=>$val->tanggal_lahir,
										"date_created"=>date("Y-m-d H:i:s")
										);
						$query = $this->db->table($this->siakad_dosen)->insert($datain);
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
		}else{
			echo "Tidak di izinkan..!!!!";
		}			
	}
	
}
