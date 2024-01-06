<?php 
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: ./../auth/login.php");
    exit;
}
?>
<?php 
require "./../../function/kasir.php";
$transaksi = getTransaksiById($_GET["id"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nota - <?= $transaksi[0]["transaksi_id"] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body{
            margin-top:20px;
            background:#87CEFA;
        }

        .card-footer-btn {
            display: flex;
            align-items: center;
            border-top-left-radius: 0!important;
            border-top-right-radius: 0!important;
        }
        .text-uppercase-bold-sm {
            text-transform: uppercase!important;
            font-weight: 500!important;
            letter-spacing: 2px!important;
            font-size: .85rem!important;
        }
        .hover-lift-light {
            transition: box-shadow .25s ease,transform .25s ease,color .25s ease,background-color .15s ease-in;
        }
        .justify-content-center {
            justify-content: center!important;
        }
        .btn-group-lg>.btn, .btn-lg {
            padding: 0.8rem 1.85rem;
            font-size: 1.1rem;
            border-radius: 0.3rem;
        }
        .btn-dark {
            color: #fff;
            background-color: #1e2e50;
            border-color: #1e2e50;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(30,46,80,.09);
            border-radius: 0.25rem;
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .p-5 {
            padding: 3rem!important;
        }
        .card-body {
            flex: 1 1 auto;
            padding: 1.5rem 1.5rem;
        }

        tbody, td, tfoot, th, thead, tr {
            border-color: inherit;
            border-style: solid;
            border-width: 0;
        }

        .table td, .table th {
            border-bottom: 0;
            border-top: 1px solid #edf2f9;
        }
        .table>:not(caption)>*>* {
            padding: 1rem 1rem;
            background-color: var(--bs-table-bg);
            border-bottom-width: 1px;
            box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
        }
        .px-0 {
            padding-right: 0!important;
            padding-left: 0!important;
        }
        .table thead th, tbody td, tbody th {
            vertical-align: middle;
        }
        tbody, td, tfoot, th, thead, tr {
            border-color: inherit;
            border-style: solid;
            border-width: 0;
        }

        .mt-5 {
            margin-top: 3rem!important;
        }

        .icon-circle[class*=text-] [fill]:not([fill=none]), .icon-circle[class*=text-] svg:not([fill=none]), .svg-icon[class*=text-] [fill]:not([fill=none]), .svg-icon[class*=text-] svg:not([fill=none]) {
            fill: currentColor!important;
        }
        .svg-icon>svg {
            width: 1.45rem;
            height: 1.45rem;
        }
    </style>
</head>
<body>
<div class="container mt-6 mb-7">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-xl-7">
            <div class="card">
                <div class="card-body p-5">
                    <div class="text-muted">
                        <h1 class="text-center">DV JUICE AND SALAD</h1>
                    </div>
                    <div class="border-top border-gray-200 pt-4 mt-4">
                        <div class="row">
                            <div class="col-md-6">
                            <div class="text-muted mb-2">No. Transaksi</div>
                            <strong>#<?= $transaksi[0]["transaksi_id"] ?></strong>
                            </div>
                            <div class="col-md-6 text-md-end">
                            <div class="text-muted mb-2">Tanggal Transaksi</div>
                            <strong><?= $transaksi[0]["tanggal"] ?></strong>
                            </div>
                        </div>
                    </div>

                    <table class="table border-bottom border-gray-200 mt-3">
                    <thead>
                        <tr>
                        <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm px-0">Deskripsi</th>
                        <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm px-0">Jumlah</th>
                        <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm text-end px-0">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $total = 0;
                            foreach($transaksi as $item) : 
                        ?>
                        <tr>
                            <td class="px-0"><?= $item["nama"] ?></td>
                            <td class="px-0"><?= $item["qty"] ?></td>
                            <td class="text-end px-0">Rp<?= $item["qty"] * $item["harga_jual"] ?></td>
                        </tr>
                        <?php
                            $total += $item["qty"] * $item["harga_jual"];
                            endforeach;
                        ?>
                    </tbody>
                    </table>

                    <div class="mt-5">
                    <div class="d-flex justify-content-end">
                        <p class="text-muted me-3">Harga Total:</p>
                        <span>Rp<?= $total ?></span>
                    </div>
                    <div class="d-flex justify-content-end">
                        <p class="text-muted me-3">Harga Bayar</p>
                        <span>Rp<?= $_GET["uang_bayar"] ?></span>
                    </div>
                    <div class="d-flex justify-content-end">
                    <p class="text-muted me-3">Kembalian</p>
                    <span>Rp<?= $_GET["uang_bayar"] - $total ?></span>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    window.onload = function () {
        window.print();
    }
</script>
</body>
</html>