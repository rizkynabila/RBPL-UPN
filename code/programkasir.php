<?php 
date_default_timezone_set('Asia/Jakarta');
// kasir
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add'])) {
    $kode_produk = $_POST['id'];
    $jumlah = isset($_POST['jumlah']) ? intval($_POST['jumlah']) : 1; 

    $row = getProductById($kode_produk);
    
    if ($row) {
        if ($jumlah > $row['stok_produk']) {
            if($row['stok_produk'] == 0){
                $log = "Stok produk tidak tersedia.";
            }else{
                $log = "Jumlah yang diminta melebihi stok yang tersedia.";
            }
        } else {
            if (!isset($_SESSION['cart'][$kode_produk])) {
                $_SESSION['cart'][$kode_produk] = 0;
            }
            $stokSekarang = $row['stok_produk'] - $jumlah;
            $query = "UPDATE produk SET stok_produk = '$stokSekarang' WHERE kode_produk = '$kode_produk'";
            mysqli_query($conn, $query);

            if ($result) {
                $_SESSION['cart'][$kode_produk] += $jumlah;
                $log = "Produk berhasil ditambahkan ke keranjang dan stok diperbarui.";
            } else {
                $log = "Produk gagal ditambahkan ke keranjang dan terjadi kesalahan saat memperbarui stok.";
            }
            
        }
    } else {
        $log = "Produk tidak ditemukan.";
    }

    header("Location: transaction.php?message=" . urlencode($log));
    exit();
}
if (isset($_POST['edit'])) {
    $kode_produk = $_POST['kode_produk'];
    $jumlah_baru = $_POST['jumlah'];

    if (isset($_SESSION['cart'][$kode_produk])) {
        $row = getProductById($kode_produk, $conn);
        if ($row) {
            $jumlah_lama = $_SESSION['cart'][$kode_produk];
            $stok_sekarang = $row['stok_produk'];

            $selisih = $jumlah_baru - $jumlah_lama;
            $stok_baru = $stok_sekarang - $selisih;

            if ($stok_baru < 0) {
                $log = "Jumlah produk melebihi stok yang tersedia.";
            } else {
                $query = "UPDATE produk SET stok_produk = '$stok_baru' WHERE kode_produk = '$kode_produk'";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    $_SESSION['cart'][$kode_produk] = $jumlah_baru;
                    $log = "Produk berhasil diubah dan stok diperbarui.";
                } else {
                    $log = "Produk gagal diubah dan terjadi kesalahan saat memperbarui stok.";
                }
            }
            
        } else {
            $log = "Produk tidak ditemukan.";
        }
    } else {
        $log = "Produk tidak ditemukan dalam keranjang.";
    }

    header("Location: transaction.php?message=" . urlencode($log));
    exit();
}

if (isset($_POST['delete'])) {
    $kode_produk = $_POST['kode_produk'];

    if (isset($_SESSION['cart'][$kode_produk])) {

        $row = getProductById($kode_produk);
        if ($row) {
            $jumlah = $_SESSION['cart'][$kode_produk];
            $stok_baru = $row['stok_produk'] + $jumlah;

            $query = "UPDATE produk SET stok_produk = '$stok_baru' WHERE kode_produk = '$kode_produk'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                unset($_SESSION['cart'][$kode_produk]);
                $log = "Produk berhasil dihapus dan stok berhasil diperbarui.";
            } else {
                $log = "Produk gagl dihapus dan terjadi kesalahan saat memperbarui stok.";
            }

        } else {
            $log = "Produk tidak ditemukan.";
        }
    } else {
        $log = "Produk tidak ditemukan dalam keranjang.";
    }

    header("Location: transaction.php?message=" . urlencode($log));
    exit();
}

if(isset($_POST['bayar'])) {
    $kode_transaksi = $_POST['kode_transaksi'];
    $totaldibayar = $_POST['dibayar'];
    $totalasli = $_POST['total_harga'];
    $nama_pembeli = $_POST['nama_pembeli'];
    $jenisPembayaran = $_POST['pembayaran'];
    $kembalian = $totaldibayar - $totalasli;
    $tanggal = date('Y-m-d');
    $query = "INSERT INTO transaksi(kode_transaksi, tanggal_transaksi, nama_pembeli, total_harga, total_dibayar, kembalian, jenis_pembayaran) 
    VALUES ('$kode_transaksi','$tanggal','$nama_pembeli','$totalasli','$totaldibayar','$kembalian','$jenisPembayaran')";
    $result2 = mysqli_query($conn, $query);
    
    foreach ($_SESSION['cart'] as $kode_produk => $jumlah) {
        $query = "SELECT kode_transaksi_detail FROM transaksi_detail ORDER BY kode_transaksi_detail DESC LIMIT 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if (isset($row['kode_transaksi_detail'])) {
            $lastId = $row['kode_transaksi_detail'];
            $num = (int)substr($lastId, 5);
            $num++;
            $kode_transaksi_detail = 'BRT' . str_pad($num, 5, '0', STR_PAD_LEFT);
        } else {
            $kode_transaksi_detail = 'BRT00001';
        }
        $produk = getProductById($kode_produk);
        $totalharga = $produk['harga_produk'] * $jumlah;

        $query = "INSERT INTO transaksi_detail(kode_transaksi_detail, kode_transaksi, kode_produk, jumlah_produk) 
        VALUES ('$kode_transaksi_detail','$kode_transaksi','$kode_produk','$jumlah')";
        $result = mysqli_query($conn, $query);
    }

    if($result == TRUE && $result2 == TRUE){
        unset($_SESSION['cart']);
        unset($_SESSION['nama_pembeli']);
        $kembalian = 
        header("Location: transactionSuccess.php?id=".$kode_transaksi);
        exit();
    } else {
        $log = "Pembayaran Gagal.";
        header("Location: transaction.php?message=" . urlencode($log));
        exit();
    }
}

function getProductById($kode_produk) {
    global $conn;
    $query = "SELECT * FROM produk where kode_produk = '$kode_produk'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);    
    return $row;
}

?>