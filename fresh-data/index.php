<?php
include_once '../config/database.php';
global $conn;
$sqlFile = './e-kasir.sql';
$sql = file_get_contents($sqlFile);
if ($conn->multi_query($sql)) {
    echo "SQL file executed successfully";
} else {
    echo "Error executing SQL file: " . $conn->error;
}