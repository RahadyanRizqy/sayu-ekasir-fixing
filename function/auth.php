<?php 
// Ambil konfigurasi database seperti koneksi dari config/database.php
include_once "./../../config/database.php";

// function register($httpMethod)
// {
//     global $conn;
//     $username = htmlspecialchars($httpMethod["username"]);
//     $password = htmlspecialchars($httpMethod["password"]);
//     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//     $query = mysqli_query($conn, "INSERT INTO admin(nama, password) VALUES('$username', '$hashedPassword')");
//     return mysqli_affected_rows($conn);
// }

function login($httpMethod)
{
    global $conn;
    $username = htmlspecialchars($httpMethod["username"]);
    $password = htmlspecialchars($httpMethod["password"]);
    $query = mysqli_query($conn, "SELECT * FROM admin WHERE nama = '$username'");
    $data = mysqli_fetch_assoc($query);
    if ($data) {
        if (password_verify($password, $data["password"])) {
            $_SESSION["login"] = true;
            $_SESSION["username"] = $username;
            return true;
        }
    }
    return false;
}

function logout()
{
    session_start();
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}
?>