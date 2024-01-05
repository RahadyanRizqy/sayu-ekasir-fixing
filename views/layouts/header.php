<?php 
session_start();
include_once "./../../function/auth.php";
if (!isset($_SESSION["login"])) {
    header("Location: ./../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="./../../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="sb-nav-fixed">
    <!-- Topbar -->
    <?php require_once "./../../views/components/topbar.php" ?>
    <!-- End of Topbar -->

    <div id="layoutSidenav">
        <!-- Sidebar -->
        <?php require_once "./../../views/components/sidebar.php" ?>
        <!-- End of Sidebar -->
        <div id="layoutSidenav_content">