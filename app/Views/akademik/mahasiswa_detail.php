<?php
use App\Models\Mfungsi;
$this->mfungsi	= new Mfungsi();

$userimage = ($infoakun)?$infoakun->user_image:"noimage.png";

echo $this->extend('layout/template');
echo $this->section('content');
?>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-md-3">

		<!-- Profile Image -->
		<div class="card card-primary card-outline">
		  <div class="card-body box-profile">
			<div class="text-center">
			  <img class="profile-user-img img-fluid img-circle" src="<?php echo base_url();?>/public/gambar/<?php echo $userimage;?>" alt="User profile picture">
			</div>

			<h3 class="profile-username text-center"><?php echo $data->nama_mahasiswa;?></h3>

			<p class="text-muted text-center"><?php echo $this->mfungsi->jenis_kelamin($data->jenis_kelamin);?></p>

			<ul class="list-group list-group-unbordered mb-3">
			  <li class="list-group-item">
				<b><a name="mhs_biodata" href="<?php echo base_url();?>/akademik/mahasiswa/getbiodata/<?php echo $id_mahasiswa;?>">Biodata mahasiswa</a></b>
			  </li>
			  <li class="list-group-item">
				<b><a name="mhs_historipendidikan" href="<?php echo base_url();?>/akademik/mahasiswa/gethistoripendidikan/<?php echo $id_mahasiswa;?>">Histori Pendidikan</a></b>
			  </li>
			  <li class="list-group-item">
				<b><a name="mhs_krs" href="<?php echo base_url();?>/akademik/mahasiswa/getkrs/<?php echo $id_mahasiswa;?>">KRS Mahasiswa</a></b>
			  </li>
			  <li class="list-group-item">
				<b>History Nilai</b>
			  </li>
			  <li class="list-group-item">
				<b>Aktivitas Perkuliahan</b>
			  </li>
			  <li class="list-group-item">
				<b>Aktivitas Mahasiswa</b>
			  </li>
			</ul>
		  </div>
		  <!-- /.card-body -->
		</div>
		<!-- /.card -->
	  </div>
	  <!-- /.col -->
	  <div class="col-md-9">
		<div class="card">
		  <div class="card-header p-2">
			<ul class="nav nav-pills">
			  <li class="nav-item"><a data-toggle="tab">Informasi data Mahasiswa</a></li>
			</ul>
		  </div><!-- /.card-header -->
		  <div class="card-body" id="resultcontent">
			<div class="tab-content">
			  <div class="tab-pane active" id="informasidata">                    
				  <p>
				  <table class="table">
				  <tr><th width="20%">Alamat</th><td>: <?php echo $data->jalan;?></td></tr>
				  <tr><th width="20%">RT</th><td>: <?php echo $data->rt;?></td></tr>
				  <tr><th width="20%">RW</th><td>: <?php echo $data->rw;?></td></tr>
				  <tr><th width="20%">Dusun</th><td>: <?php echo $data->dusun;?></td></tr>
				  <tr><th width="20%">Keluarahan</th><td>: <?php echo $data->kelurahan;?></td></tr>
				  <tr><th width="20%">Kodepos</th><td>: <?php echo $data->kode_pos;?></td></tr>
				  <tr><th width="20%">NISN</th><td>: <?php echo $data->nisn;?></td></tr>
				  <tr><th width="20%">NIK</th><td>: <?php echo $data->nik;?></td></tr>
				  <tr><th width="20%">Tempat Lahir</th><td>: <?php echo $data->tempat_lahir;?></td></tr>
				  <tr><th width="20%">Tanggal Lahir</th><td>: <?php echo $data->tanggal_lahir;?></td></tr>
				  <tr><th width="20%">Agama</th><td>: <?php echo $data->id_agama;?></td></tr>
				  </table>
				  </p>                      
			  </div>
			 
			  <!-- /.tab-pane -->
			</div>
			<!-- /.tab-content -->
		  </div><!-- /.card-body -->
		</div>
		<!-- /.nav-tabs-custom -->
	  </div>
	  <!-- /.col -->
	</div>
	<!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<script>
$("a[name^=mhs_]").on("click",function(e){
	e.preventDefault();
	var action = $(this).attr("href");
	$("#resultcontent").load(action,function(){
		$("a[data-toggle='tab']").removeClass("active");
	})
})
</script>
<?php
echo $this->endSection();
?>
