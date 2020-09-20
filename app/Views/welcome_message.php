<?php
$session = session();
if($session->type == "admin"){
	echo $this->extend('layout/template');
}else{
	echo $this->extend('layout/template_mahasiswa');
}


echo $this->section('content');
?>
<section class="content">
     <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-graduation-cap"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Jumlah Mahasiswa</span>
                <span class="info-box-number">
                  <?php echo $jumlah_mahasiswa;?>
                  <small>Mahasiswa</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-building"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Jumlah Prodi</span>
                <span class="info-box-number"><?php echo $jumlah_prodi;?> <small>Program Studi</small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-address-card"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Jumlah Pegawai</span>
                <span class="info-box-number">760</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-chalkboard-teacher"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Jumlah Dosen</span>
                <span class="info-box-number"><?php echo $jumlah_dosen;?> <small>Dosen</small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
	</div>
</section>
<div class="container-fluid">	
<div class="card card-solid">
	<div class="card-header">
    <h5 class="card-title">Sistem Informasi Akademik - FEEDER</h5>

	<div class="card-tools">
	  <button type="button" class="btn btn-tool" data-card-widget="collapse">
		<i class="fas fa-minus"></i>
	  </button>
	  
	  <button type="button" class="btn btn-tool" data-card-widget="remove">
		<i class="fas fa-times"></i>
	  </button>
	</div>
    </div>
	<div class="card-body">
	
	<?php
		echo "<pre>";
		print_r($session->get());
		echo "</pre>";
	?>
	</div>
</div>
</div>
<?php
echo $this->endSection();
?>