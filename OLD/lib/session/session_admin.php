<?php
if (!isset($_SESSION['admin'])) {
	$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Mohon login terlebih dahulu.');
	exit(header("Location: ".base_url()."admin/login"));
}
// if (isset($_SESSION['user'])) {
// 	$check_user = $conn->query("SELECT * FROM users WHERE username = '".$_SESSION['user']['username']."' AND level = 'Developers'");
// 	$data_user = $check_user->fetch_assoc();
// 	$check_username = $check_user->num_rows;
// 	if ($check_username == 0) {
// 		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Dilarang Mengakses');    
// 		exit(header("Location: ".$config['web']['url']));
// 	}    
// 	$sess_username = $_SESSION['user']['username'];
// }