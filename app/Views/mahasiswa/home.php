<?php
echo $this->extend('layout/template_mahasiswa');
echo $this->section('content');

use \App\Models\Msiakad_setting;
use \App\Models\Msiakad_akun;
$msiakad_setting = new Msiakad_setting();
$msiakad_akun = new Msiakad_akun();
$profil_setting = $msiakad_setting->getprofile();
$profileinfo = $msiakad_setting->getdata();
if($profil_setting){
	$kodept	= $profil_setting->kode_perguruan_tinggi;
	$namapt = $profil_setting->nama_perguruan_tinggi;
	$jalan	= $profil_setting->jalan;
	$logopt	= ($profileinfo->logopt)?$profileinfo->logopt:'logo.png';
}else{
	$kodept = "NO DATA";
	$logopt = "logo.png";
	$namapt = "";
}
$infoakun = $msiakad_akun->getakunmahasiswa(false,session()->username);
$userimage = ($infoakun->user_image)?$infoakun->user_image:"noimage.png";

?>
<div class="card">
  <div class="card-header">
	<h5 class="card-title m-0">Hi.. <?php echo $infoakun->nama_mahasiswa;?></h5>
  </div>
  <div class="card-body">
	<h6 class="card-title">Selamat Datang di Sistem Informasi Akademik</h6>
	<p class="card-text"><?php echo $namapt;?></p>
	<a href="<?php echo base_url();?>/mahasiswa/profile" class="btn btn-primary">Kelola Akun</a>
	<a href="<?php echo base_url();?>/login/logout" class="btn btn-danger">Keluar</a>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
	<div class="card">
	  <div class="card-header">
		<h5 class="card-title m-0">Data User</h5>
	  </div>
	  <div class="card-body p-1">
		<table class="table table-sm">
		<tbody>
			<tr><td width="30%">Nama</td><td>: <?php echo $infoakun->nama_mahasiswa;?></td></tr>
			<tr><td>NIM</td><td>: <?php echo $infoakun->nim;?></td></tr>
			<tr><td>Program Studi</td><td>: <?php echo $infoakun->nama_prodi;?></td></tr>
			<tr><td>Jenjang</td><td>: <?php echo $infoakun->nama_jenjang_didik;?></td></tr>
			<tr><td>Periode Masuk</td><td>: <?php echo $infoakun->id_periode_masuk;?></td></tr>
		</tbody>
		</table>
	  </div>
	</div> 
  </div>	
  <!-- /.col-md-6 -->
  <div class="col-lg-6">
	<div class="card">
	  <div class="card-body">
		<h5 class="card-title">Info</h5>

		<p class="card-text">
		  Sistem ini dapat digunakan bagi mahasiswa untuk melakukan perwalian, melihat daftar matakuliah dyang sudah diambil, 
		  melalukan penilaian terhadap dosen, dll
		</p>

		<a href="#" class="card-link">Daftar Nilai</a>
		<a href="#" class="card-link">Perwalian</a>
	  </div>
	</div>

  </div>
  <!-- /.col-md-6 -->
</div>
<!-- /.row -->
<?php
echo $this->endSection();
?>
