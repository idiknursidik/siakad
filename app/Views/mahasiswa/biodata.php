<?php
echo $this->extend('layout/template_mahasiswa');
echo $this->section('content');
?>

<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/mahasiswa/biodata/viewdata");
	
	$("a[name='getmahasiswapddikti']").on("click",function(){
		var action = $(this).attr("data-src");
		$(this).html("loading....mohon tunggu!").addClass("disabled");
		$.get(action, function( data ) {		  
			if(data.success == true){
			   toastr.success(data.messages);
			    $("#resultcontent").load("<?php echo base_url();?>/akademik/mahasiswa/listdata");
			}else{
				toastr.error(data.messages);
			}
			$("a[name='getmahasiswapddikti']").html("<i class='fas fa-download'></i> Ambil dari PDDIKTI").removeClass("disabled");
		},'json')
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
})
</script>
<?php
echo $this->endSection();
?>
