<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/feeder/dictionary/show");
	$("body").on("click","a[name^='showdictionary_']",function(){
		var action = $(this).attr("data-src");
		var fungsi =  $(this).attr("fungsi");
		$.get(action, function( data ) {
			$('#showdictionary_'+fungsi+'').html(data).toggle();
		  
		})
		return false;
	})
})
</script>
<?php
echo $this->endSection();
?>
