<?php

require_once "admin/config/config.php";

if (!isset($_SESSION["pelanggan"]) or empty($_SESSION["pelanggan"])) {
    echo "<script>alert('Silahkan login');</script>";
    echo "<script>location='login.php';</script>";
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
            <h4 class="mt-5 p-5 text-center">Riwayat Belanja <?= $_SESSION["pelanggan"]["nama_pelanggan"] ?></h4>
            <table class="table table-bordered">
                <thead class="bg-secondary">
                    <tr class="text-center">
                        <th scope="col">No</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                        <th scope="col">Total</th>
                        <th scope="col">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomor = 1;

                    $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
                    $ambil = mysqli_query($con, "SELECT * FROM tbl_pembelian WHERE id_pelanggan ='$id_pelanggan'");
                    while ($data = $ambil->fetch_assoc()) {
                    ?>
                        <tr class="text-center">
                            <td><?= $nomor; ?></td>
                            <td><?= $data["tanggal_pembelian"]; ?></td>
                            <td>
                                <?= $data["status_pembelian"]; ?>
                                <br>
                                <?php if (!empty($data['resi_pengiriman'])) : ?>
                                    Resi: <?= $data['resi_pengiriman']; ?>
                                <?php endif ?>
                            </td>
                            <td>Rp. <?= number_format($data["total_pembelian"]); ?></td>
                            <td>
                                <a href="nota.php?id=<?= $data["id_pembelian"]; ?>" class="btn btn-info">Nota</a>
                                <?php if ($data['status_pembelian'] == "pending") : ?>
                                    <a href="pembayaran.php?id=<?= $data["id_pembelian"]; ?>" class="btn btn-success">Pembayaran</a>
                                <?php else : ?>
                                    <a href="lihat_pembayaran.php?id=<?= $data["id_pembelian"]; ?>" class="btn btn-warning">Lihat Pembayaran</a>
                                <?php endif ?>
                            </td>
                        </tr>
                        <?php $nomor++; ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>


    <?php include "footer.php" ?>

</body>

</html>