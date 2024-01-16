<?php require_once "./../../views/layouts/header.php" ?>
<?php
require_once "./../../function/menu.php";

// Get All Menus
$menus = getAllMenu();
// Delete Menu
if(isset($_GET["id"])) {
    if(deleteMenu($_GET) > 0) {
        echo "<script>
            alert('Data berhasil dihapus');
            document.location.href = '".BASE_URL."/menu/index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal dihapus');
            document.location.href = '".BASE_URL."/menu/index.php';
        </script>";
    }
}
?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Menu</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Selamat Datang</li>
        </ol>
        <a href="<?= BASE_URL ?>/menu/create.php" class="btn btn-primary mb-3">+ Tambah Menu</a>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Data Menu
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Harga Jual</th>
                            <th>Harga Beli</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($menus as $menu) : ?>
                            <?php if(!$menu["deleted_at"]) :?>
                                <tr>
                                    <td><?= $menu["nama"] ?></td>
                                    <td><?= $menu["deskripsi"] ?></td>
                                    <td>Rp<?= $menu["harga_jual"] ?></td>
                                    <td>Rp<?= $menu["harga_beli"] ?></td>
                                    <td><?= $menu["stok"] ?></td>
                                    <td class="d-inline">
                                        <a href="<?= BASE_URL ?>/menu/edit.php?id=<?= $menu["id"] ?>" class="btn btn-warning mr-3">Edit</a>
                                        <a href="?id=<?= $menu["id"] ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin untuk menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php require_once "./../../views/layouts/footer.php" ?>