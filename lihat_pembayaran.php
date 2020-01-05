<?php

require_once "admin/config/config.php";

if (!isset($_SESSION["pelanggan"]) or empty($_SESSION["pelanggan"])) {
    echo "<script>alert('Silahkan login');</script>";
    echo "<script>location='login.php';</script>";
    exit();
}
?>

<?php
$id_pembelian = $_GET["id"];

$ambil = mysqli_query($con, "SELECT * FROM tbl_pembayaran LEFT JOIN 
tbl_pembelian ON tbl_pembayaran.id_pembelian=tbl_pembelian.id_pembelian WHERE 
tbl_pembelian.id_pembelian='$id_pembelian'");
$detail = $ambil->fetch_assoc();

if (empty($detail))
{
    echo "<script>alert('belum ada data pembayaran')</script>";
    echo "<script>location='riwayat.php';</script>";
}

if ($_SESSION["pelanggan"]["id_pelanggan"] !== $detail["id_pelanggan"])
{
    echo "<script>alert('anda tidak berhak meelihat pembayaran orang lain!')</script>";
    echo "<script>location='riwayat.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Toko Parfum</title>
    <link rel="stylesheet" href="frontend/libraries/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="frontend/libraries/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="frontend/styles/main.css">
</head>

<body>
    <?php include "menu.php"; ?>
    <section>
        <div class="container">
            <h4 class="mt-5 p-5 text-center"></h4>

            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <tr>
                                <th>Nama</th>
                                <td><?= $detail["nama"] ?></td>
                            </tr>
                            <tr>
                                <th>Bank</th>
                                <td><?= $detail["bank"] ?></td>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <td>Rp. <?= number_format($detail["jumlah"]); ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td><?= $detail["tanggal"] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="bukti_pembayaran/<?= $detail['bukti']; ?>" width="550px" height="350px">
                </div>
            </div>
        </div>
    </section>


    <?php include "footer.php" ?>

</body>

</html>