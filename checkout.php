<?php

require_once "admin/config/config.php";

if (!isset($_SESSION["pelanggan"])) {
    echo "<script>alert('Silahkan Login!');</script>";
    echo "<script>location='login.php';</script>";
}

if (empty($_SESSION["keranjang"]) or !isset($_SESSION["keranjang"])) {
    echo "<script>alert('Keranjang kosong, silahkan belanja dulu!');</script>";
    echo "<script>location='index.php';</script>";
}
?>

<?php
$carikode = mysqli_query($con, "SELECT id_pembelian from tbl_pembelian") or die(mysqli_error($con));
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
    <title>Checkout</title>
    <link rel="stylesheet" href="frontend/libraries/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="frontend/libraries/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="frontend/styles/main.css">
</head>

<body>
    <?php include "menu.php"; ?>

    <section>
        <div class="container-fluid">
            <div class="row p-5">
                <div class="col-md-12">
                    <h3 class="mt-5 text-center p-3">Checkout</h3>
                    <div id="ongkir"></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Produk</th>
                                <th scope="col">Gambar</th>
                                <th scope="col">Berat</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Subharga</th>
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
                                @$total_belanja  = @$total_belanja + $subharga;
                                ?>
                                <tr class="text-center">
                                    <td><?= $no; ?></td>
                                    <td><?= $data['nama_produk']; ?></td>
                                    <td><img src="admin/uploads/galeri_parfum/<?= $data['foto_produk']; ?>" alt="Foto Produk" width="75px" height="75px"></td>
                                    <td><?= $data['ukuran']; ?> ML</td>
                                    <td><?= $jumlah; ?></td>
                                    <td>Rp. <?= number_format($data['harga_produk']); ?></td>
                                    <td>Rp. <?= number_format($subharga) ?></td>
                                </tr>
                                <?php $no++; ?>
                            <?php endforeach ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="row" colspan="6" class="text-left">Total Belanja</th>
                                <th class="text-center">Rp. <?= number_format(@$total_belanja) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    <form method="POST">
                        <div class="row">
                            <input type="hidden" class="form-control" name="id" value="<?= $kode_otomatis; ?>">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nama" readonly value="<?= $_SESSION["pelanggan"]['nama_pelanggan'] ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="no_tlp" name="nama" readonly value="<?= $_SESSION["pelanggan"]['telepon_pelanggan'] ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="provinsiId" id="provinsiId" class="form-control">
                                        <option value="">Pilih Provinsi</option>
                                        <?php
                                        $ambil = mysqli_query($con, "SELECT * FROM tbl_provinsi");
                                        while ($data = $ambil->fetch_assoc()) {
                                        ?>
                                            <option value="<?= $data['provinsiId']; ?>">
                                                <?= $data['provinsiNama'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="kabId" id="kabId" class="form-control">
                                        <option value="">Pilih Kabupaten/Kota</option>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="alamat_pengiriman" placeholder="Masukan alamat lengkap pengiriman (termasuk kode pos)"></textarea>
                        </div>
                        <button class="btn btn-primary btn-md" name="checkout">CHECKOUT</button>
                    </form>
                </div>
                <?php
                if (isset($_POST["checkout"])) {
                    $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
                    $id_pemb = $_POST["id"];
                    $kabId = $_POST["kabId"];
                    $tanggal_pembelian = date("Y-m-d");
                    $alamat_pengiriman = $_POST["alamat_pengiriman"];

                    $ambil = mysqli_query($con, "SELECT * FROM tbl_kabkot WHERE kabId='$kabId'");
                    $arrayongkir = $ambil->fetch_assoc();
                    $kabNama = $arrayongkir['kabNama'];
                    $kabTipe = $arrayongkir['kabTipe'];
                    $tarif = $arrayongkir['tarif'];
                    $estimasi = $arrayongkir['estimasi'];

                    $total_pembelian = $total_belanja + $tarif;

                    // 1. Menyimpan data ke tabel pembelian
                    $query = mysqli_query($con, "INSERT INTO tbl_pembelian (
                                id_pembelian, id_pelanggan, kabId, tanggal_pembelian, total_pembelian, kabNama, kabTipe, tarif, estimasi, alamat_pengiriman, resi_pengiriman)
                                VALUES ('$id_pemb','$id_pelanggan','$kabId','$tanggal_pembelian','$total_pembelian','$kabNama','$kabTipe','$tarif','$estimasi',
                                '$alamat_pengiriman','')");

                    // Mendapatkan id_pembelian barusan terjadi
                    $id_pembelian_barusan = $con->insert_id;

                    foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) {
                        $ambil = mysqli_query($con, "SELECT * FROM tbl_produk WHERE id_produk='$id_produk'");
                        $data = $ambil->fetch_assoc();

                        $nama = $data['nama_produk'];
                        $harga = $data['harga_produk'];
                        $subharga = $data['harga_produk'] * $jumlah;

                        mysqli_query($con, "INSERT INTO tbl_pembelian_produk (id_pembelian,id_produk,nama,harga,subharga,jumlah)
                                VALUES ('$id_pembelian_barusan','$id_produk','$nama','$harga','$subharga','$jumlah') ");

                        mysqli_query($con, "UPDATE tbl_produk SET stok_produk=stok_produk -$jumlah
                        WHERE id_produk=$id_produk");
                    }

                    // Mengosongkan keranjang belanja
                    unset($_SESSION["keranjang"]);

                    // Tampilan dialihkan ke halaman nota
                    echo "<script>alert('Pembelian sukses!');</script>";
                    echo "<script>location='nota.php?id=$id_pembelian_barusan';</script>";
                }
                ?>
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

    <div class="copyright text-center text-white font-weight-bold bg-dark p-3">
        <p>Developed by Parfum Shop Copyright <i class="far fa-copyright"></i> 2019</p>
    </div>

    <?php include "footer.php" ?>
    <script>
        $(document).ready(function() {
            $('#provinsiId').change(function() {
                var provinsi_id = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: 'getKabupaten.php',
                    data: 'provinsiId=' + provinsi_id,
                    success: function(response) {
                        $('#kabId').html(response);
                    }
                });
            })
        });
    </script>
</body>

</html>