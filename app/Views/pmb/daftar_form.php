<form id="form_login" action="<?php echo base_url();?>/pmb/daftar/prosesdaftar" method="post">
  <?php
	echo csrf_field();
  ?>
  <label>Alamat Email</label>
	<div class="input-group mb-3">
	  
	  <input type="text" name="email" id="email" class="form-control" placeholder="masukan email" aria-describedby="email-error">		  
	  <div class="input-group-append">
		<div class="input-group-text">
		  <span class="fas fa-envelope"></span>
		</div>
	  </div>
	  <span id="email-error" class="error invalid-feedback">loading...</span>
	</div>
	<label>Konfirmasi alamat Email</label>
	<div class="input-group mb-3">	  
	  <input type="text" name="konfirmasi_email" id="konfirmasi_email" class="form-control" placeholder="ulangi alamat email" aria-describedby="konfirmasi_email-error">		  
	  <div class="input-group-append">
		<div class="input-group-text">
		  <span class="fas fa-envelope"></span>
		</div>
	  </div>
	  <span id="email-error" class="error invalid-feedback">loading...</span>
	</div>
	<label>Nomor KTP/NIK/NISN</label>
	<div class="input-group mb-3">		
		<input type="text" name="nik" id="nik" class="form-control" placeholder="masukan KTP/NIK/NISN" aria-describedby="nik-error">	
	</div>
	<label>Nomor Handphone</label>
	<div class="input-group mb-3">		
		<input type="text" name="hp" id="hp" class="form-control" placeholder="masukan nomoh HP yang dapat dihubungi" aria-describedby="hp-error">	
	</div>
	<div class="row">
	  <div class="col-8">
		<button type="submit" class="btn btn-primary btnLogin">Daftar calon mahasiswa</button>
	  </div>
	  <!-- /.col -->
	  <div class="col-4">
		
	  </div>
	  <!-- /.col -->
	</div>
  </form>