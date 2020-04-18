<?php  

session_start();

//Load file config
require '../../../config.php';
require '../../lib/session_admin.php';

$pdf = new FPDF('P','mm','A4');

// Simple table
function BasicTable($data, $pdf, $field)
{
	$pdf->SetFont('Arial','',12);
	foreach ($field as $value) {
		$pdf->Cell(38,7,$value,1);
	}

	$pdf->Ln();

	foreach ($data as $row) {
		foreach($row as $key => $value){
			if($key != 'statusBayar'){	
				$pdf->Cell(38,7,$value,1);
			}else{
				$pdf->Cell(38,7,$value,1);
				$pdf->Ln();
			}
		}
	}
}

if(isset($_POST['submit'])){
	if($_POST['dateFrom'] != '' && $_POST['dateTo'] != ''){
		if(strtotime($_POST['dateFrom']) < strtotime($_POST['dateTo'])){
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',17);
			$pdf->Cell(40,10,'Laporan Transaksi per '.date('d M y', strtotime($_POST['dateFrom'])).' s/d '.date('d M y', strtotime($_POST['dateTo'])).'');
			$data = $connect->query("SELECT r.kd_reservasi as KodePesan, r.cekin as checkin, r.cekout as checkout, t.nama_t as NamaTamu, p.status as statusBayar FROM reservasi r JOIN pembayaran p ON r.kd_reservasi=p.kd_reservasi JOIN tamu t ON t.kd_tamu=r.kd_tamu WHERE kd_admin='".$_SESSION['admin']['kd_admin']."' AND tgl_transaksi BETWEEN '".date('Y-m-d', strtotime($_POST['dateFrom']))."' AND '".date('Y-m-d', strtotime($_POST['dateTo']))."' ORDER BY tgl_transaksi desc");

			while($row = $data->fetch_assoc()){
				$dataIsi[] = $row;
			}

			$field = array_keys($dataIsi[0]);

			$pdf->Ln();

			BasicTable($dataIsi, $pdf, $field);
			$pdf->Output('report.pdf', 'D');
		}else{
			header("Location: ".base_url()."admin/manage-report");
			set_flashdata('message', 'pilih tanggal dengan benar! date from harus lebih kecil dari date to!');
			die();
		}
	}else{
		header("Location: ".base_url()."admin/manage-report");
		set_flashdata('message', 'pilih tanggal dengan benar!');
		die();
	}
}else{
	header("Location: ".base_url()."admin/manage-report");
	set_flashdata('message', 'something wrong! silahkan coba lagi!');
	die();
}

?>