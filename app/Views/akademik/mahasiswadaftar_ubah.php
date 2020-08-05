<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div>
	<div id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/akademik/mahasiswadaftar/formubah/<?php echo $id;?>");
	$("body").on("submit","#form_ubah",function(){
		$("button[name='kirim']").html("loading....mohon tunggu!").addClass("disabled");
		var action = $(this).attr("action");
		var dString = $(this).serialize();
		$.ajax({
			type:'post',
			dataType:'json',
			url:action,
			data:dString,
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					$("#resultcontent").load("<?php echo base_url();?>/akademik/mahasiswadaftar/formubah/<?php echo $id;?>");
				}else{
					toastr.error('Data isian tidak valid');
					$("html, body").animate({ scrollTop: 0 }, "slow");					
					$("div.invalid-feedback").remove();
					$.each(ret.messages, function(key, value){
						var element = $("input[name="+key+"],select[name="+key+"],textarea[name="+key+"]");
							element.closest("input.form-control")
							.removeClass('is-invalid')
							.addClass(value.length > 0 ? 'is-invalid' : '').find('.invalid-feedback').remove();
						element.after(value);
					})
				}
				$("button[name='kirim']").html("Simpan data").removeClass("disabled");
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
