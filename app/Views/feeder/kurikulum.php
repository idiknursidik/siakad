<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/feeder/kurikulum/show");
	$("body").on("click","a[name='ambildata']",function(){
		var action = $(this).attr("data-src");
		var id = $(this).attr('name');
		var btnHtml = $("#ambildata_"+id).html();
		$.get({
		  url: action,
		  dataType:'json',
		  beforeSend:function(){
			  $("#btnSubmit_"+id+"").prop("disabled",true);
			  $("#btnSubmit_"+id+"").html("<span class='spinner-grow spinner-grow-sm' role='status' aria-hidden='true'></span> Loading...");			
		  },
		  complete:function(){
			  $("#btnSubmit_"+id+"").prop("disabled",false);
			  $("#btnSubmit_"+id+"").html(btnHtml);	
		  },
		  success: function(ret) {
			  if(ret.success == true){
				toastr.success(ret.messages)
				$("#resultcontent").load("<?php echo base_url();?>/feeder/kurikulum/show");
			  }else{
				toastr.success(ret.messages)
			  }
		  },
		  error:function(xhr,ajaxOptions,thrownError){
			  alert(xhr.status+"\n"+xhr.responseText+"\n"+thrownError);				
		  }	

	  });
		
		return false;
	})
})
</script>
<?php
echo $this->endSection();
?>
