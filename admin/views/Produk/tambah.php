<?php include_once('../../header.php'); ?>
<!-- Page Heading -->
<!------------ Kode Otomatis Kode ---------------->
<?php
$carikode = mysqli_query($con, "SELECT id_produk from tbl_produk") or die(mysqli_error($con));
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

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="col-lg-12 col-lg-offset-12 col-sm-6 col-sm-offset-4">
            <h4 style="text-align: center;" class="mt-3">Tambah Data Produk</h4>
            <div class="thumbnail">
                <form role="form" id="formInput">
                    <div class="row">
                        <div class="form-group col-md-6 has-feedback">
                            <label for="id_produk">ID Produk</label>
                            <input type="text" name="id_produk" id="id_produk" value="<?= $kode_otomatis; ?>" class="form-control textbox" readonly>
                            <i class="form-control-feedback"></i>
                            <span class="text-warning"></span>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" name="nama_produk" id="nama_produk" class="form-control textbox">
                            <i class="form-control-feedback"></i>
                            <span class="text-warning"></span>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label for="id_kategori">Kategori</label>
                            <select for="id_kategori" class="form-control textbox" name="id_kategori" required>
                                <option value="">... Pilih ...</option>
                                <?php
                                $sql = mysqli_query($con, "SELECT * FROM tbl_kategori") or die(mysqli_error($con));
                                while ($data_kategori = mysqli_fetch_array($sql)) {
                                    echo '<option value="' . $data_kategori['id_kategori'] . '">' . $data_kategori['nama_kategori'] . '</option>';
                                }
                                ?>
                            </select>
                            <i class="form-control-feedback"></i>
                            <span class="text-warning"></span>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label for="ukuran">Ukuran</label>
                            <input type="number" name="ukuran" id="ukuran" class="form-control textbox">
                            <i class="form-control-feedback"></i>
                            <span class="text-warning"></span>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label for="harga_produk">Harga Produk</label>
                            <input type="number" name="harga_produk" id="harga_produk" class="form-control textbox">
                            <i class="form-control-feedback"></i>
                            <span class="text-warning"></span>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label for="stok_produk">Stok Produk</label>
                            <input type="number" name="stok_produk" id="stok_produk" class="form-control textbox">
                            <i class="form-control-feedback"></i>
                            <span class="text-warning"></span>
                        </div>
                        <div class="form-group col-md-12 has-feedback">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control textbox" cols="30" rows="10" required></textarea>
                            <i class="form-control-feedback"></i>
                            <span class="text-warning"></span>
                        </div>
                    </div>
                    <button type="submit" name="btn-simpan" class="btn btn-primary btn-block mb-3">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include_once('../../footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        //Menyembunyikan text-warning saat load
        $('.text-warning').hide();

        //untuk mengecek semua textbox tidak boleh kosong
        $('.input').each(function() {
            $(this).blur(function() { //blur function itu dijalankan saat element kehilangan fokus
                if (!$(this).val()) { //this mengacu pada textbox yang sedang fokus
                    return get_error_text(this); //function get_error_text ada dibawah
                } else {
                    $(this).removeClass('no-valid');
                    $(this).parent().find('.text-warning').hide(); //cari element dengan class text-warning dari element induk text yang sedang fokus
                    $(this).closest('div').removeClass('has-warning');
                    $(this).closest('div').addClass('has-success');
                    $(this).parent().find('.form-control-feedback').removeClass('fas fa-exclamation-triangle');
                    $(this).parent().find('.form-control-feedback').addClass('fas fa-check');
                }
            });
        });

        //Mengecek textbox nama produk Valid atau tidak
        $('#nama_produk').blur(function() {
            var nama_produk = $(this).val();
            var len = nama_produk.length;
            if (len > 0) { //Jika ada isinya
                if (!valid_nama_produk(nama_produk)) { //jika nama_produk tidak valid 
                    $(this).parent().find('.text-warning').text("");
                    $(this).parent().find('.text-warning').text("Nama Produk Tidak Valid");
                    return apply_feedback_error(this);
                } else {
                    if (len > 30) { //Jika karakter > 30
                        $(this).parent().find('.text-warning').text("");
                        $(this).parent().find('.text-warning').text("Maximal Karakter 30");
                        return apply_feedback_error(this);
                    }
                }
            }
        });
        //Mengecek textbox deskripsi Valid atau tidak
        $('#deskripsi').blur(function() {
            var deskripsi = $(this).val();
            var len = deskripsi.length;
            if (len > 0) { //Jika ada isinya
                if (!valid_deskripsi(deskripsi)) { //jika deskripsi tidak valid 
                    $(this).parent().find('.text-warning').text("");
                    $(this).parent().find('.text-warning').text("Deskripsi Tidak Valid");
                    return apply_feedback_error(this);
                } else {
                    if (len > 300) { //Jika karakter > 30
                        $(this).parent().find('.text-warning').text("");
                        $(this).parent().find('.text-warning').text("Maximal Karakter 300");
                        return apply_feedback_error(this);
                    }
                }
            }
        });
        // Mengecek Ukuran Parfum
        $('#ukuran').blur(function() {
            var ukuran = $(this).val();
            var len = ukuran.length;
            if (len > 0 && len <= 2) { //Jika ada isinya
                $(this).parent().find('.text-warning').text("");
                $(this).parent().find('.text-warning').text("Ukuran Terlalu Kecil");
                return apply_feedback_error(this);
            } else {
                if (!valid_ukuran(ukuran)) { //jika ukuran tidak valid 
                    $(this).parent().find('.text-warning').text("");
                    $(this).parent().find('.text-warning').text("Ukuran Tidak Valid");
                    return apply_feedback_error(this);
                } else {
                    if (len > 3) { //Jika karakter > 30
                        $(this).parent().find('.text-warning').text("");
                        $(this).parent().find('.text-warning').text("Ukuran Terlalu Besar");
                        return apply_feedback_error(this);
                    }
                }
            }
        });
        // Mengecek Stok Parfum
        $('#stok_produk').blur(function() {
            var stok_produk = $(this).val();
            var len = stok_produk.length;
            if (!valid_stok_produk(stok_produk)) { //jika stok tidak valid 
                $(this).parent().find('.text-warning').text("");
                $(this).parent().find('.text-warning').text("Stok Tidak Valid");
                return apply_feedback_error(this);
            } else {
                if (len > 3) { //Jika karakter > 3
                    $(this).parent().find('.text-warning').text("");
                    $(this).parent().find('.text-warning').text("Stok Terlalu Besar");
                    return apply_feedback_error(this);
                }
            }
        });
        // Mengecek Harga Parfum
        $('#harga_produk').blur(function() {
            var harga_produk = $(this).val();
            var len = harga_produk.length;
            if (len > 0 && len <= 4) { //Jika ada isinya
                $(this).parent().find('.text-warning').text("");
                $(this).parent().find('.text-warning').text("Harga Terlalu Kecil");
                return apply_feedback_error(this);
            } else {
                if (!valid_harga_produk(harga_produk)) { //jika harga tidak valid 
                    $(this).parent().find('.text-warning').text("");
                    $(this).parent().find('.text-warning').text("harga_produk Tidak Valid");
                    return apply_feedback_error(this);
                } else {
                    if (len > 7) { //Jika karakter > 30
                        $(this).parent().find('.text-warning').text("");
                        $(this).parent().find('.text-warning').text("Harga Terlalu Besar");
                        return apply_feedback_error(this);
                    }
                }
            }
        });

        //Submit Form Validasi
        $('#formInput').submit(function(e) {
            e.preventDefault();
            var valid = true;
            $(this).find('.textbox').each(function() {
                if (!$(this).val()) {
                    get_error_text(this);
                    valid = false;
                    $('html,body').animate({
                        scrollTop: 0
                    }, "slow");
                }
                if ($(this).hasClass('no-valid')) {
                    valid = false;
                    $('html,body').animate({
                        scrollTop: 0
                    }, "slow");
                }
            });
            if (valid) {
                swal({
                    title: "Konfirmasi Simpan Data",
                    text: "Data Akan di Simpan Ke Database",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                }, function() { //apabila sweet alert di confirm maka akan mengirim data ke simpan.php melalui proses ajax
                    $.ajax({
                        url: "<?= base_url('models/Produk/simpan.php'); ?>",
                        type: "POST",
                        data: $('#formInput').serialize(), //serialize() untuk mengambil semua data didalam form
                        dataType: "html",
                        success: function() {
                            setTimeout(function() {
                                swal({
                                    title: "Data Berhasil Disimpan",
                                    text: "Terimakasih",
                                    type: "success"
                                }, function() {
                                    window.location = "index.php";
                                });
                            }, 2000);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            setTimeout(function() {
                                swal("Error", "Tolong Cek Koneksi Lalu Ulangi", "error");
                            }, 2000);
                        }
                    });
                });
            }
        });
    });

    //Fungsi cek nama_produk
    function valid_nama_produk(nama_produk) {
        var pola = new RegExp(/^[a-z A-Z]+$/);
        return pola.test(nama_produk);
    }
    //Fungsi cek ukuran
    function valid_ukuran(ukuran) {
        var pola = new RegExp(/^[0-9]+$/);
        return pola.test(ukuran);
    }
    //Fungsi cek stok
    function valid_stok_produk(stok_produk) {
        var pola = new RegExp(/^[0-9]+$/);
        return pola.test(stok_produk);
    }
    //Fungsi cek harga
    function valid_harga_produk(harga_produk) {
        var pola = new RegExp(/^[0-9]+$/);
        return pola.test(harga_produk);
    }

    //Menerapkan gaya validasi form bootstrap saat terjadi eror
    function apply_feedback_error(textbox) {
        $(textbox).addClass('no-valid'); //Menambah class no valid
        $(textbox).parent().find('.text-warning').show();
        $(textbox).closest('div').removeClass('has-success');
        $(textbox).closest('div').addClass('has-warning');
        $(textbox).parent().find('.form-control-feedback').removeClass('fas fa-check');
        $(textbox).parent().find('.form-control-feedback').addClass('fas fa-exclamation-triangle');
    }

    //untuk mendapat error teks saat textbox kosong, digunakan saat submit form dan blur fungsi
    function get_error_text(textbox) {
        $(textbox).parent().find('.text-warning').text("");
        $(textbox).parent().find('.text-warning').text("Text Box Ini Tidak Boleh Kosong");
        return apply_feedback_error(textbox);
    }
</script>