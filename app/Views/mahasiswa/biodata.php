<?php
echo $this->extend('layout/template_mahasiswa');
echo $this->section('content');
?>
<div id="resultcontent">Loading data....</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/mahasiswa/biodata/viewdata");
	$("body").on("submit","#form_ubah",function(){
		var dString = $(this).serialize();
		var action = $(this).attr("action");
		var id = $(this).attr("id");
		var btnHtml = $("#btnSubmit_"+id).html();
		$.ajax({
			type:'post',
			dataType:'json',
			url:action,
			data:dString,
			beforeSend:function(){
				$("#btnSubmit_"+id).prop("disabled",true);
				$("#btnSubmit_"+id).html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
			},
			complete:function(){
				$("#btnSubmit_"+id).prop("disabled",false);
				$("#btnSubmit_"+id).html(btnHtml);	
			},
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					$("#resultcontent").load("<?php echo base_url();?>/mahasiswa/biodata/viewdata");
				}else{
					if(ret.error_feeder==true){
						toastr.error(ret.messages);
					}else{
						toastr.error('Data isian tidak valid');
					}
					$("html, body").stop().animate({scrollTop:0}, 500, 'swing', function() { });
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
})
</script>
<?php
echo $this->endSection();
?>
