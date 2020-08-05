<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>
<div class="card card-solid">
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	$("#resultcontent").load("<?php echo base_url();?>/akademik/mahasiswadaftar/listdata");
	$("body").on("click","a[name='hapusdata']",function(){
		if(confirm("yakin data akan dihapus?")){
			$.ajax({
				type:'post',
				dataType:'json',
				url:$(this).attr("href"),
				data:"id="+$(this).attr("id")+"&csrf_test_name="+$(this).attr("csrf_test_name"),
				success:function(ret){
					if(ret.success == true){
						toastr.success(ret.messages);
						$("#resultcontent").load("<?php echo base_url();?>/akademik/mahasiswadaftar/listdata");
					}else{
						toastr.error('Data isian tidak valid');
					}
				}
			})
		}
		return false;
	})
	$("body").on("click","a[name^='terimamahasiswa_']",function(){
		if(confirm("yakin akan melanjutkan?")){
			$.ajax({
				type:'post',
				dataType:'json',
				url:$(this).attr("href"),
				data:"id="+$(this).attr("id"),
				success:function(ret){
					if(ret.success == true){
						toastr.success(ret.messages);
						$("#resultcontent").load("<?php echo base_url();?>/akademik/mahasiswadaftar/listdata");
					}else{
						toastr.error(ret.messages);
					}
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
