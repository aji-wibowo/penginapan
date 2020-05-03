<?php
// require 'lib/session_admin.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?=$web_info['web_name']?> - <?=$page?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/croppie.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap-datepicker.min.css">
	<!-- JQVMap -->
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/jqvmap/jqvmap.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?=base_url()?>assets/css/adminlte.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.css">
	<!-- summernote -->
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/summernote/summernote-bs4.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

	<!-- jQuery -->
	<script src="<?=base_url()?>assets/plugins/jquery/jquery.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a class="nav-link">Anda login sebagai <b><?=$_SESSION['admin']['username']?></b> dengan role Admin</a>
				</li>
			</ul>
		</nav>

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="<?=base_url()?>admin/" class="brand-link">
				<span class="brand-text font-weight-light"><?=$web_info['web_name']?></span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<li class="nav-item">
							<a href="<?=base_url()?>admin/" class="nav-link <?php if($page == "Dashboard Admin"){ echo"active"; } ?>">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p>Dashboard</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url()?>admin/manage-rooms/" class="nav-link <?php if($page == "Daftar Kamar"){ echo"active"; } ?>">
								<i class="nav-icon fas fa-bed"></i>
								<p>Kamar</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url()?>admin/manage-guests/" class="nav-link <?php if($page == "Daftar Tamu"){ echo"active"; } ?>">
								<i class="nav-icon fas fa-users"></i>
								<p>Tamu</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url()?>admin/manage-reservations/" class="nav-link <?php if($page == "Daftar Reservasi"){ echo"active"; } ?>">
								<i class="nav-icon fas fa-book-open"></i>
								<p>Reservasi</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url()?>admin/manage-payments/" class="nav-link <?php if($page == "Daftar Pembayaran"){ echo"active"; } ?>">
								<i class="nav-icon fas fa-hand-holding-usd"></i>
								<p>Pembayaran</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url()?>admin/manage-ratings/" class="nav-link <?php if($page == "Daftar Penilaian"){ echo"active"; } ?>">
								<i class="nav-icon fas fa-star"></i>
								<p>Penilaian</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url()?>admin/manage-report/" class="nav-link <?php if($page == "Daftar Laporan"){ echo"active"; } ?>">
								<i class="nav-icon fas fa-book"></i>
								<p>Laporan</p>
							</a>
						</li>
						<li class="nav-header">Setting</li>
						<li class="nav-item">
							<a href="<?= base_url() ?>admin/my-account" class="nav-link <?php if($page == "Pengaturan Akun"){ echo"active"; } ?>">
								<i class="nav-icon fas fa-cog"></i>
								<p>Akun</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link" data-toggle="modal" data-target="#modal-logout">
								<i class="nav-icon fas fa-sign-out-alt"></i>
								<p>Logout</p>
							</a>
						</li>
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>
		<div class="modal fade" id="modal-logout">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Konfirmasi</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Apakah anda yakin akan keluar?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-times btn-xs"></i> Tidak</button>
						<a href="<?=base_url()?>admin/logout" type="button" class="btn btn-danger" ><i class="fas fa-check btn-xs"></i> Ya, saya yakin</a>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>