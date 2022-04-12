<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/impor/akm/show");
	$("body").on("click","a[name^='imporakm_']",function(){
		$(this).html("loading....mohon tunggu!").addClass("disabled");
		var action = $(this).attr("data-src");
		var id_akm = $(this).attr("id_akm");
		var dString = "id_akm="+id_akm;
		$.ajax({
			type:'post',
			dataType:'json',
			url:action,
			data:dString,
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					$("#resultcontent").load("<?php echo base_url();?>/impor/akm/show");
				}else{
					toastr.error(ret.messages);
				}
				$("a[name='imporakm_"+id_akm+"']").html("Kirim ke Feeder").removeClass("disabled");
			}
			
		})
		return false;
	})
})
</script>
<?php
echo $this->endSection();
?>
