<?php

require_once "admin/config/config.php";

if (!isset($_SESSION["pelanggan"]) or empty($_SESSION["pelanggan"])) {
    echo "<script>alert('Silahkan login');</script>";
    echo "<script>location='login.php';</script>";
    exit();
}


$idpem = $_GET["id"];
$ambil = mysqli_query($con, "SELECT * FROM tbl_pembelian WHERE id_pembelian='$idpem'");
$detpem = $ambil->fetch_assoc();

$id_pelanggan_beli = $detpem["id_pelanggan"];
$id_pelanggan_login = $_SESSION["pelanggan"]["id_pelanggan"];

if ($id_pelanggan_login !== $id_pelanggan_beli) {
    echo "<script>alert('Maaf ini bukan pembelian anda');</script>";
    echo "<script>location='riwayat.php';</script>";
    exit();
}

?>
<?php
$carikode = mysqli_query($con, "SELECT id_pembayaran from tbl_pembayaran") or die(mysqli_error($con));
$datakode = mysqli_fetch_array($carikode);
$jumlah_data = mysqli_num_rows($carikode);
if ($datakode) {
    $nilaikode = substr($jumlah_data[0], 1);
    $kode = (int) $nilaikode;
    $kode = $jumlah_data + 1;
    $kode_otomatis = str_pad($kode, 1, STR_PAD_LEFT);
} else {
    $kode_otomatis = "1";
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
            <h4 class="mt-5 p-5 text-center">Konfirmasi Pembayaran</h4>
            <p>Kirim bukti pembayaran Anda disini</p>
            <div class="alert alert-info">
                Total pembayaran Anda <strong>Rp. <?= number_format($detpem["total_pembelian"]); ?></strong>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" class="form-control" value="<?= $kode_otomatis; ?>" name="id">
                <div class="form-group">
                    <label for="nama">Nama Penyetor</label>
                    <input type="text" class="form-control" name="nama">
                </div>
                <div class="form-group">
                    <label for="bank">Bank</label>
                    <input type="text" class="form-control" name="bank">
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" class="form-control" name="jumlah" min="1">
                </div>
                <div class="form-group">
                    <label for="bukti">Foto Bukti</label>
                    <input type="file" class="form-control" name="bukti">
                    <p class="text-danger">Foto bukti harus JPG/PNG/JPEG maksimal 2MB</p>
                </div>
                <button class="btn btn-primary" name="kirim">Kirim</button>
            </form>
        </div>
    </section>

    <?php
    if (isset($_POST["kirim"]))
    {

        $namabukti = $_FILES["bukti"]["name"];
        $lokasibukti = $_FILES["bukti"]["tmp_name"];
        $namafiks = date("YmdHis").$namabukti;
        move_uploaded_file($lokasibukti, "bukti_pembayaran/$namafiks");

        $id = $_POST["id"];
        $nama = $_POST["nama"];
        $bank = $_POST["bank"];
        $jumlah = $_POST["jumlah"];
        $tanggal = date("Y-m-d");

        mysqli_query($con, "INSERT INTO tbl_pembayaran(id_pembayaran,id_pembelian,nama,bank,jumlah,tanggal,bukti)
        VALUES ('$id','$idpem','$nama','$bank','$jumlah','$tanggal','$namafiks')");

        mysqli_query($con, "UPDATE tbl_pembelian SET status_pembelian='sudah kirim pembayaran' 
        WHERE id_pembelian='$idpem'");

        echo "<script>alert('Terimakasih sudah mengirim bukti pembayaran');</script>";
        echo "<script>location='riwayat.php';</script>";
        exit();
    }
    ?>


    <?php include "footer.php" ?>

</body>

</html>