<?php require_once "./../../views/layouts/header.php" ?>
<?php 
require_once "./../../function/menu.php";
require_once "./../../function/kasir.php";
$menus = getAllMenu();

if(isset($_POST["submit"])) {
    if(createTransaksi() > 0) {
        $transactionId = getLatestTransaksi();
        $uangBayar = $_POST["uang_bayar"];
        echo "<script>
            alert('Data berhasil ditambahkan');
            document.location.href = '" . BASE_URL . "/kasir/cetak.php?id=$transactionId&uang_bayar=$uangBayar';
        </script>";
    }else {
        echo "<script>
            alert('Data gagal ditambahkan');
            document.location.href = '" . BASE_URL . "/kasir/index.php';
        </script>";
    }
}
$transactions = getTransaksi();
?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Laporan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Selamat Datang</li>
        </ol>

        <div class="d-flex flex-column gap-3">     
            <div class="row">
                <div class="col">
                    <h5>Daftar Transaksi</h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="card-table">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Transaksi ID</th>
                                            <th>Tanggal</th>
                                            <th>Total</th>
                                            <th>Laba Bersih</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($transactions as $transaction) : ?>
                                        <tr>
                                            <td><?= $transaction["transaksi_id"] ?></td>
                                            <td><?= $transaction["tanggal"] ?></td>
                                            <td><?= $transaction["total"] ?></td>
                                            <td><?= $transaction["laba_bersih"] ?></td>
                                            <td>
                                                <a href="<?= BASE_URL ?>/kasir/detail.php?id=<?= $transaction["id"] ?>" class="btn btn-info">Lihat</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    // masukkan data ke cart dengan appendchild
    let total = 0;
    let products = [];
    function addToCart(menuId, menuName, menuPrice, menuStock) {
        if(menuStock == 0) {
            alert("Stok habis");
            return;
        }else {
            const nota = document.querySelector(".nota");
            const items = document.createElement("div");
            items.classList.add("d-flex", "gap-2", "justify-content-between", "mt-2");
            items.style.marginTop = "-10px";
            items.innerHTML = `
                <input type="hidden" value="${menuId}" name="product_id[]">
                <input class="nama-barang form-control" value=${menuName} readonly>
                <div class="action d-flex gap-2">
                    <input type="number" min="1" max="${menuStock}" class="harga-${menuId} form-control" style="width: 100px;" value="1" onchange="tambahTotal(${menuId}, ${menuPrice})" name="qty[]">
                    <button class="hapus-${menuId} btn btn-danger" onclick="removeCart(${menuId}, ${menuPrice})">X</button>
                </div>
            `; 
            nota.appendChild(items);
            total += menuPrice;
            document.querySelector(".total input").value = total;
            const pilihButton = document.querySelector(`.pilih-${menuId}`);
            pilihButton.style.display = "none";

            const product = {
                id: menuId,
                name: menuName,
                price: menuPrice,
                stock: menuStock
            }
            products.push(product);
        }   
    }

    function removeCart(menuId, menuPrice) {
        const nota = document.querySelector(".nota");
        const items = document.querySelector(`.harga-${menuId}`).parentElement.parentElement;
        const jumlah = document.querySelector(`.harga-${menuId}`).value;
        const product = products.find(product => product.id == menuId);
        const index = products.indexOf(product);
        products.splice(index, 1);
        total -= menuPrice * jumlah;
        document.querySelector(".total input").value = total;
        nota.removeChild(items);
        const pilihButton = document.querySelector(`.pilih-${menuId}`);
        pilihButton.style.display = "block";
    }

    function tambahTotal(menuId, menuPrice) {
        const harga = document.querySelector(`.harga-${menuId}`).value;
        const product = products.find(product => product.id == menuId);
        const index = products.indexOf(product);
        products[index].price = menuPrice * harga;
        total = 0;
        products.forEach(product => {
            total += product.price;
        });
        document.querySelector(".total input").value = total;
    }

    function bayar()
    {
        const bayar = document.querySelector(".bayar input").value;
        const kembalian = bayar - total;
        if(kembalian < 0) {
            document.querySelector(".kembalian h6").innerHTML = `Rp0`;
            return;
        }
        document.querySelector(".kembalian h6").innerHTML = `Rp${kembalian}`;
    }
</script>

<?php require_once "./../../views/layouts/footer.php" ?>
