<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="icon" type="image/png" href="<?php echo base_url();?>/public/gambar/logo.png">
  <title>PMB <?php echo isset($tpl_title)?" | {$tpl_title}":"Home";?></title>
    <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/sweetalert2/sweetalert2.min.css">
  
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
        <img src="<?php echo base_url();?>/public/gambar/logo.png" alt="SIAKAD Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="<?php echo base_url();?>" class="nav-link">Siakad</a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url();?>/pmb/daftar" class="nav-link">Buat akun</a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url();?>/pmb/login" class="nav-link">Login calon mahasiswa</a>
          </li>
		  <li class="nav-item">
            <a href="<?php echo base_url();?>/pmb/info" class="nav-link">Info penerimaan mahasiswa baru</a>
          </li>
        </ul>

       
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        
       
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
              class="fas fa-th-large"></i></a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->


  <div class="login-logo">
    <a class="text-info" style="font-size:40px;"><?php echo isset($title)?$title:'Penerimaan Mahasiswa Baru';?></a>
  </div>
  <!-- /.login-logo -->
  <div style="padding:20px;">
    <div >
     <?php echo $this->renderSection('content');?>
    </div>
  </div>
  <hr>

</div>
<!-- ./wrapper -->	  

<!-- REQUIRED SCRIPTS -->

<!-- Toastr -->
<script src="<?php echo base_url();?>/public/adminlte/plugins/toastr/toastr.min.js"></script>

<!-- Bootstrap -->
<script src="<?php echo base_url();?>/public/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE -->
<script src="<?php echo base_url();?>/public/adminlte/dist/js/adminlte.js"></script>
<!-- Jquery form -->
<script src="<?php echo base_url();?>/public/adminlte/plugins/jquery/jquery.form.js"></script>
<script src="<?php echo base_url();?>/public/adminlte/plugins/vegas/vegas.min.js"></script>
<script src="<?php echo base_url();?>/public/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
