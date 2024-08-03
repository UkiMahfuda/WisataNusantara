<?php
$conn = mysqli_connect("localhost:3307", "root", "", "db_pariwisata");

// if (!$conn) {
//     die("Connection Failed: ");
// } else {
//     echo ("Connection Success");
// }


// Fungsi Register
function daftarAccount($dataUsers)
{
    global $conn;

    $name = strtolower(stripslashes($dataUsers["name"]));
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

//Fungsi Tambah Data 
function addData($id)
{
    global $conn;
    $nama_paket = htmlspecialchars($id["nama_paket"]);
    $deskripsi = htmlspecialchars($id["deskripsi"]);
    $harga = htmlspecialchars($id["harga"]);
    $durasi = htmlspecialchars($id["durasi"]);
    $pcs = htmlspecialchars($id["pcs"]);
    $gambar = uploadGambar();
    if (!$gambar) {
        return false;
    }
    //Tambahkan query untuk memasukkan data ke tbl
    $insert = "INSERT INTO paket_wisata VALUES ('','$nama_paket','$deskripsi','$harga','$durasi','$gambar','$pcs')";

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
