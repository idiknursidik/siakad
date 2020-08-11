<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/admin/profilpt/form");
	$("body").on("submit","#form_profile",function(){
		$("button[name='kirim']").html("loading....mohon tunggu!").addClass("disabled");
		var action = $(this).attr("action");
		var dString = $(this).serialize();
		$(this).ajaxSubmit({
			type:'post',
			dataType:'json',
			url:action,
			data:dString,
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					document.location="<?php echo base_url();?>/admin/profilpt";
				}else{
					toastr.error('Data isian tidak valid');					
					$("div.invalid-feedback").remove();
					$.each(ret.messages, function(key, value){
						var element = $("input[name="+key+"],select[name="+key+"],textarea[name="+key+"]");
							element.closest("input.form-control")
							.removeClass('is-invalid')
							.addClass(value.length > 0 ? 'is-invalid' : '').find('.invalid-feedback').remove();
						element.after(value);
					})
				}
				$("button[name='kirim']").html("Proses data").removeClass("disabled");
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
	
	$("body").on("change","input[name='fileupload']",function(e){
		const fileupload = document.querySelector('#logoFile');
		const fileuploadlabel = document.querySelector('.custom-file-label');
		const imgpreview = document.querySelector('.img-preview');
		fileuploadlabel.textContent = fileupload.files[0].name;
		
		const uploadfile = new FileReader();
		uploadfile.readAsDataURL(fileupload.files[0]);
		
		uploadfile.onload = function(e){
			imgpreview.src = e.target.result;
		}
		return false;
	})
	/*
	function previewImg(){
		const fileupload = document.querySelector('#logoFile');
		const fileuploadlabel = document.querySelector('.custom-file-label');
		const imgpreview = document.querySelector('.img-preview');
		fileuploadlabel.textContent = fileupload.files[0].name;
		
		const uploadfile = new FileReader();
		uploadfile.readAsDataURL(fileupload.file[0]);
		
		uploadfile.onload = function(e){
			imgpreview.src = e.target.result;
		}
	}*/
})
</script>
<?php
echo $this->endSection();
?>