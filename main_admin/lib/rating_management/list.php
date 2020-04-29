<?php
$page = "Daftar Penilaian";
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
					<h1 class="m-0 text-dark"><i class="nav-icon fas fa-star"></i> <?=$page?></h1>
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
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?=$page?></h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>No.</th>
										<th>Nilai</th>
										<th>Ulasan</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									$check_rating = $connect->query("SELECT * FROM penilaian ORDER BY kd_penilaian ASC");
									while ($data_ratings = $check_rating->fetch_assoc()) {
										?>  
										<tr>
											<td><?=$no?></td>
											<td>
												<?php
												if ($data_ratings['nilai'] == 1) {
													$nilai = "Buruk";
												}if ($data_ratings['nilai'] == 2) {
													$nilai = "Kurang";
												}if ($data_ratings['nilai'] == 3) {
													$nilai = "Cukup";
												}if ($data_ratings['nilai'] == 4) {
													$nilai = "Baik";
												}if ($data_ratings['nilai'] == 5) {
													$nilai = "Baik Sekali";
												}
												?>
												<?=$nilai?></td>
											<td><?=$data_ratings['ulasan']?></td>
										</tr>
										<?php 
										$no++;
									} ?>        
								</tbody>
								<tfoot>
									<tr>
										<th>No.</th>
										<th>Nilai</th>
										<th>Ulasan</th>
									</tr>
								</tfoot>
							</table>
						</div>
						<!-- /.card-body -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
require '../../layout/footer_dashboard.php';
?>