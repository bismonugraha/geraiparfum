<?php
require_once '../../config/config.php';

$id_produk = $_POST['id_produk'];
$id_kategori = $_POST['id_kategori'];
$nama = $_POST['nama_produk'];
$ukuran = $_POST['ukuran'];
$harga = $_POST['harga_produk'];
$stok = $_POST['stok_produk'];
$deskripsi = $_POST['deskripsi'];
$query = mysqli_query($con, "UPDATE tbl_produk SET id_kategori = '$id_kategori', nama_produk = '$nama', ukuran = '$ukuran', 
                    harga_produk = '$harga', stok_produk = '$stok', deskripsi = '$deskripsi' WHERE id_produk = '$id_produk'");
