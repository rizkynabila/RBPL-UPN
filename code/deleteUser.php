<?php
include_once ('conn.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM users WHERE user_id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $log = "User berhasil dihapus.";
    } else {
        $log = "User gagal dihapus.";
    }
    header("Location: user.php?message=" . urlencode($log));
    exit();
} else {
    header("Location: user.php");
    exit();
}
?>
