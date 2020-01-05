<?php
require_once '../../config/config.php';

$id_galeri      = $_POST['id_galeri'];
$id_produk      = $_POST['id_produk'];
$target         = "../../uploads/galeri_parfum/";
$nama_gambar    = $_FILES['foto_produk']['name'];
$sumber         = $_FILES['foto_produk']['tmp_name'];
move_uploaded_file($sumber, $target . $nama_gambar);
$query = mysqli_query($con, "UPDATE tbl_galeri SET id_produk = '$id_produk', foto_produk = '$nama_gambar' WHERE id_galeri = '$id_galeri'");
