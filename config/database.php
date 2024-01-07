<?php
$remote = true;
if ($remote) {
    $conn = mysqli_connect("pk.rdnet.id:22987", "e-kasir", "e-kasir", "e-kasir") or die(mysqli_error($conn));
}
else {
    $conn = mysqli_connect("10.0.0.8", "e-kasir", "e-kasir", "e-kasir") or die(mysqli_error($conn));
}
?>

