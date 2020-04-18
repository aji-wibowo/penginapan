<?php
//Nama page/halaman
$page = "Daftar Kamar";

//Start session
session_start();

//Load file config
require '../../../config.php';

require '../../lib/session_user.php';

//Ambil template header dashboard
require '../../layout/header_dashboard.php';
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

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Kamar bekas bundir</h3>
						</div>
						<div class="card-body">
							<div class="img-responsive">
								<img src="<?= base_url() ?>assets/img/kamar/person_1.jpg" style="width: 100%; height: 150px">
							</div>
							<div class="description">
								<p>Lokasi : ada disini</p>
								<p>Spec : Double Bed</p>
							</div>
							<div class="price">
								<p>90.000</p>
							</div>
							<a href="#" class="btn btn-sm btn-success" style="width: 100%">reservasi</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>






















