<?php
//Nama page/halaman
$page = "CHECKOUT BERHASIL";

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

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card" style="margin-top: 10px;">
						<div class="card-header">
							<h3 class="card-title">Berhasil Checkout</h3>
						</div>
						<div class="card-body">
							<div class="callout callout-success">
								<h5>Berhasil Pesan!</h5>

								<p>Silahkan lakukan pembayaran dan submit bukti bayar pada menu reservasi Anda. Halaman ini akan redirect otomatis dalam 10detik ke halaman reservasi Anda.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>

<script type="text/javascript">
	

    // Your application has indicated there's an error
    window.setTimeout(function(){

        // Move to a new location or you can do something else
        window.location.href = "https://www.google.co.in";

    }, 10000);

</script>


<?php
require '../../layout/footer_dashboard.php';
?>
