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
            <h4 class="mt-5 p-5 text-center">Edit Password Pelanggan</h4>

            <form method="POST">
                <input type="hidden" class="form-control" name="id" value="<?= $_SESSION["pelanggan"]["id_pelanggan"] ?>">
                <div class="form-group">
                    <label for="passlama">Password Lama</label>
                    <input type="password" class="form-control" name="passlama">
                </div>
                <div class="form-group">
                    <label for="passbaru">Password Baru</label>
                    <input type="password" class="form-control" name="passbaru">
                </div>
                <div class="form-group">
                    <label for="confirmpass">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" name="confirmpass">
                </div>
                <button class="btn btn-primary" name="simpan">Simpan</button>
            </form>
        </div>
    </section>

    <?php
    if (isset($_POST["simpan"])) {

        $id = $_POST["id"];
        $passlama = $_POST["passlama"];
        $passbaru = $_POST["passbaru"];
        $confirmpass = $_POST["confirmpass"];

        //cek pass lama
        $query = mysqli_query($con, "SELECT * FROM tbl_pelanggan WHERE id_pelanggan='$id'
                AND password_pelanggan='$passlama'");
        $hasil = mysqli_num_rows($query);
        if(!$hasil >= 1)
        {
            echo "<script>alert('Password lama tidak sesuai!, silahkan ulang kembali!');</script>";
        }
        elseif(empty($_POST['passbaru'])||empty($_POST['confirmpass']))
        {
            echo "<script>alert('Ganti Password Gagal! Data tidak boleh kosong');</script>";
        } 
        elseif (($_POST['passbaru']) != ($_POST['confirmpass']))
        {
            echo "<script>alert('Ganti Password Gagal! Password dan Konfirm Password Harus Sama');</script>";
        }
        else
        {
            $query = mysqli_query($con, "UPDATE tbl_pelanggan SET password_pelanggan='$passbaru' WHERE id_pelanggan='$id'");
            if($query)
            {
                echo "<script>alert('Edit Data Berhasil');</script>";
                echo "<script>location='index.php';</script>";
                exit();
            }
            else
            {
                echo "ERROR, tidak berhasil" . mysqli_error($con);
            }
        }
    }
    ?>


    <?php include "footer.php" ?>

</body>

</html>