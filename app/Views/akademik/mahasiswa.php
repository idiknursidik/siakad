<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="row no-print">
	<div class="col-12">
	  <a href="#" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
	  <a href="#" name="getmahasiswapddikti" id="btnGet" data-src="<?php echo base_url();?>/akademik/mahasiswa/getmahasiswapddikti" class="btn btn-primary float-right" style="margin-right: 5px;">
		<i class="fas fa-download"></i> Ambil dari PDDIKTI
	  </a>
	</div>
</div>
<br>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/akademik/mahasiswa/listdata");	
	$("a[name='getmahasiswapddikti']").on("click",function(){
		var action = $(this).attr("data-src");
		var btnGet = $(this).attr("id");
		var htmlbtn = $(this).html();
		if(confirm("yakin akan mengambil data?")){
			$.ajax({
				dataType:'json',
				url:action,
				beforeSend:function(){
					$("#"+btnGet).addClass("disabled");
					$("#"+btnGet).html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
				},
				complete:function(){
					$("#"+btnGet).removeClass("disabled");
					$("#"+btnGet).html(htmlbtn);	
				},
				success:function(ret){
					if(ret.success == true){
						toastr.success(ret.messages);
						$("#resultcontent").load("<?php echo base_url();?>/akademik/mahasiswa/listdata");
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
	
	$("a[name='tambahdata']").on("click",function(e){
		e.preventDefault();
		$(".modal-dialog").removeClass("modal-lg").addClass("modal-xl");
	})
	$("body").on("submit","#form_tambah,#form_ubah",function(){
		var dString = $(this).serialize();
		var action = $(this).attr("action");
		$.ajax({
			type:'post',
			dataType:'json',
			url:action,
			data:dString,
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					$("#modalku").modal("hide");
					$("#resultcontent").load("<?php echo base_url();?>/akademik/mahasiswa/listdata");
				}else{
					if(ret.error_feeder==true){
						toastr.error(ret.messages);
					}else{
						toastr.error('Data isian tidak valid');
					}
					$("div.invalid-feedback").remove();
					$.each(ret.messages, function(key, value){
						var element = $("input[name="+key+"],select[name="+key+"],textarea[name="+key+"]");
							element.closest("input.form-control")
							.removeClass('is-invalid')
							.addClass(value.length > 0 ? 'is-invalid' : '').find('.invalid-feedback').remove();
						element.after(value);
					})
				}
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
	
	$("body").on("submit","#form_importmahasiswa",function(){
		var action = $(this).attr("action");
		var dString = $(this).serialize();
		var id = $(this).attr("id");
		var btnHtml = $("#btnSubmit_"+id+"").html();
		$(this).ajaxSubmit({
			type:'post',
			dataType:'json',
			url:action,
			data:dString,
			beforeSend:function(){
				$("#btnSubmit_"+id+"").prop("disabled",true);
				$("#btnSubmit_"+id+"").html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
			},
			complete:function(){
				$("#btnSubmit_"+id+"").prop("disabled",false);
				$("#btnSubmit_"+id+"").html(btnHtml);	
			},
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					
				}else{
					toastr.error("isian tidak valid");					
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
})
</script>
<?php
echo $this->endSection();
?>
