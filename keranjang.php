<?php

require_once "admin/config/config.php";

if (empty($_SESSION["keranjang"]) or !isset($_SESSION["keranjang"])) {
    echo "<script>alert('Keranjang kosong, silahkan belanja dulu!');</script>";
    echo "<script>location='index.php';</script>";
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
        <div class="container keranjang">
            <h4 class="mt-5 p-5 text-center">KERANJANG BELANJA</h4>
            <table class="table table-bordered">
                <thead class="bg-secondary">
                    <tr class="text-center">
                        <th scope="col">No</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Berat</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Subharga</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($_SESSION["keranjang"] as $id_galeri => $jumlah) : ?>
                        <?php
                            $ambil = $con->query("SELECT tbl_galeri.*, tbl_produk.* FROM tbl_galeri 
                        INNER JOIN tbl_produk ON tbl_galeri.id_produk = tbl_produk.id_produk
                        WHERE id_galeri='$id_galeri'");
                            $data = $ambil->fetch_assoc();
                            $subharga = $data['harga_produk'] * $jumlah;
                            @$total  = $total + $subharga;
                            ?>
                        <tr class="text-center">
                            <td><?= $no; ?></td>
                            <td><?= $data['nama_produk']; ?></td>
                            <td><img src="admin/uploads/galeri_parfum/<?= $data['foto_produk']; ?>" alt="Foto Produk" width="75px" height="75px"></td>
                            <td><?= $data['ukuran']; ?> ML</td>
                            <td><?= $jumlah; ?></td>
                            <td>Rp. <?= number_format($data['harga_produk']); ?></td>
                            <td>Rp. <?= number_format($subharga) ?></td>
                            <td>
                                <a href="hapus_keranjang.php?id=<?= $id_galeri ?>" class="fas fa-trash text-danger" title="Delete"></a>
                            </td>
                        </tr>
                        <?php $no++; ?>
                    <?php endforeach ?>
                    <tr>
                        <th scope="row" colspan="6" rowspan="1" class="text-left">Total Belanja</th>
                        <th class="text-center" colspan="2">Rp. <?= number_format($total) ?></th>
                    </tr>
                </tbody>
            </table>
            <div>
                <a href="index.php" class="btn btn-light btn-md">Lanjutkan Belanja</a>
                <a href="checkout.php" class="btn btn-primary btn-md">Checkout</a>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white p-5 mt-5 ">
        <div class="row">
            <div class="col-md-3">
                <h5>LAYANAN PELANGGAN</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white">Pusat Bantuan</a></li>
                    <li><a href="#" class="text-white">Cara Pembelian</a></li>
                    <li><a href="#" class="text-white">Pengiriman</a></li>
                    <li><a href="#" class="text-white">Pusat Bantuan</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>SOCIAL MEDIA</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white"><i class="fab fa-instagram"></i> gerai_parfumeYK</a></li>
                    <li><a href="#" class="text-white"><i class="fab fa-facebook-square"></i> Gerai Parfume</a></li>
                    <li><a href="#" class="text-white"><i class="fab fa-twitter-square"></i> Gerai_ParfumeYK</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>HUBUNGI KAMI</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white"><i class="fas fa-phone"></i> 0821-2222-8888</a></li>
                    <li><a href="#" class="text-white"><i class="fab fa-whatsapp"></i> 0867-2222-1111</a></li>
                    <li><a href="#" class="text-white"><i class="fab fa-line"></i> gerai_parfume</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>JAM OPERASIONAL</h5>
                <table class="trip-informations">
                    <tr>
                        <td width="50%">Senin-Jumat</td>
                        <td width="50%" class="text-right">
                            : 08.00 - 21.00
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">Sabtu</td>
                        <td width="50%" class="text-right">
                            : 08:00 - 18:00
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">Minggu</td>
                        <td width="50%" class="text-right">
                            : 10:00 - 18:00
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">Hari Libur</td>
                        <td width="50%" class="text-right">
                            : 08:00 - 21:00
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>

    <div class="copyright text-center text-white font-weight-bold bg-dark p-5">
        <p>Developed by Parfum Shop Copyright <i class="far fa-copyright"></i> 2019</p>
    </div>


    <?php include "footer.php" ?>

</body>

</html>