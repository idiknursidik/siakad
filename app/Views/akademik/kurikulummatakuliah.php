<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="row no-print">
	<div class="col-12">
	  <a href="#" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
	  <a href="#modalku" data-toggle="modal" title="Tambah Kurikulum Matakuliah" data-src="<?php echo base_url();?>/akademik/kurikulummatakuliah/tambah/<?php echo $id_kurikulum;?>" class="btn btn-success float-right modalButton"><i class="far fa-credit-card"></i> Tambah data</a>
	  <?php
		if(session()->level == 1){
	  ?>
	  <a href="#" name="getkurikulummatakuliahpddikti" id="btnGetdata" data-src="<?php echo base_url();?>/akademik/kurikulummatakuliah/getkurikulummatakuliahpddikti/<?php echo $id_kurikulum;?>" class="btn btn-primary float-right" style="margin-right: 5px;">
		<i class="fas fa-download"></i> Ambil Kurikulum Matakuliah dari PDDIKTI
	  </a>
	  <?php
		}
		?>
	</div>
</div>
<hr>
<div class="card card-solid">
<div class="card-body">Salin data Matakuliah Kurikulum dari  :</div>
</div>
<br>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/akademik/kurikulummatakuliah/listdata/<?php echo $id_kurikulum;?>");
	$("a[name='getkurikulummatakuliahpddikti'],a[name='getkurikulummatakuliahmatakuliahpddikti']").on("click",function(){
		var action = $(this).attr("data-src");
		$(this).html("loading....mohon tunggu!").addClass("disabled");
		$.get(action, function( data ) {		  
			if(data.success == true){
			   toastr.success(data.messages);
			    $("#resultcontent").load("<?php echo base_url();?>/akademik/kurikulummatakuliah/listdata/<?php echo $id_kurikulum;?>");
			}else{
				toastr.error(data.messages);
			}
			$("a[name='getkurikulummatakuliahpddikti']").html("<i class='fas fa-download'></i> Ambil kurikulummatakuliah dari PDDIKTI").removeClass("disabled");
			$("a[name='getkurikulummatakuliahmatakuliahpddikti']").html("<i class='fas fa-download'></i> Ambil kurikulummatakuliah Matakuliah dari PDDIKTI").removeClass("disabled");
		},'json')
		return false;
	})
	$("body").on("submit","#form_tambah",function(){
		var dString = $(this).serialize();
		var action = $(this).attr("action");
		$.ajax({
			type:'post',
			dataType:'json',
			url:action,
			data:dString,
			beforeSend:function(){
				$("#btnTambah").prop("disabled",true);
				$("#btnTambah").html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
			},
			complete:function(){
				$("#btnTambah").prop("disabled",false);
				$("#btnTambah").html("<i class='fas fa-save'></i> Simpan");	
			},
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					$("#modalku").modal("hide");
					$("#resultcontent").load("<?php echo base_url();?>/akademik/kurikulummatakuliah/listdata/<?php echo $id_kurikulum;?>");
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
	$("body").on("click","a[name='hapuskurikulummatakuliah']",function(){
		var action = $(this).attr("data-src");
		var id_kurikulummatakuliah = $(this).attr("id_kurikulummatakuliah");
		var dString = "id_kurikulummatakuliah="+id_kurikulummatakuliah;
		if(confirm("yakin data akan dihapus?")){
			$.ajax({
				type:'post',
				dataType:'json',
				url:action,
				data:dString,
				beforeSend:function(){
					$("#hapuskurikulummatakuliah_"+id_kurikulummatakuliah+"").prop("disabled",true);
					$("#hapuskurikulummatakuliah_"+id_kurikulummatakuliah+"").html("<i class='fa fa-spin fa-spinner'></i> mohon tunggu...");			
				},
				complete:function(){
					$("#hapuskurikulummatakuliah_"+id_kurikulummatakuliah+"").prop("disabled",false);
					$("#hapuskurikulummatakuliah_"+id_kurikulummatakuliah+"").html("hapus");	
				},
				success:function(ret){
					if(ret.success == true){
						toastr.success(ret.messages);	
						$("#resultcontent").load("<?php echo base_url();?>/akademik/kurikulummatakuliah/listdata/<?php echo $id_kurikulum;?>");
					}else{
						toastr.error('Data isian tidak valid');
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
