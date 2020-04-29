<?php
//unset($_SESSION['notification']);
?>
<!-- jQuery -->
<script src="<?=base_url()?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>assets/js/adminlte.min.js"></script>
<script>
	// Alert auto hidden
	$(".alert").delay(2000).slideUp(500, function() {
		$(this).alert('close');
	});
</script>

</body>
</html>