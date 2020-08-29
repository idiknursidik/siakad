<?php
echo $this->extend('layout/template');
echo $this->section('content');

?>
<div class="row no-print">
	<div class="col-12">
	  <a href="#" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
	  <a href="#modalku" data-toggle="modal" title="Tambah Peserta" data-src="<?php echo base_url();?>/akademik/kelas/tambahpeserta/<?php echo $id_kelas;?>" class="btn btn-success float-right modalButton"><i class="far fa-credit-card"></i> Tambah Peserta</a>
	  <a href="#" target="_blank" class="btn btn-default float-right" style="margin-right: 5px;"><i class="fas fa-plus"></i> Tambah peserta kolektif</a>
	  <a href="#modalku" data-toggle="modal" title="Tambah Dosen Mengajar" data-src="<?php echo base_url();?>/akademik/kelas/tambahdosen/<?php echo $id_kelas;?>" class="btn btn-info float-right modalButton" style="margin-right: 5px;"><i class="fas fa-plus"></i> Tambah Dosen Mengajar</a>
	</div>
</div>
<br>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/akademik/kelas/listpeserta/<?php echo $id_kelas;?>");
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
})
</script>
<?php
echo $this->endSection();
?>
