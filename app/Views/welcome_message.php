<?php
echo $this->extend('layout/template');
echo $this->section('content');
 $session = session();

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