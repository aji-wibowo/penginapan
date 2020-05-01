<?php
//Nama page/halaman
$page = "Dashboard Admin";

//Start session
session_start();

//Load file config
require '../config.php';

require 'lib/session_admin.php';

//Ambil template header dashboard
require 'layout/header_dashboard.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark"><?=$page?></h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active"><?=$page?></li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-info">
						<div class="inner">
							<h3><?= $dashboard['reservationCount'] ?></h3>

							<p>Reservation</p>
						</div>
						<div class="icon">
							<i class="fas fa-book-open"></i>
						</div>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-success">
						<div class="inner">
							<h3><?= $dashboard['belumLunas'] ?></h3>

							<p>Belum Lunas</p>
						</div>
						<div class="icon">
							<i class="fas fa-hourglass-half"></i>
						</div>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-warning">
						<div class="inner">
							<h3><?= $dashboard['expired'] ?></h3>

							<p>Expired</p>
						</div>
						<div class="icon">
							<i class="fas fa-times-circle"></i>
						</div>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-danger">
						<div class="inner">
							<h3><?= $dashboard['lunas'] ?></h3>

							<p>Lunas</p>
						</div>
						<div class="icon">
							<i class="fas fa-check-double"></i>
						</div>
					</div>
				</div>
				<!-- ./col -->
			</div>
		</div>
	</section>
	<!-- /.content -->

	<section class="col-lg-12 connectedSortable ui-sortable">
		<!-- Custom tabs (Charts with tabs)-->
		<div class="card">
			<div class="card-header ui-sortable-handle" style="cursor: move;">
				<h3 class="card-title">
					<i class="fas fa-chart-pie mr-1"></i>
					Reservation yang complete selama satu tahun
				</h3>
			</div>
			<div class="card-body">
				<canvas id="myChart" width="100%" height="30"></canvas>
			</div>
		</div>
	</div>
</section>
<!-- /.content-wrapper -->
<?php
require 'layout/footer_dashboard.php';
?>