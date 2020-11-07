<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/feeder/lulusan/show");
	$("body").on("click","#ambildatalulusan",function(){
		var action = $(this).attr("data-src");
		var btnHtml = $(this).html();
		$.ajax({
			dataType:'json',
			url:action,
			beforeSend:function(){
				$("#ambildatalulusan").prop("disabled",true);
				$("#ambildatalulusan").html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
			},
			complete:function(){
				$("#ambildatalulusan").prop("disabled",false);
				$("#ambildatalulusan").html(btnHtml);	
			},
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);	
					$("#resultcontent").load("<?php echo base_url();?>/feeder/lulusan/show");

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
