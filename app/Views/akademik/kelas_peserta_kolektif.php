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
	$("body").on("change","select[name='angkatan'],select[name='prodi']",function(){
		var dString = $("#formperangkatan").serialize();
		var action = $("#formperangkatan").attr("action");
		$.ajax({
			type:'post',
			url:action,
			data:dString,
			beforeSend:function(){
				$("#resultsperangkatan").html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
			},
			success:function(ret){
				$("#resultsperangkatan").html(ret);
			},
			error:function(xhr,ajaxOptions,thrownError){
				alert(xhr.status+"\n"+xhr.responseText+"\n"+thrownError);				
			}
		})
		return false;
	})
	
	$("body").on("submit","#form-prosespesertakolektif",function(){
		var dString = $(this).serialize();
		var action = $(this).attr("action");
		var id_kelas = $("input[name='id_kelas']").val();
		var angkatan = $("input[name='angkatan']").val();
		var prodi = $("input[name='prodi']").val();
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
				$.ajax({
					type:'post',
					url:action,
					data:'id_kelas'+id_kelas+'&angkatan='+angkatan+'&prodi='+prodi,
					beforeSend:function(){
						$("#resultsperangkatan").html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
					},
					success:function(ret){
						$("#resultsperangkatan").html(ret);
					}
				})
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
	
	
	  $("body").on("click","#parent",function() {
		$(".child").prop("checked", this.checked);
	  })
	  $('body').on("click",".child",function() {
		if ($('.child:checked').length == $('.child').length) {
		  $('#parent').prop('checked', true);
		} else {
		  $('#parent').prop('checked', false);
		}
	  })
})
</script>
<?php
echo $this->endSection();
?>
