<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/feeder/akun/form");
	$("body").on("submit","#login_feeder",function(){
		var dString = $(this).serialize();
		var id = $(this).attr("id");
		var btncontent = $("#btnSubmit_"+id).html();
		var action = $(this).attr("action");
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
				$("#btnSubmit_"+id+"").html(btncontent);	
			},
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					document.location="<?php echo base_url();?>/feeder/akun";
				}else{
					if(ret.error_feeder==true){
						toastr.error(ret.messages);
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
	function strip_html_tags(str)
	{
	   if ((str===null) || (str===''))
		   return false;
	  else
	   str = str.toString();
	  return str.replace(/<[^>]*>/g, '');
	}

})
</script>
<?php
echo $this->endSection();
?>
