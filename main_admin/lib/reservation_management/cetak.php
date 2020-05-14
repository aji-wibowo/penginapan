<?php  

session_start();

//Load file config
require '../../../config.php';
require '../../lib/session_main_admin.php';

$pdf = new FPDF('L','mm','A4');

// Simple table
function BasicTable($data, $pdf, $field)
{
	$pdf->SetFont('Arial','',12);
	foreach ($field as $value) {
		if($value == 'AsalKantor'){
			$pdf->Cell(80,7,'Asal Kantor',1);
		}else{
			$pdf->Cell(38,7,$value,1);
		}
	}

	$pdf->Ln();

	foreach ($data as $row) {
		foreach($row as $key => $value){
			if($key != 'statusBayar'){	
				if($key == 'AsalKantor'){
					$pdf->Cell(80,7,$value,1);
				}else{
					$pdf->Cell(38,7,$value,1);
				}
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
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,10,'BADAN PENGHUBUNG DAERAH SULAWESI SELATAN',0,0,'C');
			$pdf->ln();
			$pdf->Cell(0,10,'REKAPITULASI RESERVASI PENGINAPAN',0,0,'C');
			$pdf->ln();
			$pdf->Cell(0,10,'PERIODE BULAN '.strtoupper(date('M', strtotime($_POST['dateFrom']))).' - '.strtoupper(date('M', strtotime($_POST['dateTo']))).' TAHUN '.date('Y', strtotime($_POST['dateFrom'])).'',0,0,'C');
			$pdf->ln();
			$data = $connect->query("SELECT r.kd_reservasi as KodePesan, r.cekin as checkin, r.cekout as checkout, t.nama_t as NamaTamu, t.asal_kantor as AsalKantor,p.status as statusBayar FROM reservasi r JOIN pembayaran p ON r.kd_reservasi=p.kd_reservasi JOIN tamu t ON t.kd_tamu=r.kd_tamu WHERE tgl_transaksi BETWEEN '".date('Y-m-d', strtotime($_POST['dateFrom']))."' AND '".date('Y-m-d', strtotime($_POST['dateTo']))."' ORDER BY tgl_transaksi desc");

			if($data->num_rows > 0){
				while($row = $data->fetch_assoc()){
					$dataIsi[] = $row;
				}

				$field = array_keys($dataIsi[0]);

				$pdf->Ln();

				BasicTable($dataIsi, $pdf, $field);
				$pdf->Output('report.pdf', 'i');
			}else{
				header("Location: ".base_url()."admin/manage-reservations");
				set_flashdata('message', 'data tidak ditemukan!');
				die();
			}
		}else{
			header("Location: ".base_url()."admin/manage-reservations");
			set_flashdata('message', 'pilih tanggal dengan benar! date from harus lebih kecil dari date to!');
			die();
		}
	}else{
		header("Location: ".base_url()."admin/manage-reservations");
		set_flashdata('message', 'pilih tanggal dengan benar!');
		die();
	}
}else{
	header("Location: ".base_url()."admin/manage-reservations");
	set_flashdata('message', 'something wrong! silahkan coba lagi!');
	die();
}

?>