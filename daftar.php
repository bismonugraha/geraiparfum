<?php
require_once "admin/config/config.php";
?>
<?php
$carikode = mysqli_query($con, "SELECT id_pelanggan from tbl_pelanggan") or die(mysqli_error($con));
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
    <title>Daftar</title>
    <link rel="stylesheet" href="frontend/libraries/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="frontend/libraries/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="frontend/styles/main.css">
</head>

<body>

    <?php include "menu.php"; ?>

    <div class="container-fluid">
        <div class="row justify-content-md-center p-5">
            <div class="col-md-6">
                <div class="card shadow mt-5">
                    <div class="card-header ">
                        <h3 class="panel-title text-center">Daftar Pelanggan</h3>
                    </div>
                    <div class="panel-body p-2">
                        <form method="POST" class="form-horizontal">
                            <div class="form-group row">
                                <input type="hidden" class="form-control" value="<?= $kode_otomatis; ?>" name="id_pelanggan" required>
                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama" id="nama" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea name="alamat" id="alamat" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telepon" class="col-sm-2 col-form-label">Telp/Hp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="telepon" id="telepon" required>
                                </div>
                            </div>
                            <button class="btn btn-primary float-right" name="daftar">DAFTAR</button>
                        </form>
                        <?php
                        if (isset($_POST["daftar"])) {
                            $id     = $_POST['id_pelanggan'];
                            $nama = $_POST['nama'];
                            $email = $_POST['email'];
                            $password = $_POST['password'];
                            $alamat = $_POST['alamat'];
                            $telepon = $_POST['telepon'];

                            $ambil = mysqli_query($con, "SELECT * FROM tbl_pelanggan WHERE email_pelanggan='$email'");
                            $cocok = $ambil->num_rows;
                            if ($cocok == 1) {
                                echo "<script>alert('Pendaftaran gagal, email sudah digunakan');</script>";
                                echo "<script>location='daftar.php';</script>";
                            } else {
                                $query = mysqli_query($con, "INSERT INTO tbl_pelanggan VALUES('$id','$nama','$email','$password','$telepon','$alamat')");
                                if ($query) {
                                    echo "<script>alert('Pendaftaran sukses, silahkan login');</script>";
                                    echo "<script>location='login.php';</script>";
                                } else {
                                    echo "ERROR, tidak berhasil" . mysqli_error($con);
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

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