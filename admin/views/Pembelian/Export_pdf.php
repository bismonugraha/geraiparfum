<?php
require('../../phpfpdf/fpdf.php'); {
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
}
include '../../config/config.php';

$tgl_mulai = $_POST["tglm"];
$tgl_selesai = $_POST["tgls"];


$pdf = new FPDF('P', 'cm', 'A4');
$pdf->AddPage();
// Header
$pdf->SetFont('Times', 'B', 14);
$pdf->MultiCell(19.5, 1, 'Laporan Penjualan Produk', 0, 'C');
$pdf->SetX(2.8);
$pdf->SetFont('Times', '', 10);
$pdf->MultiCell(15.5, 0.5, 'Jl Magelang Km 4,5 (Sebelah SPBU Sinduadi), Mlati Sleman, DI Yogyakarta 55284, Indonesia', 0, 'C');
$pdf->SetX(2.8);
$pdf->MultiCell(15.5, 0.3, 'Kontak: 081239982938', 0, 'C');

$pdf->Line(0.5, 3.8, 20.5, 3.8);
$pdf->SetLineWidth(0.1);
$pdf->Line(0.5, 3.9, 20.5, 3.9);
$pdf->SetLineWidth(0.1);
$pdf->Ln();
// End header
// Format Tanggal
$pdf->SetFont('Times', 'B', 8);
$pdf->SetLineWidth(0);
$pdf->Cell(1.5, 1, "Printed By : " . $_SESSION['nama'], 0, 0, 'C');

$pdf->SetFont('Times', 'B', 8);
$pdf->SetLineWidth(0);
$pdf->Cell(31.5, 1, "Printed On : " . date("D-d/m/Y H:i:s"), 0, 0, 'C');
$pdf->Ln();
// periode
$pdf->SetFont('Times', 'B', 8);
$pdf->SetLineWidth(0);
$pdf->Cell(5.1, 1, "TANGGAL : " . $tgl_mulai .  " s/d "  . $tgl_selesai, 0, 0, 'C');
// Tabel
$pdf->SetFont('Times', 'B', 8);
$pdf->SetLineWidth(0);
$pdf->Cell(0.5, 1, '', 0, 1);
$pdf->Cell(0.8, 1, 'NO', 1, 0, 'C');
$pdf->Cell(5, 1, 'NAMA PELANGGAN', 1, 0, 'C');
$pdf->Cell(7, 1, 'TANGGAL', 1, 0, 'C');
$pdf->Cell(2.8, 1, 'JUMLAH', 1, 0, 'C');
$pdf->Cell(3.5, 1, 'STATUS', 1, 1, 'C');

// Isi Data di tabel
$query = mysqli_query($con, "SELECT * FROM tbl_pembelian pm LEFT JOIN tbl_pelanggan pl
    ON pm.id_pelanggan=pl.id_pelanggan WHERE tanggal_pembelian BETWEEN '$tgl_mulai' AND '$tgl_selesai' AND status_pembelian='sukses' ");
$total = 0;
$no = 1;
while ($row = mysqli_fetch_array($query)) {
    $total += $row['total_pembelian'];
    $pdf->SetFont('Times', '', 8);
    $pdf->Cell(0.8, 1, $no++, 1, 0, 'C');
    $pdf->Cell(5, 1, $row['nama_pelanggan'], 1, 0, 'C');
    $pdf->Cell(7, 1, $row['tanggal_pembelian'], 1, 0, 'C');
    $pdf->Cell(2.8, 1, "Rp." . number_format($row['total_pembelian']), 1, 0, 'C');
    $pdf->Cell(3.5, 1, $row['status_pembelian'], 1, 1, 'C');
}
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(19.1, 1, "Total Rp. " . number_format($total), 1, 1, 'C');

$pdf->SetFont('Times', 'B', 8);
$pdf->SetLineWidth(0);
$pdf->Cell(32.5, 1, "Yogyakarta, ................................................", 0, 0, 'C');
$pdf->Ln();

$pdf->SetFont('Times', 'B', 8);
$pdf->SetLineWidth(0);
$pdf->Cell(32.5, 5, "(Manager)", 0, 0, 'C');
$pdf->Ln();
$pdf->Output();
