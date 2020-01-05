<?php
require_once '../../config/config.php';

$id_produk = $_POST['id_produk'];
$id_kategori = $_POST['id_kategori'];
$nama = $_POST['nama_produk'];
$ukuran = $_POST['ukuran'];
$harga = $_POST['harga_produk'];
$stok = $_POST['stok_produk'];
$deskripsi = $_POST['deskripsi'];
$query = mysqli_query($con, "INSERT INTO tbl_produk VALUES('$id_produk','$id_kategori',
                        '$nama','$ukuran','$harga','$stok','$deskripsi')");
