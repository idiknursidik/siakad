<?php
namespace App\Models;

use \App\Models\Msiakad_setting;
use \App\Models\Msiakad_akun;
use \App\Models\Msiakad_prodi;

$msiakad_setting = new Msiakad_setting();
$msiakad_akun = new Msiakad_akun();
$msiakad_prodi = new Msiakad_prodi();

$profil_setting = $msiakad_setting->getprofile();
$profileinfo = $msiakad_setting->getdata();

if($profileinfo){
	if($profil_setting){	
		$namapt = $profil_setting->nama_perguruan_tinggi;
		$jalan	= $profil_setting->jalan;
	}
	$kodept	= $profileinfo->kodept;
	$logopt	= ($profileinfo->logopt)?$profileinfo->logopt:'logo.png';
}else{
	$kodept = "NO DATA";
	$logopt = "logo.png";
}
$dataprodi = $msiakad_prodi->getdata();
$dataakun = $msiakad_akun->getakun(false,session()->username);
if($dataakun){
	$userimage = ($dataakun->user_image)?$dataakun->user_image:"noimage.png";
}else{
	$userimage = "noimage.png";
}
?>
<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo base_url();?>" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo base_url();?>/profile" class="nav-link">- <b><?php echo session()->nama;?></b> Login As <b><?php echo session()->nama_level;?></b></a>
      </li>
    </ul>

    <!-- SEARCH FORM 
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
	-->
	
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>

 <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url();?>/admin/profilpt" class="brand-link">
      <img src="<?php echo base_url();?>/public/gambar/<?php echo $logopt;?>" alt="SIAKAD Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">SIAKAD | <?php echo $kodept;?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url();?>/public/gambar/<?php echo $userimage;?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?php echo site_url('profile');?>" class="d-block"><?php echo session()->get('nama');?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
		
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
		<?php
		if(session()->get("level") == 1){
		?>
          <li class="nav-item has-treeview <?php echo isset($mn_setting)?'menu-open':'';?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Setting Sistem
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">5</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url();?>/admin/datauser" class="nav-link <?php echo isset($mn_setting_datauser)?'active':'';?>">
                  <i class="fas fa-user-cog nav-icon"></i>
                  <p>Kelola Admin</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/admin/datausermahasiswa" class="nav-link <?php echo isset($mn_setting_datausermhs)?'active':'';?>">
                  <i class="fas fa-user-cog nav-icon"></i>
                  <p>Kelola User Mahasiswa</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/admin/datauserdosen" class="nav-link <?php echo isset($mn_setting_datauserdosen)?'active':'';?>">
                  <i class="fas fa-user-cog nav-icon"></i>
                  <p>Kelola User Dosen</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>/admin/profilpt" class="nav-link <?php echo isset($mn_setting_profile)?'active':'';?>">
                  <i class="fas fa-sign nav-icon"></i>
                  <p>Setting Profile</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/admin/perkuliahan" class="nav-link <?php echo isset($mn_setting_perkuliahan)?'active':'';?>">
                  <i class="fas fa-sign nav-icon"></i>
                  <p>Setting Perkuliahan</p>
                </a>
              </li>               
            </ul>
          </li>
		<?php
		}
		?>
		  <li class="nav-header">DATA PT</li>
		  <?php
		  if(in_array(session()->get("level"),array('1','2'))){
		  ?>
          <li class="nav-item has-treeview <?php echo isset($mn_akademik)?'menu-open':'';?>">
            <a href="#" class="nav-link <?php echo isset($mn_akademik)?'active':'';?>">
              <i class="nav-icon fas fa-school"></i>
              <p>
                Kelola Akademik
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">5</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
				<?php
				if(session()->get("level") == 1){
				?>
			   <li class="nav-item">
                <a href="<?php echo base_url();?>/akademik/prodi" class="nav-link <?php echo isset($mn_akademik_prodi)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data prodi</p>
                </a>
               </li>
			   
			   <?php
			   ///cek apakah sudah ada data prodi?
				if($dataprodi){
				   ?>
					<li class="nav-item">
					<a href="<?php echo base_url();?>/akademik/dosenwali" class="nav-link <?php echo isset($mn_akademik_dosenwali)?'active':'';?>">
					  <i class="far fa-circle nav-icon"></i>
					  <p>Kelola dosen wali</p>
					</a>
				   </li>
					
					<?php
					}
				}
				if($dataprodi){
				?>
               <li class="nav-item">
                <a href="<?php echo base_url();?>/akademik/mahasiswadaftar" class="nav-link <?php echo isset($mn_akademik_mahasiswadaftar)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mahasiswa Baru <span class="right badge badge-danger">PMB</span></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>/akademik/mahasiswa" class="nav-link <?php echo isset($mn_akademik_mahasiswa)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Mahasiswa</p>
                </a>
              </li>
              
			  <li class="nav-item has-treeview <?php echo isset($mn_akademik_perkuliahan)?'menu-open':'';?>">
                <a href="#" class="nav-link <?php echo isset($mn_akademik_perkuliahan)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Perkuliahan
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
				  <li class="nav-item">
                    <a href="<?php echo base_url();?>/akademik/riwayatpendidikan" class="nav-link <?php echo isset($mn_akademik_riwayatpendidikan)?'active':'';?>">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Riwayat Pendidikan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url();?>/akademik/matakuliah" class="nav-link <?php echo isset($mn_akademik_matakuliah)?'active':'';?>">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Matakuliah</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url();?>/akademik/kurikulum" class="nav-link <?php echo isset($mn_akademik_kurikulum)?'active':'';?>">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Kurikulum</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url();?>/akademik/kelas" class="nav-link <?php echo isset($mn_akademik_kelas)?'active':'';?>">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Kelas</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="<?php echo base_url();?>/akademik/dosenmengajar" class="nav-link <?php echo isset($mn_akademik_dosenmengajar)?'active':'';?>">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Dosen Mengajar</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="<?php echo base_url();?>/akademik/nilai" class="nav-link <?php echo isset($mn_akademik_nilai)?'active':'';?>">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Nilai</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="<?php echo base_url();?>/akademik/akm" class="nav-link <?php echo isset($mn_akademik_akm)?'active':'';?>">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>AKM</p>
                    </a>
                  </li>
				  <li class="nav-item">
                    <a href="<?php echo base_url();?>/akademik/kelulusan" class="nav-link <?php echo isset($mn_akademik_kelulusan)?'active':'';?>">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Kelulusan</p>
                    </a>
                  </li>
                </ul>
              </li>
			  <?php
				}
				?>
			  
			  
            </ul>
          </li>
		  <?php
		  }
		  if(session()->get("level") == 4){
		  ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Data Kepegawaian
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Pendidik</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kependidikan</p>
                </a>
              </li>
              
            </ul>
          </li>
		  <?php
		  }
		  if(session()->get("level") == 3){
		  ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-coins"></i>
              <p>
                Data Keuangan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/UI/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/icons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Icons</p>
                </a>
              </li>
              
            </ul>
          </li>
		  <?php
		  }
		  if(in_array(session()->get("level"),array('1','2'))){
		  ?>
		  
          <li class="nav-header">PDDIKTI - FEEDER</li>
          <li class="nav-item">
            <a href="<?php echo base_url();?>/feeder/akun" class="nav-link <?php echo isset($mn_akun)?'active':'';?>">
              <i class="nav-icon fas fa fa-cog fa-spin fa-3x fa-fw"></i>
              <p>
                Akun PDDIKTI Setting
              </p>
            </a>
          </li>
		  <!--
          <li class="nav-item">
            <a href="pages/gallery.html" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Gallery
              </p>
            </a>
          </li>
		  -->
		  <?php
		  $session 	= \Config\Services::session();
		  $feeder_akun = $session->get("feeder_akun");
		  if($feeder_akun){
		  ?>
		  <li class="nav-item">
            <a href="<?php echo base_url();?>/feeder/referensi" class="nav-link <?php echo isset($mn_referensi)?'active':'';?>">
              <i class="nav-icon fas fa fa-book"></i>
              <p>
                Kelola Referensi
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="<?php echo base_url();?>/feeder/dictionary" class="nav-link <?php echo isset($mn_dictionary)?'active':'';?>">
              <i class="nav-icon fas fa fa-book"></i>
              <p>
                Lihat Dictionary
              </p>
            </a>
          </li>
          <li class="active nav-item has-treeview <?php echo isset($mn_feeder_a)?'menu-open':'';?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-sync-alt"></i>
              <p>
                Kelola Data PDDIKTI
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/profilept" class="nav-link <?php echo isset($mn_profilept)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profile PT</p>
                </a>
              </li>
			  <?php
			  if($profil_setting){ //jika sudah ambil data
			  ?>
              <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/dataprodi" class="nav-link <?php echo isset($mn_dataprodi)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Prodi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/periode" class="nav-link <?php echo isset($mn_periode)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Periode Aktif</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/mahasiswa" class="nav-link <?php echo isset($mn_mahasiswa)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Mahasiswa</p>
                </a>
              </li>
			   <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/biodatamahasiswa" class="nav-link <?php echo isset($mn_biodatamahasiswa)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Biodata Mahasiswa</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/riwayatpendidikan" class="nav-link <?php echo isset($mn_riwayatpendidikan)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Riwayat Pendidikan</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/nilaitransfer" class="nav-link <?php echo isset($mn_nilaitransfer)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nilai transfer</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/krs" class="nav-link <?php echo isset($mn_krs)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>KRS Mahasiswa</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/nilai" class="nav-link <?php echo isset($mn_nilai)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nilai Mahasiswa</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/lulusan" class="nav-link <?php echo isset($mn_lulusan)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Lulusan</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/akm" class="nav-link <?php echo isset($mn_akm)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>AKM Mahasiswa</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/kurikulum" class="nav-link <?php echo isset($mn_kurikulum)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kurikulum</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/kurikulummatakuliah" class="nav-link <?php echo isset($mn_kurikulum_matakuliah)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kurikulum Matakuliah</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/matakuliah" class="nav-link <?php echo isset($mn_matakuliah)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Matakuliah</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/kelas" class="nav-link <?php echo isset($mn_kelas)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kelas Kuliah</p>
                </a>
              </li>
			   <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/datadosen" class="nav-link <?php echo isset($mn_datadosen)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Dosen</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/dosenmengajar" class="nav-link <?php echo isset($mn_dosenmengajar)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dosen Mengajar</p>
                </a>
              </li>
			  <?php
			  } // jika sudah ambil data
			  ?>
            </ul>
          </li>
		  
		  <li class="nav-item has-treeview <?php echo isset($mn_feeder_b)?'menu-open':'';?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fab fa-telegram"></i>
              <p>
                Impor ke PDDIKTI
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url();?>/impor/mahasiswa" class="nav-link <?php echo isset($mn_b_mahasiswa)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Mahasiswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>/feeder/dataprodi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Prodi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/mailbox/read-mail.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Read</p>
                </a>
              </li>
            </ul>
          </li>
		  <!-- tool-->
		  <li class="nav-item has-treeview <?php echo isset($mn_feeder_c)?'menu-open':'';?>">
            <a href="#" class="nav-link active ">
              <i class="nav-icon fa fa-cog"></i>
              <p>
                Tool PDDIKTI
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url();?>/feedertool/mahasiswa" class="nav-link <?php echo isset($mn_c_mahasiswa)?'active':'';?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hapus Data Mahasiswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>/feedertool/kelas" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hapus Kelas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>/feedertool/akm" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hapus AKM</p>
                </a>
              </li>
            </ul>
          </li>
		  <?php
		  }
		  }
		  ?>
          
          <li class="nav-header">AKUN</li>
          <li class="nav-item">
            <a href="<?php echo site_url('profile');?>" class="nav-link <?php echo isset($mn_profile)?'active':'';?>">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">Profile</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo site_url('login/logout');?>" class="nav-link">
              <i class="nav-icon far fa-circle text-warning"></i>
              <p>Keluar</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>