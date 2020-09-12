<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Datausermahasiswa extends BaseController
{
	
	protected $siakad_akun = 'siakad_akun';
	protected $siakad_akun_mahasiswa = 'siakad_akun_mahasiswa';
	protected $siakad_riwayatpendidikan = 'siakad_riwayatpendidikan';
	protected $siakad_mahasiswa = 'siakad_mahasiswa';
	protected $feeder_riwayatpendidikan = 'feeder_riwayatpendidikan';
	
	public function __construct(){
		$session = \Config\Services::session();
		if($session->get("level") != 1){
			echo "DONT ALLOW";
			exit();			
		}
	}
	public function index()
	{

		$data = [
			'title' => 'Setting Akun',
			'judul' => 'Data User Mahasiswa',
			'mn_setting'=>true,
			'mn_setting_datausermhs'=>true
			
		];
		return view('admin/datausermahasiswa',$data);
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
		$data = $this->msiakad_akun->getakunmahasiswa();
		echo "<table class='table' id='datatable'>";
		echo "<thead><tr><th width='1'>No</th><th>Username</th><th>Nama</th><th>#</th></tr></thead>";
		echo "<tbody>";
		if(!$data){
			echo "<tr><td colspan='6'>no data</td></tr>";
		}else{
			$no=0;
			foreach($data as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->username}</td>";
				echo "<td>{$val->nama_mahasiswa}</td>";
				echo "<td><a href='#modalku' class='modalButton' data-toggle='modal' data-src='".base_url()."/admin/datausermahasiswa/ubah/{$val->id}' title='Edit User'>edit</a></td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}
	public function tambah(){
		?>
		<script>
		  $(function () {
			$('#datatable_tambah').DataTable({
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


		$builder = $this->db->table("{$this->siakad_riwayatpendidikan} a");
		$builder->join("{$this->siakad_mahasiswa} b","a.id_mahasiswa = b.id_mahasiswa");
		$builder->select("a.*,b.nama_mahasiswa");
		$builder->whereNotIn('a.nim', function($builder) {
			return $builder->select('c.nim')->from("{$this->siakad_akun_mahasiswa} c");
			//return $builder->select('nim')->from("{$this->siakad_akun_mahasiswa}")->where('user_id', 3);
		});

		$query = $builder->get();
		$datamahasiswa = $query->getResult();
		
		echo "<form method='post' id='form_tambah' action='".base_url()."/admin/datausermahasiswa/create'>";
		echo csrf_field();
		echo "<table class='table' id='datatable_tambah'>";
		echo "<thead><th>No</th><th>Nim</th><th>Nama</th><th>Buat Akun</th></thead>";
		echo "<tbody>";		
		if($query->getRowArray() == 0){
			echo "<tr><td colspan='4'>tidak ada data</td></tr>";
		}else{
			$no=0;
			foreach($datamahasiswa as $key=>$val){
				$no++;
				echo "<tr>";
				echo "<td>{$no}</td>";
				echo "<td>{$val->nim}</td>";
				echo "<td>{$val->nama_mahasiswa}</td>";
				echo "<td><input type='checkbox' name='add_user[]'  value='".trim($val->nim)."'></td>";
				echo "</tr>";
			}
		}	
		echo "</tbody>";				
		echo "</table>";
		echo "<hr><div><button type='submit' class='btn btn-success' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	public function create(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata(); 
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'add_user'=>[
				'rules' => 'required',
				'errors' => [
					'required' => 'Username harus diisi.'
				]
			]
		]))
		{			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{
			$add_user = $this->request->getVar('add_user');
			$jumlah=0;
			if(count($add_user) > 0){
				foreach($add_user as $key=>$val){
					$username	= $val;
					$password	= $val;
					$hashed_password = password_hash($password,PASSWORD_DEFAULT);	
					
					//cek dulu apakah data udah ada?
					$query = $this->db->table($this->siakad_akun_mahasiswa)->where(['nim'=>$username]);
					if($query->countAllResults() == 0){					
						$datain = array("kodept"=>$profile->kodept,
										"username"=>$username,
										"password"=>$hashed_password,
										"nim"=>$username,
										"date_create"=>date("Y-m-d H:i:s")
										);
						if($this->db->table($this->siakad_akun_mahasiswa)->insert($datain)){
							$jumlah++;
						}
					}
				}
			}			
			if($query){	
				$ret['messages'] = "{$jumlah} Data berhasil dimasukan";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal dimasukan";
			}			
		}	
		echo json_encode($ret);
	}
	public function ubah($id=false){
		if(!$id){
			echo "eRR"; exit();
		}
		?>
		<script>
		$('.select2').select2({
			dropdownParent: $("#modalku")
			
		})
		</script>
		<?php
		$data 		= $this->msiakad_akun->getakun($id);
		$profile 	= $this->msiakad_setting->getdata(); 			
		$prodi 		= $this->msiakad_prodi->getdata(false,false,$profile->kodept);
		$leveluser 	= $this->msiakad_akun->leveluser();
		echo "<form method='post' id='form_tambah' action='".base_url()."/admin/datausermahasiswa/update'>";
		echo "<input type='hidden' name='id' value='{$data->id}'>";
		echo csrf_field(); 
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='username'>Username</label>";
					echo "<input type='text' class='form-control' readonly name='username' id='username' value='{$data->username}'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='password'>Password</label>";
					echo "<input type='text' class='form-control' name='password' id='password'>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "<div class='row'>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='nama'>Nama</label>";
					echo "<input type='text' class='form-control' name='nama' id='nama' value='{$data->nama}'>";
				echo "</div>";
			echo "</div>";
			echo "<div class='col-sm-6'>";
				echo "<div class='form-group'>";
					echo "<label for='level'>Level</label>";
					echo "<select type='text' name='level' id='level' class='form-control select2 select2-hidden-accessible' style='width: 100%;' data-select2-id='1' tabindex='-1' aria-hidden='true'>";
					if($leveluser){
						foreach($leveluser as $key=>$val){
							echo "<option value='{$key}'";
							if($data->userlevel == $key) echo " selected='selected'";
							echo ">{$val}</option>";
						}
					}
					echo "</select>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "<div class='form-group'>";
			echo "<label for='email'>Email</label>";
			echo "<input type='email' class='form-control' name='email' id='email' value='{$data->email}'>";
		echo "</div>";		
		echo "<div class='form-group clearfix'>";
			echo "<label for='akses'>Hak akses </label><hr>";
			$akses = explode(",",$data->akses);
			$checked="";
			foreach($prodi as $key=>$val){
				
				if(in_array($val->id_prodi,$akses)){
					$checked = "checked";
				}else{
					$checked = "";
				}					
				echo "<div class='icheck-primary d-inline'>";                      
				echo " <input type='checkbox' name='akses[]' value='{$val->id_prodi}' id='akses_{$val->id_prodi}' {$checked}>";
				echo " <label for='akses_{$val->id_prodi}'>{$val->nama_prodi} {$val->nama_jenjang_didik}</label>";
				echo "</div>";
			}
			
		echo "</div>";	
		
		echo "<div><button type='submit' class='btn btn-success' style='float:right;'><i class='fas fa-save'></i> Simpan</button></div>";
		echo "</form>";
	}
	public function update(){
		$ret=array("success"=>false,"messages"=>array());
		$profile 	= $this->msiakad_setting->getdata(); 
		
		$validation =  \Config\Services::validation();   
		if (!$this->validate([
			'username'=>[
				'rules' => 'required',
				'errors' => [
					'required' => 'Username harus diisi.'
				]
			],
			'nama'=>[
				'rules'=>'required',
				'errors'=>[
					'required'=>'Nama harus diisi'
				]
			],
			'level'=>[
				'rules'=>'required',
				'errors'=>[
					'required'=>'Level harus dipilih'
				]
			],
			'email'=>[
				'rules'=>'required|valid_email',
				'errors'=>[
					'required'=>'Email harus diisi',
					'valid_email'=>'Email harus benar'
				]
			],
			'akses'=>[
				'rules'=>'required',
				'errors'=>[
					'required'=>'Hak akses harus dipilih'
				]
			]
		]))
		{			
			foreach($validation->getErrors() as $key=>$value){
				$ret['messages'][$key]="<div class='invalid-feedback'>{$value}</div>";
			}
		}else{
			$username	= $this->request->getVar("username");
			$password	= $this->request->getVar("password");
			$hashed_password = password_hash($password,PASSWORD_DEFAULT);			
			$level		= $this->request->getVar("level");
			$nama		= $this->request->getVar("nama");
			$email		= $this->request->getVar("email");
			$akses		= implode(",",$this->request->getVar("akses"));
			$id			= $this->request->getVar("id");
			$datain = array("kodept"=>$profile->kodept,
							"username"=>$username,							
							"nama"=>$nama,
							"email"=>$email,
							"userlevel"=>$level,
							"akses"=>$akses,
							"date_create"=>date("Y-m-d H:i:s")
							);
			if($password){
				$datain["password"]=$hashed_password;
			}				
			$query = $this->db->table($this->siakad_akun)->update($datain,array("username"=>$username,"id"=>$id));		
			if($query){	
				$ret['messages'] = "Data berhasil diupdate";
				$ret['success'] = true;	
			}else{
				$ret['messages'] = "Data gagal diupdate";
			}			
		}	
		echo json_encode($ret);
	}
}
