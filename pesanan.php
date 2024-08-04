<?php
session_start();
require "function.php";

$query = getData("SELECT pemesanan.id_pemesanan, users.name, paket_wisata.nama_paket, paket_wisata.harga, 
pemesanan.tanggal_pemesanan, pemesanan.jumlah_orang, pemesanan.jumlah_hari, pemesanan.total_harga 
FROM pemesanan INNER JOIN users ON pemesanan.id_user = users.id INNER JOIN paket_wisata 
ON pemesanan.id_paket = paket_wisata.id ORDER BY id_pemesanan LIMIT 100");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./asset/css/style.css">
    <title>Pariwisata Nusantara</title>
</head>
<style>

</style>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container">
            <a class="navbar-brand poppins-semibold no-spacing" href="#">Pariwisata <br>Nusantara </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse px-0 px-lg-5 poppins-regular" id="navbarTogglerDemo02">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                    <li class="nav-item">
                        <a class="nav-link " href="index.php">Home</a>
                    </li>
                    <?php if (isset($_SESSION['email'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Pesanan</a>
                    </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['email']) && $_SESSION['admin'] == 1) : ?>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Administrator
                        </button>
                        <ul class="dropdown-menu">
                            <hr class="my-4">
                            <li><a class="dropdown-item" href="./src/dashboard/index.php">Dashboard</a></li>
                        </ul>
                    </div>                    
                    <?php endif; ?>
                </ul>
                <div class="d-flex flex-wrap-reverse ">
                    <?php if (isset($_SESSION['email'])) : ?>
                    <a href="logout.php" class="btn btn-outline-danger fs-6">
                        Logout
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <section class=" position-relative">
        <div class="d-flex justify-content-center align-items-center position-absolute bg-class">
            <img src="./asset/img/bg.jpg" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="bg-hero">
        </div>

        <div class="container jumbotron position-relative p-5 bg-class poppins-regular "
            style="background-color: rgba(255, 255, 255, 0.75);">
            <h1 class="display-6 poppins-semibold">Pariwisata Nusantara</h1>
            <p class="lead" style="font-weight:500;">Jelajahi keindahan alam dan kekayaan budaya Indonesia dengan
                informasi lengkap dan
                inspiratif di setiap destinasinya.</p>
            <hr class="my-4">
            <p>Nikmati tips perjalanan, panduan destinasi, serta rekomendasi aktivitas menarik untuk pengalaman yang tak
                terlupakan.</p>
        </div>
    </section>

    <main class="container mb-5">
        <section class="table-responsive ">
                <h3 class="poppins-regular mt-4 ">Daftar Pesanan</h3>
                <hr class="my-4">
            <table class="table table-striped table-sm border border-secondary-subtlek">
                <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pemesan</th>
                    <th scope="col">Paket Wisata</th>
                    <th scope="col">Harga Paket</th>
                    <th scope="col">Tgl Keberangkatan</th>
                    <th scope="col">Jumlah Orang</th>
                    <th scope="col">Hari</th>
                    <th scope="col">Total Tagihan</th>
                    <th scope="col">Option</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1;?> 
                <?php if (!empty($query)) :?>
                    <?php foreach ($query as $getData) : ?>
                    <tr >
                        <td><?php echo $no ?></td>
                        <td><?php echo $getData['name'] ?></td>
                        <td><?php echo $getData['nama_paket'] ?></td>
                        <td>Rp.<?php echo $getData['harga'] ?></td>                
                        <td><?php echo $getData['tanggal_pemesanan'] ?></td>
                        <td><?php echo $getData['jumlah_orang'] ?> Orang</td>
                        <td><?php echo $getData['jumlah_hari'] ?> Hari</td>
                        <td>Rp.<?php echo $getData['total_harga'] ?></td>
                        <td>
                        <a href="deletePesanan.php?id_pemesanan= <?php echo $getData['id_pemesanan'] ?> ">
                            <button class="btn btn-danger px-2 pt-1">
                            <i class="bi bi-trash"></i>
                            Batalkan
                            </button>  
                            </a>
                        </td>
                    </tr>
                    <?php $no++; ?>
                    <?php endforeach; ?>
                
                <?php else :?>
                    <tr>
                        <td colspan="9" class="text-center">Belum ada pesanan</td>
                    </tr>

                <?php endif; ?>

                </tbody>
            </table>
        </section>
    </main>

    <!-- Notif Berhasil Hapus Pesanan -->
    <?php if (isset($_SESSION['deleteDataSukses'])) : ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="toast-header">
                <strong class="me-auto poppins-semibold">Pariwisata Nusantara</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body poppins-regular">
                Pesanan Berhasil Di Hapus
            </div>
        </div>
    </div>
    <?php unset($_SESSION['deleteDataSukses']); ?>
    <?php endif; ?>

    <!-- Notif Gagal Hapus Pesanan -->
    <?php if (isset($_SESSION['deleteDataGagal'])) : ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="toast-header">
                <strong class="me-auto poppins-semibold">Pariwisata Nusantara</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body poppins-regular">
                Pesanan Gagal Di Hapus
            </div>
        </div>
    </div>
    <?php unset($_SESSION['deleteDataGagal']); ?>
    <?php endif; ?>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Fungsi menampilkan notif -->
    <script>
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl, {
                autohide: false
            }).show()
        })
    </script>
</body>

</html>