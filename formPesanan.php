<?php
session_start();
require "function.php";

$query = getData("SELECT * FROM paket_wisata ORDER BY id DESC");

if(isset($_POST['submitForm'])){
    if(addDataPemesanan($_POST) > 0){
        $_SESSION['addDataSukses'] = true; 
    } else {
        $_SESSION['addDataGagal'] = true; 
    }
}

$name = $_SESSION['name'];
$id_user = $_SESSION['id'];
// var_dump($id_user);
// var_dump($name);
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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <?php if (isset($_SESSION['email'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="pesanan.php">Pesanan</a>
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

    <div class="container d-flex justify-content-center">
        <div class="col-md-7 col-lg-8 border border-secondary-subtlek p-4 my-5">
            <h4 class="mb-3">Form Pemesanan Paket Wisata</h4>
            <form class="needs-validation" action="" method="post">
                <div class="row g-3">
                    <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($id_user); ?>" readonly>
                    <fieldset class="col-sm-6" disabled>
                        <label for="name" class="form-label">Nama Pemesan</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                    </fieldset>
                    <div class="col-sm-6">
                        <label for="paket_wisata" class="form-label">Pilih Paket Wisata</label>
                        <select class="form-select" id="paket_wisata" name="paket_wisata" required>
                            <option value="" data-harga="0">Pilih Paket Wisata</option>
                            <?php foreach ($query as $getData) : ?>
                                <option value="<?php echo $getData['id']?>" data-harga="<?php echo $getData['harga']?>">
                                    <?php echo $getData['nama_paket']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <table>
                        <tr>
                            <td>Pilihan Fasilitas</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input fasilitas" type="checkbox" value="1200000" id="transportasi" name="fasilitas[]" data-hidden-id="hidden_transportasi">
                                    <label class="form-check-label" for="transportasi">Transportasi +Rp.1.200.000</label>
                                    <input type="hidden" id="hidden_transportasi" name="fasilitas_transportasi" value="0">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input fasilitas" type="checkbox" value="500000" id="makan" name="fasilitas[]" data-hidden-id="hidden_makan">
                                    <label class="form-check-label" for="makan">Makan +Rp.500.000</label>
                                    <input type="hidden" id="hidden_makan" name="fasilitas_makan" value="0">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input fasilitas" type="checkbox" value="1000000" id="penginapan" name="fasilitas[]" data-hidden-id="hidden_penginapan">
                                    <label class="form-check-label" for="penginapan">Penginapan +Rp.1.000.000</label>
                                    <input type="hidden" id="hidden_penginapan" name="fasilitas_penginapan" value="0">
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="col-12">
                        <label for="tanggal_pemesanan" class="form-label">Tgl Keberangkatan</label>
                        <input type="date" class="form-control" id="tanggal_pemesanan" name="tanggal_pemesanan" required>
                    </div>
                    <div class="col-12">
                        <label for="jumlah_orang" class="form-label">Jumlah Orang</label>
                        <input type="number" class="form-control" id="jumlah_orang" name="jumlah_orang" required>
                    </div>
                    <div class="col-12">
                        <label for="jumlah_hari" class="form-label">Jumlah Hari</label>
                        <input type="number" class="form-control" id="jumlah_hari" name="jumlah_hari" required>
                    </div>
                    <div class="col-12">
                        <label for="total_harga" class="form-label">Total Tagihan</label>
                        <input type="number" class="form-control" id="total_harga" name="total_harga" readonly>
                    </div>
                    <hr class="my-4">
                    <button class="w-100 btn btn-primary btn-lg" name="submitForm" type="submit">Submit Pesanan</button>
                </div>
            </form>

        </div>
    </div>


      <!-- Notif Berhasil Input Pesanan -->
        <?php if (isset($_SESSION['addDataSukses'])) : ?>
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                    <div class="toast-header">
                        <strong class="me-auto poppins-semibold">Pariwisata Nusantara</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body poppins-regular">
                    Berhasil Pesan Paket Wisata <br><hr>
                    Lihat Di Menu Pesanan Untuk Melihat History Pesanan
                </div>
            </div>
            <?php unset($_SESSION['addDataSukses']); ?>
        <?php endif; ?>


<script>
        document.addEventListener('DOMContentLoaded', function () {
            //Panggil id setiap form input
            const paketWisata = document.getElementById('paket_wisata');
            const fasilitas = document.querySelectorAll('.fasilitas');
            const jumlahOrang = document.getElementById('jumlah_orang');
            const jumlahHari = document.getElementById('jumlah_hari');
            const totalHarga = document.getElementById('total_harga');

            function totalTagihan() {
                let total = 0;

                // Ambil data harga yang telah di pilih
                const pilihPaket = paketWisata.options[paketWisata.selectedIndex];
                const paketHarga = parseInt(pilihPaket.getAttribute('data-harga') || 0);

                // Ambil Fasilitas yang dipilih
                let fasilitasTotal = 0;
                fasilitas.forEach(function (checkbox) {
                    const hiddenInput = document.getElementById(checkbox.getAttribute('data-hidden-id'));
                    if (checkbox.checked) {
                        fasilitasTotal += parseInt(checkbox.value);
                        hiddenInput.value = 1;
                    } else {
                        hiddenInput.value = 0;
                    }
                });

                // Hasil Perhitungan
                const orang = parseInt(jumlahOrang.value || 0);
                const hari = parseInt(jumlahHari.value || 0);
                total = (paketHarga + fasilitasTotal) * orang * hari;

                totalHarga.value = total;
            }

            paketWisata.addEventListener('change', totalTagihan);
            fasilitas.forEach(function (checkbox) {
                checkbox.addEventListener('change', totalTagihan);
            });
            jumlahOrang.addEventListener('input', totalTagihan);
            jumlahHari.addEventListener('input', totalTagihan);
        });

</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>