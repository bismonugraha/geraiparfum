<?php

require_once "admin/config/config.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="frontend/libraries/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="frontend/libraries/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="frontend/styles/main.css">
</head>

<body>

    <?php include "menu.php"; ?>

    <div class="container-fluid">
        <div class="row justify-content-md-center p-5">
            <div class="col-md-5">
                <div class="card shadow mt-5">
                    <div class="card-header ">
                        <h3 class="panel-title text-center">Login Pelanggan</h3>
                    </div>
                    <div class="panel-body p-2">
                        <form method="POST">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="form-group">
                                <label for="pass">Password</label>
                                <input type="password" class="form-control" name="pass">
                            </div>
                            <button type="submit" class="btn btn-primary float-right" name="masuk">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST["masuk"])) {
        $email = $_POST['email'];
        $password = $_POST['pass'];

        $ambil = mysqli_query($con, "SELECT * FROM tbl_pelanggan WHERE email_pelanggan='$email'
            AND password_pelanggan='$password'");

        $cocok = $ambil->num_rows;

        if ($cocok == 1) {
            $akun = $ambil->fetch_assoc();
            $_SESSION["pelanggan"] = $akun;
            echo "<script>alert('anda sukses login')</script>";

            if (isset($_SESSION["keranjang"]) OR !empty($_SESSION["keranjang"]))
            {
                echo "<script>location='checkout.php';</script>";
            }
            else
            {
                echo "<script>location='riwayat.php';</script>";
            }
        } else {
            echo "<script>alert('anda gagal login, periksa akun anda')</script>";
            echo "<script>location='login.php';</script>";
        }
    }
    ?>

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

    <div class="copyright text-center text-white font-weight-bold bg-dark p-3">
        <p>Developed by Parfum Shop Copyright <i class="far fa-copyright"></i> 2019</p>
    </div>


    <?php include "footer.php" ?>

</body>

</html>