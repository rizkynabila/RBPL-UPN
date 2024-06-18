<?php
include_once ('conn.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM produk WHERE kode_produk = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $log = "Produk berhasil dihapus.";
    } else {
        $log = "Produk gagal dihapus.";
    }
    header("Location: product.php?message=" . urlencode($log));
    exit();
} else {
    header("Location: product.php");
    exit();
}
?>
