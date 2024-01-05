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
        <h1 class="mt-4">Kasir</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Selamat Datang</li>
        </ol>

        <div class="d-flex flex-column gap-3">
            <div class="row">
                <div class="col-lg-7">
                    <h5>Pesanan</h5>
                    <div class="card">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th>Harga Jual</th>
                                        <th>Harga Beli</th>
                                        <th>Stok</th>
                                        <th>Pilih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($menus as $menu) : ?>
                                        <?php if(!$menu["deleted_at"]): ?>
                                            <tr>
                                                <td><?= $menu["nama"] ?></td>
                                                <td><?= $menu["deskripsi"] ?></td>
                                                <td>Rp<?= $menu["harga_jual"] ?></td>
                                                <td>Rp<?= $menu["harga_beli"] ?></td>
                                                <td><?= $menu["stok"] ?></td>
                                                <td class="d-inline">
                                                    <button class="pilih-<?= $menu["id"] ?> btn btn-primary" onclick="addToCart(<?= $menu['id'] ?>, '<?= $menu['nama'] ?>', <?= $menu['harga_jual'] ?>, <?= $menu['stok'] ?>)">
                                                        Pilih
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <h5>Nota</h5>
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST">
                                <p>Item :</p>
                                <div class="nota " style="margin-top: -10px;">
                                    
                                </div>
                                <div class="mt-2">
                                    <div class="total d-flex gap-2 justify-content-between">
                                        <p>Harga Total:</p>
                                        <input type="number" class="form-control" style="width: 150px;" readonly value="0" name="uang_total">
                                    </div>
                                    <div class="bayar d-flex gap-2 justify-content-between mt-2">
                                        <p>Harga Bayar:</p>
                                        <input type="number" class="form-control" style="width: 150px;" onkeyup="bayar()" name="uang_bayar">
                                    </div>
                                    <div class="kembalian d-flex gap-2 justify-content-between mt-2">
                                        <p>Harga Kembalian:</p>
                                        <h6>Rp0</h6>
                                    </div>
                                    <div class="d-flex justify-content-end mt-3">
                                        <button name="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
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
