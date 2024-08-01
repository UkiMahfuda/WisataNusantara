<?php
require 'function.php';

$id = $_GET['id'];



if (deleteData($id) > 0) {
    echo "
        <script>
        alert('Data Berhasil Dihapus');
        document.location.href='src/dashboard/index.php';
        </script>
        ";
} else {
    echo "
        <script>
        alert('Data gagal Dihapus');
        document.location.href='src/dashboard/index.php';
        </script>
        ";
}
