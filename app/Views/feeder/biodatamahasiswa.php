<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/feeder/biodatamahasiswa/show");
	$("body").on("click","#ambilbiodatamahasiswa",function(){
		$(this).html("loading....mohon tunggu!").addClass("disabled");
		var action = $(this).attr("data-src");
		$.get(action, function( data ) {
			toastr.success(data);
		   $("#resultcontent").load("<?php echo base_url();?>/feeder/biodatamahasiswa/show");
		})
		return false;
	})
})
</script>
<?php
echo $this->endSection();
?>
