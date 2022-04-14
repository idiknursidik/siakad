<?php
echo $this->extend('layout/template');
echo $this->section('content');

?>

<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/akademik/kelas/formpeserta/<?php echo $id_kelas;?>");
	$("body").on("change","select[name='angkatan'],select[name='prodi']",function(){
		var dString = $("#formperangkatan").serialize();
		var action = $("#formperangkatan").attr("action");
		$.ajax({
			type:'post',
			url:action,
			data:dString,
			beforeSend:function(){
				$("#resultsperangkatan").html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
			},
			success:function(ret){
				$("#resultsperangkatan").html(ret);
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
