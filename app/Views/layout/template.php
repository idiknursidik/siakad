<?php
$session = \Config\Services::session();

use \App\Models\Msiakad_setting;
$msiakad_setting = new Msiakad_setting();
$profil_setting = $msiakad_setting->getprofile();
if($profil_setting){
	$kodept = $profil_setting->kode_perguruan_tinggi;
	$namapt = $profil_setting->nama_perguruan_tinggi;
	$jalan = $profil_setting->jalan;
}else{
	$namapt = 'NO DATA';
}
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
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php echo $this->include('layout/navbar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo isset($judul)?$judul:"Home";?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v3</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <?php echo $this->renderSection('content');?>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
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

<!-- AdminLTE -->
<script src="<?php echo base_url();?>/public/adminlte/dist/js/adminlte.js"></script>
<!-- Jquery form -->
<script src="<?php echo base_url();?>/public/adminlte/plugins/jquery/jquery.form.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url();?>/public/adminlte/plugins/select2/js/select2.full.min.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo base_url();?>/public/adminlte/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url();?>/public/adminlte/dist/js/demo.js"></script>
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
