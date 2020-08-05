<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/impor/mahasiswa/show");
	$("body").on("click","a[name^='impormahasiswa_']",function(){
		$(this).html("loading....mohon tunggu!").addClass("disabled");
		var action = $(this).attr("data-src");
		var idpendaftaran = $(this).attr("idpendaftaran");
		var dString = "idpendaftaran="+idpendaftaran;
		$.ajax({
			type:'post',
			dataType:'json',
			url:action,
			data:dString,
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					$("#resultcontent").load("<?php echo base_url();?>/impor/mahasiswa/show");
				}else{
					toastr.error(ret.messages);
				}
				$("a[name='impormahasiswa_"+idpendaftaran+"']").html("Kirim ke Feeder").removeClass("disabled");
			}
			
		})
		return false;
	})
})
</script>
<?php
echo $this->endSection();
?>
