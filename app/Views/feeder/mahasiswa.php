<?php
echo $this->extend('layout/template');
echo $this->section('content');
?>

                
<div class="card card-solid">
	<div class="card-header" id="resultheader" style="display:none">
		<p id="progress_div" style="float:left;padding-top:5px;padding-left:10px;margin:0px;"></p>
		<div style="clear:both"></div>
		
		
		<div id="loading" style="display:none;position:relative;background-color:#fff;opacity:0.5; width:100%; height: 100%; margin:10px;">Loading..</div>
		<h4 id="info_sinkronisasi" class="alert alert-danger" style="display:none; margin-bottom:10px; font-weight:normal"></h4>
	
		<div style="clear:both"></div>
		
		<div id="progressbar_div" class="progress progress-striped active">
		  <div class="bar progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" id="progressbar" style="display:none; width:0%; margin-bottom:10px">0%</div>
		</div>	
		
		<div style="clear:both"></div>
	</div>
	<div class="card-body" id="resultcontent">Loading data....</div>
</div>
<script>
$(function(){
	//$("#resultheader").load("<?php echo base_url();?>/feeder/mahasiswa/resultheader");
	$("#resultcontent").load("<?php echo base_url();?>/feeder/mahasiswa/show");
	$("body").on("click","#ambilmahasiswa",function(){
		$("#resultheader").show();
		start();
		$(this).html("loading....mohon tunggu!").addClass("disabled");
		var action = $(this).attr("data-src");
		$.get(action, function( data ) {
			toastr.success(data);
		   $("#resultcontent").load("<?php echo base_url();?>/feeder/mahasiswa/show",function(){
			//$("#resultheader").hide();
		   });
		})
		return false;
	})
	
	var endinfo = 0;
    
    function starttimer() {
		endinfo = 0;	
		$("#loading").hide(5);
		
    }
    
    function start() {
        $('#progress_div').html('');
        $('#progress_div').show();
		$('#info_sinkronisasi').html('');
		$('#info_sinkronisasi').hide();
		
        $('.btn_start').attr('disabled', 'disabled');
		starttimer();
		
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>/feeder/mahasiswa/inputdata',
			data : {_token: 'Bg9QmUyG6iGMpL4tHTYyVrzOMRNhYbij875oj98b'},
            success: function(ret){
				try
				{
					retjson = $.parseJSON(ret);
					msg = retjson.msg;
					if (retjson.status){
						$("#loading").show(5);
						isEnd(msg, retjson.status);
					}else{
						isEnd(ret, '0');
					}
				}catch(e){
					isEnd(ret, '0');
				}
			},
            error: function(obj,err) {
				if(obj.status != 0){
					isEnd(err,0);
				}
			}
        });
    }
	
	function progress(percent){
		if(percent){
			$("#progressbar").show();
			$("#progressbar").css("width",percent+"%");
			$("#progressbar").html(percent+"%");
		}
	}
	function isEnd(msg, status){
		$("#loading").hide(5);			
		$('#progress_div').html('');
		$("#progress_div").hide();
		
		endinfo = 1;
		
		
		if(status=='0' && msg=='_updateversi_'){
			updateVersi();
			return;
		}else if(status=='0' && msg=='_restart_'){
			start();
			return;
		}else if(status=='0' && msg=='_push_'){
			push();
			return;
		}
		
		$('.btn_start').removeAttr('disabled');
		last_msg = '';
		if(status=='0'){
			$("#info_sinkronisasi").attr('class','alert alert-danger');
		}else{
			progress(100);
			$("#info_sinkronisasi").attr('class','alert alert-info');
		}
		$("#info_sinkronisasi").show(20);
		$("#info_sinkronisasi").html(msg);
	}
	
})
</script>
<?php
echo $this->endSection();
?>
