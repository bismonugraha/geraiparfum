<?php
require_once '../../config/config.php';
$id_galeri      = $_POST['id_galeri'];
$id_produk      = $_POST['id_produk'];
$target         = "../../uploads/galeri_parfum/";
$nama_gambar    = $_FILES['foto_produk']['name'];
$sumber         = $_FILES['foto_produk']['tmp_name'];

move_uploaded_file($sumber, $target . $nama_gambar);
mysqli_query($con, "INSERT INTO tbl_galeri VALUES('$id_galeri','$id_produk','$nama_gambar')");
