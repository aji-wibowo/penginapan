<?php
$page = "Daftar Kamar";
session_start();

//Load file config
require '../../../config.php';
require '../../lib/session_admin.php';
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

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">DataTable with default features</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>No.</th>
										<th>Tipe Kamar</th>
										<th>Harga Kamar</th>
										<th>Kode Lokasi</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									$check_rooms = $connect->query("SELECT * FROM kamar ORDER BY id ASC ");
									while ($data_rooms = $check_rooms->fetch_assoc()) {
										?>  
										<tr>
											<td><?=$no++?></td>
											<td><?=$data_rooms['tipe_kamar']?></td>
											<td><?=$data_rooms['harga_kamar']?></td>
											<td><?=$data_rooms['kode_lokasi']?></td>
											<td>
												<button type="button" class="btn btn-warning btn-xs"><i class="fas fa-pen"></i></button>
												<button type="button" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
											</td>
										</tr>
									<?php } ?>        
								</tbody>
								<tfoot>
									<tr>
										<th>No.</th>
										<th>Tipe Kamar</th>
										<th>Harga Kamar</th>
										<th>Kode Lokasi</th>
										<th>Aksi</th>
									</tr>
								</tfoot>
							</table>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
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