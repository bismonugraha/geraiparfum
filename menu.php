<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <h3><i class="fas fa-cart-plus text-primary mr-2"></i></h3>
        <a class="navbar-brand font-weight-bold" href="#">PARFUM SHOP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mr-4">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Beranda <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="keranjang.php">Keranjang Belanja <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="checkout.php">Checkout <span class="sr-only">(current)</span></a>
                </li>
                <?php if (isset($_SESSION["pelanggan"])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="riwayat.php">Riwayat Belanja <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i>
                            <span class="sr-only">(current)</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right mr-5">
                            <li class="dropdown-header">
                                <div class="dropdown-header-title">
                                    <h6><b><?= $_SESSION["pelanggan"]["nama_pelanggan"] ?></b></h6>
                                </div>
                                <div class="dropdown-header-desc">
                                    <?= $_SESSION["pelanggan"]["email_pelanggan"] ?>
                                </div>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="edit_pelanggan.php">Edit Akun</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="edit_password.php">Edit Password</a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item ml-3 p-2">
                        <a href="login.php" class="btn btn-sm btn-light text-dark" data-toggle="tooltip" data-placement="top" title="Login">LOGIN</a>
                    </li>
                    <li class="nav-item p-2">
                        <a href="daftar.php" class="btn btn-sm btn-primary text-white" data-toggle="tooltip" data-placement="top" title="Daftar">DAFTAR</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>