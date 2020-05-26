<?php  

session_start();

//Load file config
require '../../../config.php';
require '../../lib/session_main_admin.php';

$pdf = new FPDF('L','mm','A4');

// Simple table
function BasicTable($data, $pdf, $field, $lokasi, $admin)
{
	$pdf->SetFont('Arial','',12);

	$pdf->SetFont('Arial','',12);
	$pdf->ln();

	foreach ($lokasi as $keyLokasi => $valueLokasi) {
		$pdf->Cell(40,7,'Lokasi');
		$pdf->Cell(50,7,': '.$keyLokasi);
		$pdf->ln();
		$pdf->Cell(40,7,'Nama');
		$pdf->Cell(50,7,': '.$admin[$keyLokasi]);
		$pdf->ln();
		foreach ($field as $value) {
			if($value != 'NamaAdmin' && $value != 'KodeLokasi'){
				if($value == 'AsalKantor'){
					$pdf->Cell(110,7,'Asal Kantor',1, 0, 'C');
				}elseif($value == 'KodePesan'){
					$pdf->Cell(38,7,'Kode Pesan',1, 0, 'C');
				}elseif($value == 'NamaTamu'){
					$pdf->Cell(38,7,'Nama Tamu',1, 0, 'C');
				}elseif($value == 'TanggalBayar'){
					$pdf->Cell(38,7,'Tanggal Bayar',1, 0, 'C');
				}elseif($value == 'TotalBayar'){
					$pdf->Cell(38,7,'Total Bayar',1, 0, 'C');
				}else{
					$pdf->Cell(38,7,$value,1, 0, 'C');
				}
			}
		}

		$pdf->Ln();
		$sum = 0;
		foreach ($data[$keyLokasi] as $key => $row) {
			foreach ($field as $f) {
				if($f != 'NamaAdmin' && $f != 'KodeLokasi'){
					if($f != 'TotalBayar'){	
						
						if($f == 'AsalKantor'){
							$pdf->Cell(110,7,$row[$f],1);
						}elseif($f == 'TanggalBayar'){
							$pdf->Cell(38,7,date('d M Y', strtotime($row[$f])),1);
						}else{
							$pdf->Cell(38,7,$row[$f],1);
						}
					}else{
						$sum += $row[$f];
						$pdf->Cell(38,7,numberFormat($row[$f]),1);
						$pdf->Ln();
					}
				}
			}
		}


		$pdf->Cell(224,7,'SUBTOTAL',1,0, 'C');
		$pdf->Cell(38,7,numberFormat($sum),1,0);

		$pdf->ln();
		$pdf->ln();
	}
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
		$data = $connect->query("SELECT r.kd_reservasi as KodePesan, t.nama_t as NamaTamu, t.asal_kantor as AsalKantor, p.tgl_bayar as TanggalBayar, r.total_bayar as TotalBayar, adm.nama as NamaAdmin, l.kota as KodeLokasi FROM reservasi r JOIN pembayaran p ON r.kd_reservasi=p.kd_reservasi JOIN tamu t ON t.kd_tamu=r.kd_tamu JOIN admin adm ON adm.kd_admin=r.kd_admin JOIN lokasi l ON adm.kd_lokasi=l.kd_lokasi WHERE tgl_transaksi BETWEEN '".date('Y-m-d', strtotime($_POST['dateFrom']))."' AND '".date('Y-m-d', strtotime($_POST['dateTo']))."' ORDER BY tgl_transaksi desc");

		if($data->num_rows > 0){

			while($row = $data->fetch_assoc()){
				$dataIsi[$row['KodeLokasi']][] = $row;
				$stackLokasi[$row['KodeLokasi']] = $row['KodeLokasi'];
				$stackNama[$row['KodeLokasi']] = $row['NamaAdmin'];
			}

			foreach ($dataIsi as $row) {
				foreach ($row as $fie) {
					$field = array_keys($fie);
				}
			}


			$pdf->Ln();

			BasicTable($dataIsi, $pdf, $field, $stackLokasi, $stackNama);
			$pdf->Output('report.pdf', 'i');
		}else{
			header("Location: ".base_url()."main-admin/manage-report");
			set_flashdata('message', 'data tidak ditemukan!');
			die();
		}

	}else{
		header("Location: ".base_url()."main-admin/manage-report");
		set_flashdata('message', 'pilih tanggal dengan benar! date from harus lebih kecil dari date to!');
		die();
	}
}else{
	header("Location: ".base_url()."main-admin/manage-report");
	set_flashdata('message', 'pilih tanggal dengan benar!');
	die();
}

?>