<?php
echo $this->extend('layout/template_pmb');
echo $this->section('content');
?>

<div>
	<div class="alert alert-success" id="resultcontent">Loading data....</div>
</div><br>
<script>
$(function(){
	$("#resultcontent").html(function(){
		$(this).html("<?php echo $messages;?>");
		window.setTimeout(function(){
			window.location = "<?php echo base_url();?>/pmb/login";
		},3000);
	});
})
</script>
<?php
echo $this->endSection();
?>
