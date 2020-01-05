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
            <h4 class="mt-5 p-5 text-center">Edit Akun Pelanggan</h4>

            <form method="POST">
                <input type="hidden" class="form-control" name="id" value="<?= $_SESSION["pelanggan"]["id_pelanggan"] ?>">
                <div class="form-group">
                    <label for="nama">Nama Pelanggan</label>
                    <input type="text" class="form-control" name="nama" value="<?= $_SESSION["pelanggan"]["nama_pelanggan"] ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email Pelanggan</label>
                    <input type="email" class="form-control" name="email" value="<?= $_SESSION["pelanggan"]["email_pelanggan"] ?>">
                </div>
                <div class="form-group">
                    <label for="tlp">No Telepon/Hp</label>
                    <input type="text" class="form-control" name="telp" value="<?= $_SESSION["pelanggan"]["telepon_pelanggan"] ?>">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" name="alamat" value="<?= $_SESSION["pelanggan"]["alamat_pelanggan"] ?>">
                </div>
                <button class="btn btn-primary" name="simpan">Simpan</button>
            </form>
        </div>
    </section>

    <?php
    if (isset($_POST["simpan"])) {

        $id = $_POST["id"];
        $nama = $_POST["nama"];
        $email = $_POST["email"];
        $telp = $_POST["telp"];
        $alamat = $_POST["alamat"];

        mysqli_query($con, "UPDATE tbl_pelanggan SET nama_pelanggan='$nama', email_pelanggan='$email', 
        telepon_pelanggan='$telp', alamat_pelanggan='$alamat' WHERE id_pelanggan='$id'");

        echo "<script>alert('Edit Data Berhasil');</script>";
        echo "<script>location='index.php';</script>";
        exit();
    }
    ?>


    <?php include "footer.php" ?>

</body>

</html>