<?php
session_start();
require "../../function.php";

if(isset($_POST['btnAddDataPaket'])){
  if(addData($_POST)>=0){
    $_SESSION['addDataSukses'] = true; 
  }else{
     $_SESSION['addDataGagal'] = true; 
   }
}

$query = getData("SELECT * FROM paket_wisata ORDER BY id DESC");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['edit_id']) || isset($_POST['update'])) {
      $data = getDataById($conn);

      if (isset($_POST['update'])) {
          $updateData = [
              'id' => $_POST['id'],
              'nama_paket' => $_POST['nama_paket'],
              'deskripsi' => $_POST['deskripsi'],
              'harga' => $_POST['harga'],
              'durasi' => $_POST['durasi'],
              'pcs' => $_POST['pcs'],
              'existing_gambar' => $_POST['existing_gambar']
          ];

          $file = $_FILES['gambar'];

          $result = handleUpdateData($updateData, $file);
          if ($result === true) {
              $_SESSION['updateSukses'] = true;
              header("Location: index.php");
              exit();
          } else {
              $_SESSION['updateGagal'] = $result;
          }
      }
  }
}


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
              <a class="nav-link active" aria-current="page" href="#">
                <span data-feather="home"></span>
                Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="customers.php">
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
        <h2>Paket Wisata</h2>

        <button type="button" class="my-3 btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahPaketWisata">
          Tambah Paket Wisata
        </button>

        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Paket</th>
                <th scope="col">Deskripsi</th>
                <th scope="col">Harga</th>
                <th scope="col">Durasi</th>
                <th scope="col">Pcs</th>
                <th scope="col">Option</th>
              </tr>
            </thead>
            <tbody>
            <?php $no = 1;?> 
            <?php foreach ($query as $getData) : ?>
              <tr >
                <td><?php echo $no ?></td>
                <td><?php echo $getData['nama_paket'] ?></td>
                <td class="text-truncate" style="max-width: 200px;"><?php echo $getData['deskripsi'] ?></td>
                <td>Rp.<?php echo $getData['harga'] ?></td>                
                <td><?php echo $getData['durasi'] ?> Hari</td>
                <td><?php echo $getData['pcs'] ?> Orang</td>
                <td>
                  <div class="d-flex justify-content-start">
                      <form method="post" action="">
                          <input type="hidden" name="edit_id" value="<?php echo $getData['id']; ?>">
                          <button class="btn btn-primary px-2 pt-0 pb-1" type="submit" data-id="<?php echo $getData['id']; ?>" data-bs-toggle="modal" data-bs-target="#updatePaketWisata">
                        <span data-feather="edit"></span>
                      </button>
                      </form>
                    <div class="mx-1"></div>
                    <a href="../../delete.php?id= <?php echo $getData['id'] ?> ">
                      <button class="btn btn-danger px-2 pt-0 pb-1">
                        <span data-feather="delete"></span>
                      </button>  
                    </a>
                  </div>
                </td>
              </tr>
            <?php $no++; ?>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>

  


  <!-- PopUp Form Tambah Paket Wisata -->
        <div class="modal fade" id="tambahPaketWisata" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tambahPaketWisataLabel" aria-hidden="true">
          <div class="modal-dialog ">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="tambahPaketWisataLabel">Form Tambah Paket Wisata</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="modal-body ">
                  <div class="mb-3">
                    <label for="nama_paket" class="form-label">Nama Paket Wisata</label>
                    <input type="text" class="form-control" id="nama_paket" name="nama_paket" required>
                  </div>
                  <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2" required></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" required>
                  </div>
                  <div class="mb-3">
                    <label for="durasi" class="form-label">Durasi</label>
                    <input type="number" class="form-control" id="durasi" name="durasi" required>
                  </div>
                  <div class="mb-3">
                    <label for="pcs" class="form-label">Jumlah Orang</label>
                    <input type="number" class="form-control" id="pcs" name="pcs" required>
                  </div>
                  <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Wisata</label>
                    <input class="form-control" type="file" id="gambar" name="gambar" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                  <button type="submit" class="btn btn-primary" name="btnAddDataPaket">Tambah</button>
                </div>
              </div>
            </form>
            </div>
          </div>
        </div>

  <!-- PopUp Form Update Paket Wisata -->
    <?php if (isset($data)) : ?>
      <div class="modal fade show d-block" id="updatePaketWisata" tabindex="-1" aria-labelledby="updatePaketWisataLabel" aria-hidden="true">
        <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h1 class="modal-title fs-5" id="updatePaketWisataLabel">Form Update Paket Wisata</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.history.back();"></button>
                  </div>
                  <form method="post" action="" enctype="multipart/form-data">
                      <div class="modal-body">
                          <div class="mb-3">
                              <label for="nama_paket" class="form-label">Nama Paket Wisata</label>
                              <input type="text" class="form-control" id="nama_paket" name="nama_paket" value="<?php echo $data['nama_paket']; ?>">
                          </div>
                          <div class="mb-3">
                              <label for="deskripsi" class="form-label">Deskripsi</label>
                              <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2"><?php echo $data['deskripsi']; ?></textarea>
                          </div>
                          <div class="mb-3">
                              <label for="harga" class="form-label">Harga</label>
                              <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $data['harga']; ?>">
                          </div>
                          <div class="mb-3">
                              <label for="durasi" class="form-label">Durasi</label>
                              <input type="number" class="form-control" id="durasi" name="durasi" value="<?php echo $data['durasi']; ?>">
                          </div>
                          <div class="mb-3">
                              <label for="pcs" class="form-label">Jumlah Orang</label>
                              <input type="number" class="form-control" id="pcs" name="pcs" value="<?php echo $data['pcs']; ?>">
                          </div>
                          <div class="mb-3">
                              <label for="gambar" class="form-label">Gambar Wisata</label>
                              <input class="form-control" type="file" id="gambar" name="gambar">
                              <input type="hidden" name="existing_gambar" value="<?php echo $data['gambar']; ?>">

                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                          <button type="submit" name="update" class="btn btn-primary">Update</button>
                      </div>
                      <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                  </form>
              </div>
          </div>
      </div>
    <?php endif; ?>

  <!-- Notif Berhasil Tambah Data -->
        <?php if (isset($_SESSION['addDataSukses'])) : ?>
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                    <div class="toast-header">
                        <strong class="me-auto poppins-semibold">Pariwisata Nusantara</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body poppins-regular">
                        Berhasil Tambah Data
                    </div>
                </div>
            </div>
          <?php unset($_SESSION['addDataSukses']); ?>
        <?php endif; ?>

  <!-- Notif Gagal Tambah Data -->
        <?php if (isset($_SESSION['addDataGagal'])) : ?>
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                    <div class="toast-header">
                        <strong class="me-auto poppins-semibold">Pariwisata Nusantara</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body poppins-regular">
                        Gagal Tambah Data
                    </div>
                </div>
            </div>
          <?php unset($_SESSION['addDataGagal']); ?>
        <?php endif; ?>

  <!-- Notif Berhasil Hapus Data -->
        <?php if (isset($_SESSION['deleteDataSukses'])) : ?>
          <div class="toast-container position-fixed bottom-0 end-0 p-3">
              <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                  <div class="toast-header">
                      <strong class="me-auto poppins-semibold">Pariwisata Nusantara</strong>
                      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                  </div>
                  <div class="toast-body poppins-regular">
                      Berhasil Hapus Data
                  </div>
              </div>
          </div>
        <?php unset($_SESSION['deleteDataSukses']); ?>
      <?php endif; ?>

    <!-- Notif Gagal Hapus Data -->
        <?php if (isset($_SESSION['deleteDataGagal'])) : ?>
          <div class="toast-container position-fixed bottom-0 end-0 p-3">
              <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                  <div class="toast-header">
                      <strong class="me-auto poppins-semibold">Pariwisata Nusantara</strong>
                      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                  </div>
                  <div class="toast-body poppins-regular">
                      Gagal Hapus Data
                  </div>
              </div>
          </div>
        <?php unset($_SESSION['deleteDataGagal']); ?>
      <?php endif; ?>
      


<!-- Fungsi Untuk menampilkah modal -->
      <script>
        document.addEventListener('DOMContentLoaded', (event) => {
          const updateModal = document.getElementById('updatePaketWisata');
          updateModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
          });
        });
      </script>


<!-- Fungsi Untuk menampilkah notif -->
    <script>
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl, {
                autohide: false
            }).show()
        })
    </script>

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