<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="row no-print">
	<div class="col-12">
	  <a href="#" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
	  <a href="#modalku" data-toggle="modal" title="Tambah Kurikulum" data-src="<?php echo base_url();?>/akademik/kurikulum/tambah" class="btn btn-success float-right modalButton"><i class="far fa-credit-card"></i> Tambah data</a>
	  <?php
		if(session()->level == 1){
	  ?>
	  <a href="#" name="getkurikulumpddikti" data-src="<?php echo base_url();?>/akademik/kurikulum/getkurikulumpddikti" class="btn btn-primary float-right" style="margin-right: 5px;">
		<i class="fas fa-download"></i> Ambil Kurikulum dari PDDIKTI
	  </a>
	  <a href="#" name="getkurikulummatakuliahpddikti" data-src="<?php echo base_url();?>/akademik/kurikulum/getkurikulummatakuliahpddikti" class="btn btn-primary float-right" style="margin-right: 5px;">
		<i class="fas fa-download"></i> Ambil Kurikulum Matakuliah dari PDDIKTI
	  </a>
		<?php
		}
		?>
	</div>
</div>
<br>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/akademik/kurikulum/listdata");
	$("a[name='getkurikulumpddikti'],a[name='getkurikulummatakuliahpddikti']").on("click",function(){
		var action = $(this).attr("data-src");
		$(this).html("loading....mohon tunggu!").addClass("disabled");
		$.get(action, function( data ) {		  
			if(data.success == true){
			   toastr.success(data.messages);
			    $("#resultcontent").load("<?php echo base_url();?>/akademik/kurikulum/listdata");
			}else{
				toastr.error(data.messages);
			}
			$("a[name='getkurikulumpddikti']").html("<i class='fas fa-download'></i> Ambil Kurikulum dari PDDIKTI").removeClass("disabled");
			$("a[name='getkurikulummatakuliahpddikti']").html("<i class='fas fa-download'></i> Ambil Kurikulum Matakuliah dari PDDIKTI").removeClass("disabled");
		},'json')
		return false;
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
					$("#resultcontent").load("<?php echo base_url();?>/akademik/kurikulum/listdata");
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
	$("body").on("a[name='hapusdata']",function(e){
		e.prevenDefault();
		var dString = "id_kurikulum="+$(this).attr("id_kurikulum");
		var action = $(this).attr("action");
		$.ajax({
			type:'post',
			dataType:'json',
			url:action,
			data:dString,
			success:function(ret){
				if(ret.success == true){
					toastr.success(ret.messages);
					$("#resultcontent").load("<?php echo base_url();?>/akademik/kurikulum/listdata");
				}else{
					toastr.success(ret.messages);
				}
			}
		})
		return false;	
	})
})
</script>
<?php
echo $this->endSection();
?>
