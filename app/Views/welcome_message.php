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
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">CPU Traffic</span>
                <span class="info-box-number">
                  10
                  <small>%</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Likes</span>
                <span class="info-box-number">41,410</span>
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
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Sales</span>
                <span class="info-box-number">760</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">New Members</span>
                <span class="info-box-number">2,000</span>
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