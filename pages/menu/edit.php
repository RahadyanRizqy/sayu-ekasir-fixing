<?php require_once "./../../views/layouts/header.php" ?>
<?php
require_once "./../../function/menu.php";
if(isset($_GET["id"])) {
    $menu = getMenuById($_GET["id"]);
    if (isset($_POST["submit"])) {
        if (updateMenu($_POST) > 0) {
            echo "<script>
                alert('Data berhasil diubah');
                document.location.href = '" . BASE_URL . "/menu/index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal diubah');
                document.location.href = '" . BASE_URL . "/menu/index.php';
            </script>";
        }
    }
}
?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Update Menu</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Selamat Datang</li>
        </ol>
        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $menu["nama"] ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" required><?= $menu["deskripsi"] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga Jual</label>
                <input type="number" class="form-control" min="0" id="harga" name="harga" value="<?= $menu["harga_jual"] ?>" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga Beli</label>
                <input type="number" class="form-control" min="0" id="harga" name="harga" value="<?= $menu["harga_beli"] ?>" required>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" value="<?= $menu["stok"] ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</main>

<?php require_once "./../../views/layouts/footer.php" ?>