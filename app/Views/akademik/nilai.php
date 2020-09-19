<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="row no-print">
	<div class="col-12">
	  <a href="#" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
	  <a href="#modalku" data-toggle="modal" title="Tambah Data Excel" data-src="<?php echo base_url();?>/akademik/nilai/tambah" class="btn btn-success float-right modalButton"><i class="far fa-credit-card"></i> Tambah data</a>
	  <a href="#" name="getnilaipddikti" data-src="<?php echo base_url();?>/akademik/nilai/getnilaipddikti" class="btn btn-primary float-right" style="margin-right: 5px;">
		<i class="fas fa-download"></i> Ambil dari PDDIKTI
	  </a>
	</div>
</div>
<br>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/akademik/nilai/showdataserverside");
	
	$("a[name='getnilaipddikti']").on("click",function(){
		var action = $(this).attr("data-src");
		$.ajax({
			dataType:'json',
			url:action,
			beforeSend:function(){
				$("a[name='getnilaipddikti']").prop("disabled",true);
				$("a[name='getnilaipddikti']").html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
			},
			complete:function(){
				$("a[name='getnilaipddikti']").prop("disabled",false);
				$("a[name='getnilaipddikti']").html("<i class='fas fa-download'></i> Ambil dari PDDIKTI");	
			},
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);	
					$("#resultcontent").load("<?php echo base_url();?>/akademik/nilai/listdata");

				}else{
					toastr.error(ret.messages);
				}
			},
			error:function(xhr,ajaxOptions,thrownError){
				alert(xhr.status+"\n"+xhr.responseText+"\n"+thrownError);				
			}
		})
		return false;
	})
	
	
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
					$("#resultcontent").load("<?php echo base_url();?>/akademik/nilai/listdata");
				}else{
					if(ret.error_feeder==true){
						toastr.error(ret.messages);
					}else{
						toastr.error('Data isian tidak valid');
					}
					$("div.invalid-feedback").remove();
					$.each(ret.messages, function(key, value){
						var element = $("input[name="+key+"],select[name="+key+"],textarea[name="+key+"]");
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
	$("body").on("click","input,select,textarea",function(){
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
