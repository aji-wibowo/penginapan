<?php
require 'config.php';

$connect->query("UPDATE kamar k SET k.status = 0 WHERE k.status = 1 AND DATE((select cekout from reservasi r where r.kd_kamar=k.kd_kamar limit 1)) <= NOW()");

?>
Welcomeh <a href="<?=base_url()?>user/login/">Login</a> | <a href="<?=base_url()?>user/register/">Register</a>