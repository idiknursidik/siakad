<?php
$session = session();
if($session->type == "admin"){
	echo $this->extend('layout/template');
}else{
	echo $this->extend('layout/template_mahasiswa');
}
echo $this->section('content');

?>
<div class="card card-solid">
	<div class="card-body">
	Sistem Informasi Akademik - FEEDER
	<?php
		echo "<pre>";
		print_r($session->get());
		echo "</pre>";
	?>
	</div>
</div>
<?php
echo $this->endSection();
?>