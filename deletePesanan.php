<?php
session_start();
require 'function.php';

$id = $_GET['id_pemesanan'];

if (deleteDataPemesanan($id) > 0) {
    $_SESSION['deleteDataSukses'] = true; 
    header("Location: pesanan.php");
    exit;
} else {
    $_SESSION['deleteDataGagal'] = true; 
    header("Location: pesanan.php");
    exit;
}