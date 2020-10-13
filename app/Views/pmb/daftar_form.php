<script type='text/javascript'>
$(function(){
	$("#form_daftar").on("submit",function(){
		var dString = $(this).serialize();
		var action = $(this).attr("action");
		var id = $(this).attr("id");
		$.ajax({
			type:'post',
			dataType:'json',
			url:action,
			data:dString,
			beforeSend:function(){
				$("#btnSubmit_"+id+"").prop("disabled",true);
				$("#btnSubmit_"+id+"").html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
			},
			complete:function(){
				$("#btnSubmit_"+id+"").prop("disabled",false);
				$("#btnSubmit_"+id+"").html("Daftar calon mahasiswa");	
			},
			success:function(ret){
				if(ret.success == true){
					Swal.fire(
						  ''+ret.messages+'',
						  'success'
					).then(function() {
						window.location = "<?php echo base_url();?>/pmb/login";
					});	
					

				}else{
					toastr.error('Data isian tidak valid');
					$("div.invalid-feedback").remove();
					$.each(ret.messages, function(key, value){
						var element = $("input[name="+key+"],select[name="+key+"],textarea[name="+key+"]");
							element.closest("input.form-control")
							.removeClass('is-invalid')
							.addClass(value.length > 0 ? 'is-invalid' : '').find('.invalid-feedback').remove();
						element.after(value);
					})
				}
			},
			error:function(xhr,ajaxOptions,thrownError){
				alert(xhr.status+"\n"+xhr.responseText+"\n"+thrownError);				
			}
		})
		return false;
	})
	$("body").on("click","input,select,textarea",function(){
		var element = $(this);
			element.closest("input.form-control")
			.removeClass('is-invalid').find('.invalid-feedback').remove();
			element.after(value="");
	})
});
</script>
<form id="form_daftar" action="<?php echo base_url();?>/pmb/daftar/prosesdaftar" method="post">
  <?php
	echo csrf_field();
  ?>
  <label>Alamat Email</label>
	<div class="input-group mb-3">	  
	  <input type="text" name="email" id="email" class="form-control" placeholder="masukan email" aria-describedby="email-error">		  
	</div>
	<label>Konfirmasi alamat Email</label>
	<div class="input-group mb-3">	  
	  <input type="text" name="konfirmasi_email" id="konfirmasi_email" class="form-control" placeholder="ulangi alamat email" aria-describedby="konfirmasi_email-error">		  
	</div>
	<label>Nomor KTP/NIK/NISN</label>
	<div class="input-group mb-3">		
		<input type="text" name="nik" id="nik" class="form-control" placeholder="masukan KTP/NIK/NISN" aria-describedby="nik-error">	
	</div>
	<label>Nomor Handphone</label>
	<div class="input-group mb-3">		
		<input type="text" name="hp" id="hp" class="form-control" placeholder="masukan nomoh HP yang dapat dihubungi" aria-describedby="hp-error">	
	</div>
	<label>Nama</label>
	<div class="input-group mb-3">		
		<input type="text" name="nama" id="nama" class="form-control" placeholder="masukan Nama sesuai KTP" aria-describedby="nama-error">	
	</div>
	<hr>
	<div class="row">
	  <div class="col-8">
		<button type="submit" id="btnSubmit_form_daftar" class="btn btn-primary btnLogin">Daftar calon mahasiswa</button>
	  </div>
	  <!-- /.col -->
	  <div class="col-4">
		
	  </div>
	  <!-- /.col -->
	</div>
</form>


