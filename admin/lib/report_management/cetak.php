<?php  

session_start();

//Load file config
require '../../../config.php';
require '../../lib/session_admin.php';

$pdf = new FPDF('L','mm','A4');

// Simple table
function BasicTable($data, $pdf, $field, $namaAdmin, $lokasi)
{
	$pdf->SetFont('Arial','',12);

	$pdf->SetFont('Arial','',12);
	$pdf->ln();
	$pdf->Cell(40,7,'Lokasi');
	$pdf->Cell(50,7,': '.$lokasi);
	$pdf->ln();
	$pdf->Cell(40,7,'Nama');
	$pdf->Cell(50,7,': '.$namaAdmin);
	$pdf->ln();

	foreach ($field as $value) {
		if($value != 'NamaAdmin' && $value != 'KodeLokasi'){
			if($value == 'AsalKantor'){
				$pdf->Cell(110,7,$value,1);
			} else {
				$pdf->Cell(38,7,$value,1);
			}
		}
	}

	$pdf->Ln();

	$sum = 0;
	foreach ($data as $row) {
		foreach($row as $key => $value){
			if($key != 'NamaAdmin' && $key != 'KodeLokasi'){
				if($key != 'TotalBayar'){	
					if($key == 'AsalKantor'){
						$pdf->Cell(110,7,$value,1);
					}elseif($key == 'TanggalBayar'){
						$pdf->Cell(38,7,date('d M Y', strtotime($value)),1);
					}else{
						$pdf->Cell(38,7,$value,1);
					}
				}else{
					$sum += $value;
					$pdf->Cell(38,7,numberFormat($value),1);
					$pdf->Ln();
				}
			}
		}
	}
	$pdf->Cell(224,7,'SUBTOTAL',1,0, 'C');
	$pdf->Cell(38,7,numberFormat($sum),1,0);
}

if(isset($_POST['submit'])){
	if($_POST['dateFrom'] != '' && $_POST['dateTo'] != ''){
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',13);
		$pdf->ln();
		$pdf->Cell(0,10,'BADAN PENGHUBUNG DAERAH SULAWESI SELATAN',0,0,'C');
		$pdf->ln();
		$pdf->Cell(0,10,'LAPORAN PENDAPATAN SEWA PENGINAPAN',0,0,'C');
		$pdf->ln();
		$pdf->Cell(0,10,'PERIODE BULAN '.strtoupper(date('M', strtotime($_POST['dateFrom']))).' - '.strtoupper(date('M', strtotime($_POST['dateTo']))).' TAHUN '.date('Y', strtotime($_POST['dateFrom'])).'',0,0,'C');
		$data = $connect->query("SELECT r.kd_reservasi as KodePesan, t.nama_t as NamaTamu, t.asal_kantor as AsalKantor, p.tgl_bayar as TanggalBayar, r.total_bayar as TotalBayar, adm.nama as NamaAdmin, l.kota as KodeLokasi FROM reservasi r JOIN pembayaran p ON r.kd_reservasi=p.kd_reservasi JOIN tamu t ON t.kd_tamu=r.kd_tamu JOIN admin adm ON adm.kd_admin=r.kd_admin JOIN lokasi l ON adm.kd_lokasi=l.kd_lokasi WHERE r.kd_admin='".$_SESSION['admin']['kd_admin']."' AND tgl_transaksi BETWEEN '".date('Y-m-d', strtotime($_POST['dateFrom']))."' AND '".date('Y-m-d', strtotime($_POST['dateTo']))."' ORDER BY tgl_transaksi desc");

		if($data->num_rows > 0){

			while($row = $data->fetch_assoc()){
				$dataIsi[] = $row;
				$namaAdmin = $row['NamaAdmin'];
				$lokasi = $row['KodeLokasi'];
			}

			$field = array_keys($dataIsi[0]);

			$pdf->Ln();

			BasicTable($dataIsi, $pdf, $field, $namaAdmin, $lokasi);
			$pdf->Output('report.pdf', 'i');
		}else{
			header("Location: ".base_url()."admin/manage-report");
			set_flashdata('message', 'data tidak ditemukan!');
			die();
		}

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
// }else{
// 	header("Location: ".base_url()."admin/manage-report");
// 	set_flashdata('message', 'something wrong! silahkan coba lagi!');
// 	die();
// }

?>