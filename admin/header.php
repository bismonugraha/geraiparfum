<?php
require_once "config/config.php";
if (!(@$_SESSION['OPERATOR'] || @$_SESSION['MANAJER'])) {
    echo "<script>window.location='" . base_url('views/Login/index.php') . "';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Gerai Parfume</title>
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style-image.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <link href="<?= base_url('assets/sweetalert/dist/sweetalert.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/sweetalert/dist/sweetalert.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/image-preview.js') ?>"></script>
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3">GERAI-PARFUM</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/'); ?>">
                    <i class="fas fa-home"></i>
                    <span>Dahboard</span>
                </a>
            </li>
            <?php if (isset($_SESSION["OPERATOR"])) : ?>
                <hr class="sidebar-divider my-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('views/Kategori/index.php'); ?>">
                        <i class="fas fa-list"></i>
                        <span>Kategori Produk</span></a>
                </li>
                <hr class="sidebar-divider my-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('views/Produk/index.php'); ?>">
                        <i class="fas fa-cube"></i>
                        <span>Produk</span>
                    </a>
                </li>
                <hr class="sidebar-divider my-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('views/Gallery/index.php'); ?>">
                        <i class="far fa-images"></i>
                        <span>Gallery</span>
                    </a>
                </li>
                <hr class="sidebar-divider my-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('views/Pembelian/index.php'); ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Pembelian</span>
                    </a>
                </li>
                <hr class="sidebar-divider my-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('views/Pelanggan/index.php'); ?>">
                        <i class="fas fa-user"></i>
                        <span>Pelanggan</span></a>
                </li>
                <hr class="sidebar-divider my-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('views/Pembelian/laporan.php'); ?>">
                        <i class="far fa-file"></i>
                        <span>Laporan Pembelian</span></a>
                </li>
            <?php else : ?>
                <hr class="sidebar-divider my-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('views/Pembelian/laporan.php'); ?>">
                        <i class="far fa-file"></i>
                        <span>Laporan Pembelian</span></a>
                </li>
            <?php endif ?>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class=" d-none d-sm-block"></div>
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <?php
                                $sql = "SELECT tbl_pembelian.*, tbl_pelanggan.* FROM tbl_pembelian 
                                INNER JOIN tbl_pelanggan ON tbl_pembelian.id_pelanggan = tbl_pelanggan.id_pelanggan
                                WHERE status_pembelian = 'pending'";
                                $query = mysqli_query($con, $sql);
                                $count = mysqli_num_rows($query);
                                ?>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter"><?= $count ?></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notif Pembelian
                                </h6>
                                <?php if ($query) {
                                    foreach ($query as $data) { ?>
                                        <a class="dropdown-item d-flex align-items-center" href="<?= base_url('views/Pembelian/index.php'); ?>">
                                            <div>
                                                <div class="small text-gray-500"><?= $data['tanggal_pembelian'] ?></div>
                                                <span class="font-weight-bold"><?= $data['nama_pelanggan'] ?></span>
                                            </div>
                                        </a>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <?php
                                $sql = "SELECT tbl_pembelian.*, tbl_pelanggan.* FROM tbl_pembelian 
                                INNER JOIN tbl_pelanggan ON tbl_pembelian.id_pelanggan = tbl_pelanggan.id_pelanggan 
                                WHERE status_pembelian = 'sudah kirim pembayaran'";
                                $query = mysqli_query($con, $sql);
                                $count = mysqli_num_rows($query);
                                ?>
                                <span class="badge badge-danger badge-counter"><?= $count ?></span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Sudah Transfer
                                </h6>
                                <?php if ($query) {
                                    foreach ($query as $data) { ?>
                                        <a class="dropdown-item d-flex align-items-center" href="<?= base_url('views/Pembelian/index.php'); ?>">
                                            <div class="font-weight-bold">
                                                <div class="text-truncate"><?= $data['nama_pelanggan'] ?></div>
                                                <div class="small text-gray-500"><?= $data['status_pembelian'] ?></div>
                                            </div>
                                        </a>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><b><?= @$_SESSION['nama']; ?> | LOGOUT</b></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">