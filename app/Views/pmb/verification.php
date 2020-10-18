<?php
echo $this->extend('layout/template_pmb');
echo $this->section('content');
?>

<div>
	<div class="alert alert-success" id="resultcontent">Loading data....</div>
</div><br>
<script>
$(function(){
	$("#resultcontent").html("<?php echo $messages;?>");
})
</script>
<?php
echo $this->endSection();
?>
