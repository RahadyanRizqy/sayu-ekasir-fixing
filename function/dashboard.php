<?php 
// Ambil konfigurasi database seperti koneksi dari config/database.php
include_once "./../../config/database.php";

function getSumTransaksiBulanan()
{
    global $conn;
    $query = mysqli_query($conn, "SELECT SUM(total) AS total FROM transaksi WHERE MONTH(tanggal) = MONTH(CURRENT_DATE())");
    $data = mysqli_fetch_assoc($query);
    return $data["total"];
}

function getSumTransaksiTotal()
{
    global $conn;
    $query = mysqli_query($conn, "SELECT SUM(total) AS total FROM transaksi");
    $data = mysqli_fetch_assoc($query);
    return $data["total"];
}

function getBarangTotal()
{
    global $conn;
    $query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk");
    $data = mysqli_fetch_assoc($query);
    return $data["total"];
}

function getTransaksiJumlah()
{
    global $conn;
    $query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM transaksi");
    $data = mysqli_fetch_assoc($query);
    return $data["total"];
}

function getBarangPie()
{
    global $conn;
    $query = mysqli_query($conn, "SELECT * FROM produk");
    $rows = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $rows[] = $row;
    }
    $label = [];
    $data = [];
    foreach($rows as $row) {
        $label[] = $row["nama"];
        $data[] = $row["stok"];
    }
    return [
        "label" => $label,
        "data" => $data
    ];
}

function getTransaksiArea()
{
    global $conn;
    $query = mysqli_query($conn, "SELECT DATE_FORMAT(tanggal, '%M') AS tanggal, SUM(total) AS total FROM transaksi WHERE YEAR(tanggal) = YEAR(CURRENT_DATE()) GROUP BY DATE_FORMAT(tanggal, '%M')");
    $rows = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $rows[] = $row;
    }
    $label = [];
    $data = [];
    foreach($rows as $row) {
        // ubah row tanggal ke month
        $row["tanggal"] = date("F", strtotime($row["tanggal"]));
        $label[] = $row["tanggal"];
        $data[] = $row["total"];
    }
    return [
        "label" => $label,
        "data" => $data
    ];
}

function getKeuntunganBersihTotal()
{
    global $conn;
    $query = mysqli_query($conn, "SELECT SUM(harga_jual - harga_beli) AS selisih FROM `produk` WHERE deleted_at IS NULL");
    if ($query) {
        $result = mysqli_fetch_assoc($query);
        return $result['selisih'];
    } else {
        return false;
    }
}

?>