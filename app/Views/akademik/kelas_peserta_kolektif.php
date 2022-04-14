<?php
echo $this->extend('layout/template');
echo $this->section('content');

?>

<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/akademik/kelas/formpeserta/<?php echo $id_kelas;?>");
	$("body").on("submit","#form_tambah_peserta",function(){
		var dString = $(this).serialize();
		var action = $(this).attr("action");
		$.ajax({
			type:'post',
			dataType:'json',
			url:action,
			data:dString,
			beforeSend:function(){
				$("#btnSubmit").prop("disabled",true);
				$("#btnSubmit").html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
			},
			complete:function(){
				$("#btnSubmit").prop("disabled",false);
				$("#btnSubmit").html("<i class='fas fa-save'></i> Simpan</button>");	
			},
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					$("#modalku").modal("hide");
					$("#resultcontent").load("<?php echo base_url();?>/akademik/kelas/listpeserta/<?php echo $id_kelas;?>");
				}else{
					if(ret.error_feeder==true){
						toastr.error(ret.messages);
					}else{
						toastr.error('Data isian tidak valid');
					}
					$("div.invalid-feedback").remove();
					$.each(ret.messages, function(key, value){
						var element = $("input[name="+key+"],select[name="+key+"],textarea[name="+key+"]");
							element.closest("input.form-control,select.form-control")
							.removeClass('is-invalid')
							.addClass(value.length > 0 ? 'is-invalid' : '').find('.invalid-feedback').remove();
						element.after(value);
					})
				}
			},
			error:function(xhr,ajaxOptions,thrownError){
				alert(xhr.status+"\n"+xhr.responseText+"\n"+thrownError);				
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
	$("body").on("click","a[name='hapuspeserta']",function(e){
		e.preventDefault();
		var dString = "id_nilai="+$(this).attr("id_nilai");
		var action = $(this).attr("data-src");
		if(confirm("yakin data akan dihapus?")){
			$.ajax({
				type:'post',
				dataType:'json',
				url:action,
				data:dString,
				success:function(ret){
					if(ret.success == true){
						toastr.success(ret.messages);
						$("#resultcontent").load("<?php echo base_url();?>/akademik/kelas/listpeserta/<?php echo $id_kelas;?>");
					}else{
						toastr.error(ret.messages);
					}
				}
			})
		}
	})
	$("body").on("click","a[name^='hapusdosenmengajar']",function(){
		var dString = "id_aktivitas_mengajar="+$(this).attr("id_aktivitas_mengajar");
		var action = $(this).attr("data-src");
		var name = $(this).attr("name");
		if(confirm("yakin data akan dihapus?")){
			$.ajax({
				type:'post',
				dataType:'json',
				url:action,
				data:dString,
				beforeSend:function(){
					$("a[name='"+name+"']").prop("disabled",true);
					$("a[name='"+name+"']").html("<i class='fa fa-spin fa-spinner'></i> loading...");			
				},
				complete:function(){
					$("a[name='"+name+"']").prop("disabled",false);
					$("a[name='"+name+"']").html("hapus");	
				},
				success:function(ret){
					if(ret.success == true){
						toastr.success(ret.messages);
						$("#modalku").modal("hide");
						$("#resultcontent").load("<?php echo base_url();?>/akademik/kelas/listpeserta/<?php echo $id_kelas;?>");
					}else{
						toastr.error(ret.messages);
					}
				},
				error:function(xhr,ajaxOptions,thrownError){
					alert(xhr.status+"\n"+xhr.responseText+"\n"+thrownError);				
				}
			})
		}
		return false;
	})
})
</script>
<?php
echo $this->endSection();
?>
