<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/feeder/datadosen/show");
	$("body").on("click","#ambildata",function(){
		var action = $(this).attr("data-src");
		$.ajax({
			type:'post',
			dataType:'json',
			url:action,
			beforeSend:function(){
				$("#ambildata").prop("disabled",true);
				$("#ambildata").html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
			},
			complete:function(){
				$("#ambildata").prop("disabled",false);
				$("#ambildata").html("Ambil data");	
			},
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					$("#resultcontent").load("<?php echo base_url();?>/feeder/datadosen/show");
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
})
</script>
<?php
echo $this->endSection();
?>
