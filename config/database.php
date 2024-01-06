<?php
$remote = true;
if ($remote) {
    $conn = mysqli_connect("pk.rdnet.id:22987", "e-kasir", "e-kasir", "e-kasir") or die(mysqli_error($conn));
}
else {
    $conn = mysqli_connect("localhost", "root", "", "e-kasir") or die(mysqli_error($conn));
}
?>