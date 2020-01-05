<?php

require_once "admin/config/config.php";
$id_galeri = $_GET["id"];
unset ($_SESSION["keranjang"][$id_galeri]);

echo "<script>alert('Produk dihapus dari keranjang');</script>";
echo "<script>location='keranjang.php';</script>";
?>