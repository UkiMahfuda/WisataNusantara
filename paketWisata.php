<?php
session_start();
require "function.php";

$query = getData("SELECT * FROM paket_wisata ORDER BY id DESC");
// var_dump($query);
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
                        <a class="nav-link active" href="paketWisata.php">Paket Wisata</a>
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

    <main>
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach ($query as $getData) : ?>
                    <div class="col">
                        <div class="card shadow-sm ">
                            <svg class="bd-placeholder-img card-img-top" width="100%" height="225"
                                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail"
                                preserveAspectRatio="xMidYMid slice" focusable="false">
                                <title>Placeholder</title>
                                <rect width="100%" height="100%" fill="#55595c" />
                                <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                            </svg>

                            <div class="card-body">
                                <p class="poppins-regular fst-italic"><?php echo $getData['nama_paket'] ?></p>
                                <p class="card-text overflow-hidden " style="height: 50px;""><?php echo $getData['deskripsi'] ?> </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                    <small class="text-muted">Rp.<?php echo $getData['harga']?> / <?php echo $getData['durasi']?> Hari</small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                </div>
            </div>
        </div>
    </main>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>