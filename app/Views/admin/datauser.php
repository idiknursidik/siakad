<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="row no-print">
	<div class="col-12">
	  <a href="#" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
	  <a href="#modalku" data-toggle="modal" title="Tambah Akun" data-src="<?php echo base_url();?>/admin/datauser/tambah" class="btn btn-success float-right modalButton"><i class="far fa-credit-card"></i> Tambah data</a>	
	</div>
</div>
<br>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/admin/datauser/listdata");
	$("body").on("submit","#form_tambah,#form_ubah",function(){
		var dString = $(this).serialize();
		var action = $(this).attr("action");
		$.ajax({
			type:'post',
			dataType:'json',
			url:action,
			data:dString,
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					$("#modalku").modal("hide");
					$("#resultcontent").load("<?php echo base_url();?>/admin/datauser/listdata");
				}else{
					if(ret.error_feeder==true){
						toastr.error(ret.messages);
					}else{
						toastr.error('Data isian tidak valid');
					}
					$("div.invalid-feedback").remove();
					$.each(ret.messages, function(key, value){						
						var element = $("input[name="+key+"],select[name="+key+"],textarea[name="+key+"],checkbox[name="+key+"]");
							element.closest("input.form-control")
							.removeClass('is-invalid')
							.addClass(value.length > 0 ? 'is-invalid' : '').find('.invalid-feedback').remove();
						element.after(value);
					})
				}
			}
		})
		return false;
	})
	$("body").on("click","input,select,textarea,checkbox",function(){
		var element = $(this);
			element.closest("input.form-control")
			.removeClass('is-invalid').find('.invalid-feedback').remove();
			element.after(value="");
	})
})
</script>
<?php
echo $this->endSection();
?>
