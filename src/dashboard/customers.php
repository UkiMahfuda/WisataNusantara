<?php
session_start();
require "../../function.php";


$query = getData("SELECT * FROM paket_wisata ORDER BY id DESC");

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.88.1">
  <title>Dashboard Admin | Pariwisata Nusantara</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">
  <link href="dashboard.css" rel="stylesheet">

</head>
<body>
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 poppins-semibold no-spacing fs-5" href="#">Pariwiwsata <br>Nusantara
    </a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
      data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </header>

  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="index.php">
                <span data-feather="home"></span>
                Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="#">
                <span data-feather="file"></span>
                Pesanan Customers
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../index.php">
                <span data-feather="arrow-left-circle"></span>
                Kembali Ke Website
              </a>
            </li>
            <hr class="my-4">
            <?php if (isset($_SESSION['email'])) : ?>
            <li class="nav-item">
              <a class="nav-link" href="../../logout.php">
                <span data-feather="log-out"></span>
                Logout
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </nav>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h2>Pesanan Wisata Customers</h2>

        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Pemesan</th>
                <th scope="col">Nama Paket</th>
                <th scope="col">Tgl Pesan</th>
                <th scope="col">Durasi</th>
                <th scope="col">Jumlah Orang</th>
                <th scope="col">Total Harga</th>
                <th scope="col">Option</th>
              </tr>
            </thead>
            <tbody>
              
              <tr >
                <td></td>
                <td></td>
                <td></td>                
                <td></td>
                <td></td>                
                <td></td>
                <td></td>
                <td>
                  <div class="d-flex justify-content-start">
                      <button class="btn btn-primary px-2 pt-0 pb-1" data-bs-toggle="modal" data-bs-target="#updatePaketWisata">
                        <span data-feather="edit"></span>
                      </button>
                    <div class="mx-1"></div>
                    <a href="../../delete.php?id= <?php echo $getData['id'] ?> ">
                      <button class="btn btn-danger px-2 pt-0 pb-1">
                        <span data-feather="delete"></span>
                      </button>  
                    </a>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>

 <!-- PopUp Update Paket Wisata -->
        <div class="modal fade" id="updatePaketWisata" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updatePaketWisataLabel" aria-hidden="true">
          <div class="modal-dialog ">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="updatePaketWisataLabel">Form Update Paket Wisata</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
            <form>
              <div class="modal-body ">
                  <div class="mb-3">
                    <label for="nama_paket" class="form-label">Nama Paket Wisata</label>
                    <input type="text" class="form-control" id="nama_paket" name="nama_paket">
                  </div>
                  <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2"></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga">
                  </div>
                  <div class="mb-3">
                    <label for="durasi" class="form-label">Durasi</label>
                    <input type="number" class="form-control" id="durasi" name="durasi">
                  </div>
                  <div class="mb-3">
                    <label for="pcs" class="form-label">Jumlah Orang</label>
                    <input type="number" class="form-control" id="pcs" name="pcs">
                  </div>
                  <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Wisata</label>
                    <input class="form-control" type="file" id="gambar" name="gambar">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                  <button type="button" class="btn btn-primary">Update</button>
                </div>
              </div>
            </form>
            </div>
          </div>
        </div>


  <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
    integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
    integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha"
    crossorigin="anonymous"></script>
  <script src="dashboard.js"></script>
</body>

</html>