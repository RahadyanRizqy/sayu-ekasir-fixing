<?php 
require_once "./../../config/database.php";
function createTransaksi()
{
    if($_POST["uang_bayar"] < $_POST["uang_total"])
    {
        echo "<script>
            alert('Jumlah uang tidak cukup');
            document.location.href = '" . BASE_URL . "/kasir/index.php';
        </script>";
        return false;
    } else {
        global $conn;
        $transaction_identifier = "TRX-" . date("YmdHis") . rand(1000, 9999);
        $transaction_date = date("Y-m-d");
        $queryTransaction = "INSERT INTO transaksi(transaksi_id, tanggal, total) VALUES ('$transaction_identifier', '$transaction_date', '$_POST[uang_total]')";
        // masukkan ke database dan kembalikan id transaksi
        mysqli_query($conn, $queryTransaction);
        $transaction_id = mysqli_insert_id($conn);
    
        // tambah data transaksi detail
        $products = $_POST["product_id"];
        $qtys = $_POST["qty"];
        foreach($products as $key => $product)
        {
            $queryTransactionDetail = "INSERT INTO transaksi_detail(transaksi_id, produk_id, qty) VALUES ('$transaction_id', '$product', '$qtys[$key]')";
            mysqli_query($conn, $queryTransactionDetail);

            // kurangi stok produk
            $queryProduct = "UPDATE produk SET stok = stok - $qtys[$key] WHERE id = $product";
            mysqli_query($conn, $queryProduct);
        }
        return  mysqli_affected_rows($conn);
    }
}

function getLatestTransaksi()
{
    global $conn;
    $query = "SELECT * FROM transaksi ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["id"];
}

function getTransaksi()
{
    global $conn;
    // $query = "SELECT * FROM transaksi";
    $query = "SELECT t.id, t.transaksi_id, t.tanggal, t.total, SUM(p.harga_jual - p.harga_beli) AS laba_bersih FROM transaksi t JOIN transaksi_detail td ON t.id = td.transaksi_id JOIN produk p ON p.id = td.produk_id GROUP BY t.id, t.transaksi_id, t.tanggal, t.total;";
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result))
    {
        $rows[] = $row;
    }
    return $rows;
}

function getTransaksiById($id)
{
    global $conn;
    $query = "SELECT transaksi.*, transaksi_detail.qty, produk.nama, produk.harga_jual FROM transaksi JOIN transaksi_detail ON transaksi_detail.transaksi_id = transaksi.id JOIN produk ON produk.id = transaksi_detail.produk_id WHERE transaksi.id = $id";
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result))
    {
        $rows[] = $row;
    }
    return $rows;
}
?>