<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/impor/kurikulum/show");
	$("body").on("click","a[name^='imporkurikulum_']",function(){
		$(this).html("loading....mohon tunggu!").addClass("disabled");
		var action = $(this).attr("data-src");
		var id_kurikulum = $(this).attr("id_kurikulum");
		var dString = "id_kurikulum="+id_kurikulum;
		$.ajax({
			type:'post',
			dataType:'json',
			url:action,
			data:dString,
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					$("#resultcontent").load("<?php echo base_url();?>/impor/kurikulum/show");
				}else{
					toastr.error(ret.messages);
				}
				$("a[name='imporkurikulum_"+id_kurikulum+"']").html("Kirim ke Feeder").removeClass("disabled");
			}
			
		})
		return false;
	})
})
</script>
<?php
echo $this->endSection();
?>
