<?php
echo $this->extend('layout/template_mahasiswa');
echo $this->section('content');
?>

<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/mahasiswa/nilai/listdata");
})
</script>
<?php
echo $this->endSection();
?>
