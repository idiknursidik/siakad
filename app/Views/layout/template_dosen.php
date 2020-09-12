<?php
if(!session()->username || session()->type != 'dosen'){	
	?>
		<script> document.location="<?php echo base_url();?>/login/logout"; </script>
	<?php
	exit();
}
$session = \Config\Services::session();

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
}
$infoakun = $msiakad_akun->getakundosen(false,$session->username);

$uri = current_url(true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="icon" type="image/png" href="<?php echo base_url();?>/public/gambar/logo.png">
  <title>SIAKAD <?php echo isset($title)?" | {$title}":"";?></title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/fontawesome-free/css/all.min.css">
   <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">  
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  
   <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
   <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/dist/css/adminlte.min.css">
   <!-- jQuery -->
  <script src="<?php echo base_url();?>/public/adminlte/plugins/jquery/jquery.min.js"></script>
	
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="#" class="navbar-brand">
        <img src="<?php echo base_url();?>/public/gambar/<?php echo $logopt;?>" alt="SIAKAD Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"><img src="<?php echo base_url();?>/public/adminlte/dist/img/user1-128x128.jpg" class="brand-image img-circle elevation-3"></span>
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="<?php echo base_url();?>" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url();?>/dosen/biodata" class="nav-link">Biodata Dosen</a>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Info Akademik</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="#" class="dropdown-item">Jadwal Mengajar </a></li>
              <li><a href="#" class="dropdown-item">Materi</a></li>

              <li class="dropdown-divider"></li>
              <li><a href="#" class="dropdown-item">Perwalian</a></li>
         
            </ul>
          </li>
        </ul>

       
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
              class="fas fa-th-large"></i></a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo isset($judul)?$judul:"Home";?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
              <li class="breadcrumb-item active"><a href="<?php echo (string)$uri;?>"><?php echo isset($judul)?$judul:"Halaman depan";?></a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container -->
    </div>
    <!-- /.content-header -->
	

    <!-- Main content -->
    <div class="content" style="min-height:500px;">
      <div class="container">
		<?php echo $this->renderSection('content');?>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">      
		<div class="text-center">
			<h5>Info Akun</h5>
			<img class="profile-user-img img-fluid img-circle" src="<?php echo base_url();?>/public/adminlte/dist/img/user4-128x128.jpg" alt="User profile picture">
			<p><?php echo $infoakun->nama_dosen;?></p>
		</div>
	  <hr>
      <p><a href="<?php echo base_url();?>/login/logout">Profile</a><br>
      <a href="<?php echo base_url();?>/login/logout">Logout</a></p>
	  
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo (date("Y")==2020)?"2020":"2020 - ".date('Y')."";?> - <?php echo $namapt;?>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
	  Page rendered in {elapsed_time} seconds
      
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!--modal-->
<div class="modal fade" id="modalku">
<div class="modal-dialog modal-lg"> <!--modal-xl-->
  <div class="modal-content">
	<div class="modal-header">
	  <h4 class="modal-title">Default Modal</h4>
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	</div>
	<div class="modal-body">
	  <p id="modalisi">One fine body&hellip;</p>
	</div>
	<div class="modal-footer justify-content-between">
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  <!--<button type="button" class="btn btn-primary">Save changes</button>-->
	</div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
	  

<!-- REQUIRED SCRIPTS -->
<!-- Toastr -->
<script src="<?php echo base_url();?>/public/adminlte/plugins/toastr/toastr.min.js"></script>

<!-- Bootstrap -->
<script src="<?php echo base_url();?>/public/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>/public/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/public/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>/public/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>/public/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>/public/adminlte/plugins/datatables/dataTables.fixedHeader.min.js"></script>

<!-- AdminLTE -->
<script src="<?php echo base_url();?>/public/adminlte/dist/js/adminlte.js"></script>
<!-- Jquery form -->
<script src="<?php echo base_url();?>/public/adminlte/plugins/jquery/jquery.form.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url();?>/public/adminlte/plugins/select2/js/select2.full.min.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo base_url();?>/public/adminlte/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url();?>/public/adminlte/dist/js/pages/dashboard3.js"></script>
<script>

$('body').on("click", "a.modalButton,button.modalButton", function() {
  var src = $(this).attr('data-src');
  var title = $(this).attr("title");
  if (!title) {
	title = $(this).attr("data-original-title");
  }
  if (!src || src.length == 0) {
	return false;
  }
  $(".modal-title").html(title);
  $('#modalisi').html('Loading, please wait...');
  $('#modalisi').load(src);
})
</script>
  
</body>
</html>
