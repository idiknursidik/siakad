<?php
echo $this->extend('layout/template');
echo $this->section('content');

?>
<p id="resultcontent">Loding...</p>


<script>
$("#resultcontent").load("<?php echo base_url();?>/akademik/mahasiswa/hapusdata_detail/<?php echo $id_mahasiswa;?>");

$("body").on("submit","#form_tambahpendidikan",function(){
	var action = $(this).attr("action");
	var dString = $(this).serialize();
	var id = $(this).attr("id");
	var htmlbtn = $("#btnKirim_"+id).html();
	$.ajax({
		dataType:'json',
		type:'post',
		url:action,
		data:dString,
		beforeSend:function(){
			$("#btnKirim_"+id).prop("disabled",true);
			$("#btnKirim_"+id).html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
		},
		complete:function(){
			$("#btnKirim_"+id).prop("disabled",false);
			$("#btnKirim_"+id).html(htmlbtn);	
		},
		success:function(ret){
			if(ret.success == true){
				toastr.success(ret.messages);
				$("#modalku").modal("hide");
				$("#informasidata").load("<?php echo base_url();?>/akademik/mahasiswa/gethistoripendidikan/<?php echo $id_mahasiswa;?>");
			}else{
				toastr.error("Data tidak valid");
				$("div.invalid-feedback").remove();
					$.each(ret.messages, function(key, value){
						var element = $("input[name="+key+"],select[name="+key+"],textarea[name="+key+"]");
							element.closest("input.form-control")
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
</script>
<?php
echo $this->endSection();
?>
