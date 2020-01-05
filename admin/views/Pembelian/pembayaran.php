<?php include_once('../../header.php'); ?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pembayaran</h6>
        </div>
        <div class="card-body">
            <?php
            $id_pembelian = $_GET["id"];

            $ambil = mysqli_query($con, "SELECT * FROM tbl_pembayaran WHERE id_pembelian='$id_pembelian'");
            $detail = $ambil->fetch_assoc();
            ?>
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
                    <form method="POST">
                        <?php 
                         $ambil = mysqli_query($con, "SELECT * FROM tbl_pembelian WHERE id_pembelian ='$id_pembelian'");
                         $data = $ambil->fetch_assoc();
                        ?>
                        <div class="form-group">
                            <label for="resi">No Resi Pengiriman</label>
                            <input type="text" name="resi" class="form-control" value="<?= $data['resi_pengiriman'];?>">
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <?php
                                $status = $data["status_pembelian"];
                                if ($status == "") echo "<option value='' selected></option>";
                                else echo "<option value=''></option>";
                                if ($status == "sukses") echo "<option value='sukses' selected>Sukses</option>";
                                else echo "<option value='sukses'>Sukses</option>";
                                if ($status == "barang dikirim") echo "<option value='barang dikirim' selected>Barang Dikirim</option>";
                                else echo "<option value='barang dikirim'>Barang Dikirim</option>";
                                if ($status == "batal") echo "<option value='batal' selected>Batal</option>";
                                else echo "<option value='batal'>Batal</option>";
                                ?>
                            </select>
                        </div>
                        <button class="btn btn-primary" name="proses">Proses</button>
                    </form>

                    <?php
                        if (isset($_POST["proses"]))
                        {
                            $resi = $_POST["resi"];
                            $status = $_POST["status"];
                            mysqli_query($con, "UPDATE tbl_pembelian SET resi_pengiriman='$resi', 
                            status_pembelian='$status' WHERE id_pembelian='$id_pembelian'");

                            echo "<script>alert('Data pembelian terupdate')</script>";
                            echo "<script>location='index.php'</script>";
                        }
                    ?>
                </div>
                <div class="col-md-6">
                    <img src="../../../bukti_pembayaran/<?= $detail['bukti']; ?>" width="550px" height="350px">
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('../../footer.php'); ?>