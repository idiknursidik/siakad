<?php
echo $this->extend('layout/template_pmb');
echo $this->section('content');
?>

<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div><br>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/pmb/daftar/formdaftar");
})
</script>
<?php
echo $this->endSection();
?>
