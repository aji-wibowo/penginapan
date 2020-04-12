<?php
if (isset($_SESSION['admin'])) {
	$sess_email = $_SESSION['admin']['email'];
}else{
	$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Mohon login terlebih dahulu.');
	exit(header("Location: ".base_url()."admin/login/"));
}
