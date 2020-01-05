<?php

require_once "admin/config/config.php";

$id_galeri = $_GET["id"];

if (isset($_POST["beli"]))
{
    $quantity = $_POST["jumlah"];
    $_SESSION["keranjang"]["$id_galeri"] = $quantity;
}

// if (isset($_SESSION['keranjang'][$id_galeri])) {
//     $_SESSION['keranjang'][$id_galeri] += 1;
// } else {
//     $_SESSION['keranjang'][$id_galeri] = 1;
// }

echo "<script>alert('produk telah masuk ke keranjang belanja')</script>";
echo "<script>location='keranjang.php';</script>";
