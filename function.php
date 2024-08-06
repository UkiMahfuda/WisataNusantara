<?php
$conn = mysqli_connect("localhost:3307", "root", "", "db_pariwisata");

// if (!$conn) {
//     die("Koensi DB Gagal: ");
// } else {
//     echo ("Koensi DB Sukses");
// }


// Fungsi Register
function daftarAccount($dataUsers)
{
    global $conn;

    $name = $dataUsers["name"];
    $email = mysqli_real_escape_string($conn, $dataUsers["email"]);
    $password = mysqli_real_escape_string($conn, $dataUsers["password"]);

    $result = mysqli_query($conn, "SELECT email FROM users WHERE email='$email'");
    if (mysqli_fetch_row($result)) {
        return false;
    };

    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users VALUES 
('','$name','$email','$password','')");

    return mysqli_affected_rows($conn);
}


// Fungsi Ambil Data
function getData($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $array = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
    return $array;
}


// Fungsi Hapus Data
function deleteData($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM paket_wisata WHERE id = '$id'");

    return mysqli_affected_rows($conn);
}

function deleteDataPemesanan($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM pemesanan WHERE id_pemesanan = '$id'");

    return mysqli_affected_rows($conn);
}

//Fungsi Update
function updateData($data)
{
    global $conn;

    $id_paket = $data["id"];
    $nama_paket = htmlspecialchars($data["nama_paket"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $harga = htmlspecialchars($data["harga"]);
    $durasi = htmlspecialchars($data["durasi"]);
    $gambar = isset($data["gambar"]) ? htmlspecialchars($data["gambar"]) : '';

    $updateData = "UPDATE paket_wisata SET 
        nama_paket ='$nama_paket',
        deskripsi = '$deskripsi',
        harga = '$harga',
        durasi ='$durasi'";
    
    if ($gambar) {
        $updateData .= ", gambar='$gambar'";
    }

    $updateData .= " WHERE id= '$id_paket'";

    mysqli_query($conn, $updateData);
    return mysqli_affected_rows($conn);
}

//Fungsi Ambil data by id
function getDataById($conn) {
    if (isset($_POST['edit_id'])) {
        $id = $_POST['edit_id'];
        // Ambil data berdasarkan id
        $query = "SELECT * FROM paket_wisata WHERE id = $id";
        $result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($result);
    }
    return null;
}

function handleUpdateData($updateData, $file) {
    global $conn;

    $id_paket = $updateData["id"];
    $nama_paket = htmlspecialchars($updateData["nama_paket"]);
    $deskripsi = htmlspecialchars($updateData["deskripsi"]);
    $harga = htmlspecialchars($updateData["harga"]);
    $durasi = htmlspecialchars($updateData["durasi"]);
    $gambar = $updateData['existing_gambar'];

    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $file['tmp_name'];
        $fileName = $file['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = '../../asset/img/';
            $dest_path = $uploadFileDir . $newFileName;

            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $gambar = $newFileName;
            } else {
                return 'Gagal upload gambar';
            }
        } else {
            return 'File gambar tidak sesuai';
        }
    }

    $updateData['gambar'] = $gambar;
    $updated = updateData($updateData);

    if ($updated > 0) {
        
        return true;
    } else {
        return "Update Data Paket Gagal: " . mysqli_error($conn);
    }
}



//Fungsi Tambah Data Paket Wisata
function addData($id)
{
    global $conn;
    $nama_paket = htmlspecialchars($id["nama_paket"]);
    $deskripsi = htmlspecialchars($id["deskripsi"]);
    $harga = htmlspecialchars($id["harga"]);
    $durasi = htmlspecialchars($id["durasi"]);
    $gambar = uploadGambar();
    if (!$gambar) {
        return false;
    }
    $insert = "INSERT INTO paket_wisata VALUES ('','$nama_paket','$deskripsi','$harga','$durasi','$gambar')";

    mysqli_query($conn, $insert);
    return mysqli_affected_rows($conn);
}

//Fungsi Tambah Data Pemesanan
function addDataPemesanan($data)
{
    global $conn;
    $id_user = htmlspecialchars($data["id_user"]);
    $id_paket = htmlspecialchars($data["paket_wisata"]);
    $tanggal_pemesanan = htmlspecialchars($data["tanggal_pemesanan"]);
    $jumlah_orang = htmlspecialchars($data["jumlah_orang"]);
    $total_harga = htmlspecialchars($data["total_harga"]);
    $jumlah_hari = htmlspecialchars($data["jumlah_hari"]);
    $transportasi = isset($data["fasilitas_transportasi"]) ? $data["fasilitas_transportasi"] : 0;
    $penginapan = isset($data["fasilitas_penginapan"]) ? $data["fasilitas_penginapan"] : 0;
    $makan = isset($data["fasilitas_makan"]) ? $data["fasilitas_makan"] : 0;

    $insert = "INSERT INTO pemesanan (id_user, id_paket, tanggal_pemesanan, jumlah_orang, total_harga, jumlah_hari, transportasi, makan, penginapan) 
    VALUES ('$id_user','$id_paket','$tanggal_pemesanan','$jumlah_orang','$total_harga','$jumlah_hari','$transportasi','$makan','$penginapan')";

    mysqli_query($conn, $insert);
    return mysqli_affected_rows($conn);
}



function uploadGambar()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // Cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('Yang anda upload bukan gambar!');
              </script>";
        return false;
    }

    // Cek ukuran gambar
    if ($ukuranFile > 1000000) {
        echo "<script>
                alert('Ukuran gambar terlalu besar!');
              </script>";
        return false;
    }

    // Ubah nama gambar
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    $targetDir = '../../asset/img/';  

    // Gabungkan path dan nama file
    $targetPath = $targetDir . $namaFileBaru;

    if (move_uploaded_file($tmpName, $targetPath)) {
        return $namaFileBaru; 
    } else {
        return false; 
    }
}
