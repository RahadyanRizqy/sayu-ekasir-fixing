<?php 
// Ambil konfigurasi database seperti koneksi dari config/database.php
include_once "./../../config/database.php";

function getAllMenu(){
    global $conn;
    $query = mysqli_query($conn, "SELECT * FROM produk");
    $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
    return $data;
}

function getMenuById($id){
    global $conn;
    $query = mysqli_query($conn, "SELECT * FROM produk WHERE id = $id");
    $data = mysqli_fetch_assoc($query);
    return $data;
}

function createMenu($httpMethod)
{
    global $conn;
    $nama = htmlspecialchars($httpMethod["nama"]);
    $deskripsi = htmlspecialchars($httpMethod["deskripsi"]);
    $harga = htmlspecialchars($httpMethod["harga"]);
    $stok = htmlspecialchars($httpMethod["stok"]);
    // create
    $query = "INSERT INTO produk(nama, deskripsi, harga, stok) VALUES ('$nama', '$deskripsi', '$harga', '$stok')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function deleteMenu($httpMethod)
{
    global $conn;
    $id = $httpMethod["id"];
    $query = "UPDATE produk SET deleted_at = NOW() WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function updateMenu($httpMethod)
{
    global $conn;
    $id = $_GET["id"];
    $nama = htmlspecialchars($httpMethod["nama"]);
    $deskripsi = htmlspecialchars($httpMethod["deskripsi"]);
    $harga = htmlspecialchars($httpMethod["harga"]);
    $stok = htmlspecialchars($httpMethod["stok"]);
    // update
    $query = "UPDATE produk SET nama = '$nama', deskripsi = '$deskripsi', harga = '$harga', stok = '$stok' WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

?>