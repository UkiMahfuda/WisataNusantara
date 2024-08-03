<?php
session_start();
require "function.php";

if (isset($_POST['btnsignup'])) {
    $signupResult = daftarAccount($_POST);
    if ($signupResult > 0) {
        $_SESSION['signup_success'] = true; 
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Gagal Buat Account: " . mysqli_error($conn) . "')</script>";
    }
}

if (isset($_POST['btnlogin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['btnlogin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['admin'] = $user['admin'];  
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Password Salah')</script>";
        }
    } else {
        echo "<script>alert('Email Salah')</script>";
    }
}

$query = getData("SELECT * FROM paket_wisata ORDER BY id DESC");
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
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <?php if (isset($_SESSION['email'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pesanan</a>
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
                    
                    <?php if (!isset($_SESSION['email'])) : ?>
                    <button type="button" class="btn btn-outline-danger fs-6" data-bs-toggle="modal"
                        data-bs-target="#modalSignup">
                        SignUp
                    </button>
                    <div class="mx-3"></div>
                    <button type="button" class="btn btn-primary fs-6" data-bs-toggle="modal"
                        data-bs-target="#modalLogin">
                        Login
                    </button>
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
        <section class="py-5 text-start container">
            <div class="row py-lg-5 d-flex justify-content-evenly flex-wrap">
                <div class="col-lg-6 col-md-8 text-lg-start text-center ">
                    <h1 class="fw-light poppins-regular">Pariwisata Nusantara</h1>
                    <p class="lead text-muted">Jelajahi keindahan Nusantara dengan layanan UMKM pariwisata kami. Temukan
                        berbagai destinasi menakjubkan, dipersembahkan oleh para kreator lokal yang siap memberikan
                        pengalaman tak terlupakan. Singkat namun penuh makna, mari jelajahi pesona Indonesia bersama
                        kami.</p>
                    <p>
                        <a href="#paketWisata" class="btn btn-secondary my-2 poppins-regular">Pesan Sekarang</a>
                    </p>
                </div>
                <div class="col-lg-6 col-md-8 d-flex justify-content-center align-items-center">
                    <iframe width="400" height="250" src="https://www.youtube.com/embed/Ox5X9Yzuik8?si=6LztpsvV4lvyqizc"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </section>


        <div class="album py-5 bg-light">
            <div class="container" id="paketWisata">
                <h3 class="poppins-regular mb-4">Daftar Paket Wisata</h3>
                <hr class="my-4">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach ($query as $getData) : ?>
                    <div class="col">
                        <div class="card shadow-sm ">
                        <img src="asset/img/<?php echo $getData['gambar']; ?>" class="bd-placeholder-img card-img-top" width="100%" height="225" alt="Gambar Wisata">
                            <div class="card-body">
                                <p class="poppins-regular fst-italic"><?php echo $getData['nama_paket'] ?></p>
                                <p class="card-text overflow-hidden " style="height: 50px;""><?php echo $getData['deskripsi'] ?> </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalFormPesan">Pesan Wisata Ini</button>
                                    
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

    <!-- Form Pesan Paket Wisata -->
        <div class="modal fade" id="modalFormPesan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalFormPesanLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalFormPesanLabel">Form Pesan Paket Wisata</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    <fieldset disabled>
                        <div class="mb-3">
                            <label for="nama_paket" class="form-label">Paket Wisata</label>
                            <input type="text" id="nama_paket" name="nama_paket" class="form-control" placeholder="Wisata Pahawang">
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Paket</label>
                            <input type="text" id="harga" name="harga" class="form-control" placeholder="1250.000">
                        </div>
                    </fieldset>

                    <div class="mb-3">
                        <label >Fasilitas</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="penginapan">
                            <label class="form-check-label" for="penginapan" name="penginapan" value="Penginapan">
                                Penginapan (+Rp. 1000.000)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="transportasi">
                            <label class="form-check-label" for="transportasi" name="transportasi" value="Transportasi">
                                Transportasi (+Rp. 1200.000)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="makan">
                            <label class="form-check-label" for="makan" name="makan" value="Makan">
                                Makan (+Rp. 500.000)
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pemesanan" class="form-label">Tanggal Berangkat</label>
                        <input type="date" class="form-control" id="tanggal_pemesanan" name="tanggal_pemesanan">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_orang" class="form-label">Jumlah Orang</label>
                        <input type="int" class="form-control" id="jumlah_orang" name="jumlah_orang">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_hari" class="form-label">Jumlah Hari</label>
                        <input type="int" class="form-control" id="jumlah_hari" name="jumlah_hari">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                        <button type="submit" name="btnPesan" class="btn btn-primary">Pesan</button>
                    </div>
                </div>
            </div>
        </div>


    <!-- PopUp Login -->
    <div class="modal fade" id="modalLogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLoginLabel">Form Login</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name='email' required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name='password' required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="btnlogin" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PopUp Signup -->
    <div class="modal fade" id="modalSignup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalSignupLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalSignupLabel">Form SignUp</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class=" mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class=" mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="btnsignup" class="btn btn-primary">SignUp</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Notif Login -->
    <?php if (isset($_SESSION['btnlogin'])) : ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="toast-header">
                <strong class="me-auto poppins-semibold">Pariwisata Nusantara</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body poppins-regular">
                Login Berhasil!
            </div>
        </div>
    </div>
    <?php unset($_SESSION['btnlogin']); ?>
    <?php endif; ?>

    <!-- Notif Signup -->
    <?php if (isset($_SESSION['signup_success'])) : ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="toast-header">
                <strong class="me-auto poppins-semibold">Pariwisata Nusantara</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body poppins-regular">
                Daftar Akun Berhasil, Silahkan Login
            </div>
        </div>
    </div>
    <?php unset($_SESSION['signup_success']); ?>
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