<?php

$page = "Daftar Laporan";

session_start();

//Load file config
require '../../../config.php';
require '../../lib/session_main_admin.php';
require '../../layout/header_dashboard.php';

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark"><i class="nav-icon fas fa-book-open"></i> <?=$page?></h1>
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
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?=$page?></h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<?php
									if (check_flashdata('message') != '') {
										?>
										<div class="alert alert-danger">
											<h5>Error!</h5>
											<?=get_flashdata('message')?>
										</div>
										<?php
									}
									?>
									<form action="<?= base_url() ?>admin/manage-report/cetak" method="post">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Date from:</label>

													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text">
																<i class="far fa-calendar-alt"></i>
															</span>
														</div>
														<input type="date" name="dateFrom" class="form-control float-right">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Date to:</label>

													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text">
																<i class="far fa-calendar-alt"></i>
															</span>
														</div>
														<input type="date" name="dateTo" class="form-control float-right">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<button class="btn btn-sm btn-success float-right" type="submit" name="submit"><i class="fas fa-print btn-xs"></i> print</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- /.card -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Informasi</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<li>Tekan tombol <button type="button" class="btn btn-sm btn-success"><i class="fas fa-print btn-xs"></i> print</button> untuk mendownload laporan pdf.</li>
							<li>Isi date from dan date to dengan benar.</li>
							<li>Pengisian tanggal date from tidak boleh lebih dari date to.</li>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
			</div>
		</div>
	</section>
</div>

<!-- /.content-wrapper -->
<?php
require '../../layout/footer_dashboard.php';
?>