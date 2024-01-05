<?php require_once "./../../config/constants.php" ?>
<?php 
require_once "./../../function/auth.php";
if (isset($_POST["logout"])) {
    logout();
}
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Menu</div>
                <a class="nav-link" href="<?= BASE_URL ?>/dashboard/index.php">
                    <div class="sb-nav-link-icon"><i class="far fa-hourglass"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="<?= BASE_URL ?>/menu/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Menu
                </a>
                <a class="nav-link" href="<?= BASE_URL ?>/kasir/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                    Kasir
                </a>
                <a class="nav-link" href="<?= BASE_URL ?>/laporan/index.php">
                    <div class="sb-nav-link-icon"><i class="far fa-file-alt"></i></div>
                    Laporan
                </a>
                <form action="" method="POST" class="nav-link">
                    <button type="submit" name="logout" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?= $_SESSION["username"] ?>
        </div>
    </nav>
</div>