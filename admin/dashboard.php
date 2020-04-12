<?php
$page = "Dashboard Admin";
session_start();
require 'layout/header_dashboard.php';
require 'lib/session_admin.php';
?>
<h1>Ini halaman admin</h1>
<a href="<?=base_url()?>admin/logout.php">Keluar</a>