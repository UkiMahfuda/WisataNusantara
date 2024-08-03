<?php
session_start();
require 'function.php';

$id = $_GET['id'];

if (deleteData($id) > 0) {
    $_SESSION['deleteDataSukses'] = true; 
    header("Location: src/dashboard/index.php");
    exit;
} else {
    $_SESSION['deleteDataGagal'] = true; 
    header("Location: src/dashboard/index.php");
    exit;
}