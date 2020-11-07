<?php
use \App\Models\Msiakad_setting;
$msiakad_setting = new Msiakad_setting();
$profil_setting = $msiakad_setting->getprofile();
if($profil_setting){
	$kodept = $profil_setting->kode_perguruan_tinggi;
	$namapt = $profil_setting->nama_perguruan_tinggi;
	$jalan = $profil_setting->jalan;
}else{
	$namapt = 'Perguruan Tinggi';
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
    <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>/public/adminlte/plugins/vegas/vegas.min.css">
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
<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <a class="text-white" style="font-size:40px; text-shadow:1px 1px 1px #000;">SIAKAD</a>
  </div>
  <!-- /.login-logo -->
  <a href="<?php echo base_url();?>/pmb/daftar" class="btn btn-danger" style="margin-left:5px; margin-bottom:-4px; padding-bottom:10px;">Pendaftaran Mahasiswa Baru</a>
  <div class="card" style="padding:20px;">
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="form_login" action="<?php echo base_url();?>/login/proseslogin" method="post">
	  <?php
		echo csrf_field();
	  ?>
        <div class="input-group mb-3">
          <input type="text" name="username" id="username" class="form-control" placeholder="Username" aria-describedby="username-error">		  
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
		  <span id="username-error" class="error invalid-feedback">loading...</span>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password" aria-describedby="password-error">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
		  <span id="password-error" class="error invalid-feedback">Loading..</span>
        </div>
        <div class="row">
          <div class="col-7">
           <!-- <div class="icheck-primary"> -->
              <input type="checkbox" name="tampilkan_password" id="tampilkan_password">
              <label for="remember">
                Lihat Password
              </label>
             <!-- </div>-->
          </div>
          <!-- /.col -->
          <div class="col-5">
            <button type="submit" id="btnLogin_form_login" class="btn btn-primary btn-block btnLogin"> <i class="fas fa-unlock"></i> Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
	  <br>
        <hr>      
      </div>
      <!-- /.social-auth-links -->
		
      <p class="mb-1 text-center">
        <a href="#" id="lupa_password">Lupa Password</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<p class="text-white"><?php echo $namapt;?></p>
	  

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

<script>
$(document).ready(function(){
	
	$("#form_login").on("submit",function(e){
		e.preventDefault();
		var id = $(this).attr("id");
		var btnHtml = $("#btnLogin_"+id).html();
		$.ajax({
			type:'post',
			url:$(this).attr("action"),
			data:$(this).serialize(),
			dataType:'json',
			beforeSend:function(){
				$("#btnLogin_"+id).prop("disabled",true);
				$("#btnLogin_"+id).html("<i class='fa fa-spin fa-spinner'></i>");			
			},
			complete:function(){
				$("#btnLogin_"+id).prop("disabled",false);
				$("#btnLogin_"+id).html(btnHtml);	
			},
			success:function(response){
				if(response.error){
					if(response.error.username){
						$("#username").addClass("is-invalid");
						$("#username-error").html(response.error.username);
					}else{
						$("#username").removeClass("is-invalid");
						$("#username-error").html("");
					}
					if(response.error.password){
						$("#password").addClass("is-invalid");
						$("#password-error").html(response.error.password);
					}else{
						$("#password").removeClass("is-invalid");
						$("#password-error").html("");
					}
				}
				if(response.success){
					window.location=response.success.link;
				}
			},
			error:function(xhr,ajaxOptions,thrownError){
				alert(xhr.status+"\n"+xhr.responseText+"\n"+thrownError);				
			}
		})
		return false;
	})
	$("#lupa_password").on("click",function(){
		Swal.fire(
		  'Lupa password atau belum punya akun?',
		  'Silahkan Kontak Bagian Akademik',
		  'info'
		)
	})
})
$(function() {
	$("#tampilkan_password").on("change",function(){
		if($(this).prop('checked')) {
			$("input[name='password']").attr("type","text");
		} else {
			$("input[name='password']").attr("type","password");
		}
		//return false;
	})
    $('body').vegas({
		delay: 7000,
		timer: false,
		shuffle: true,
		firstTransition: 'fade',
		firstTransitionDuration: 5000,
		transition: 'zoomOut',
		transitionDuration: 2000,
        slides: [
            { src: '<?php echo base_url();?>/public/adminlte/dist/img/vegas/photo1.png' },
            { src: '<?php echo base_url();?>/public/adminlte/dist/img/vegas/photo2.png' }
        ],
		overlay: '<?php echo base_url();?>/public/adminlte/plugins/vegas/overlays/08.png'
    });
});
</script>