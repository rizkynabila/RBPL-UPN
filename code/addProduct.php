<?php 
require_once ('conn.php');
session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
    header("location: login.php");
    exit;
}
$query = "SELECT kode_produk FROM produk ORDER BY kode_produk DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$lastId = $row['kode_produk'];
if ($lastId) {
        $num = (int)substr($lastId, 3);
        $num++;
        $kode_produk_baru = 'ACS' . str_pad($num, 3, '0', STR_PAD_LEFT);
    } else {
        $kode_produk_baru = 'ACS001';
    }

if(isset($_POST['submit'])){
  $nama = $_POST['nama_produk'];
  $harga = $_POST['harga_produk'];
  $stock = $_POST['stock'];
  $query = "INSERT INTO produk (kode_produk, nama_produk, harga_produk, stok_produk) VALUES ('$kode_produk_baru','$nama', '$harga','$stock')";
  $result = mysqli_query($conn, $query);
  if ($result) {
    $log = "Produk berhasil ditambahkan.";
  } else {
    $log = "Produk gagal ditambahkan.";
  }
    header("Location: product.php?message=" . urlencode($log));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Produk | Barokah</title>
    <link
      rel="shortcut icon"
      type="image/png"
      href="../assets/images/icon.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
  </head>

  <?php 
include "header.php";
?>
        <div class="container-fluid">
          <div class="container-fluid">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Tambah Produk</h5>
                <form method="post" >
                  <div class="col-4 mb-3">
                        <label for="kode_produk" class="form-label"
                          >Kode Produk</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="kode_produk"
                          id="kode_produk" value="<?= $kode_produk_baru ?>" disabled/>
                      </div>
                    <div class="col-4 mb-3">
                        <label for="nama_produk" class="form-label"
                          >Nama Produk</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="nama_produk"
                          id="nama_produk"/>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="harga_produk" class="form-label"
                          >Harga Produk</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="harga_produk"
                          id="harga_produk"/>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="stock" class="form-label"
                          >Stock</label
                        >
                        <input
                          type="number"
                          class="form-control"
                          name="stock"
                          id="stock"/>
                    </div>
                  <a href="javascript:history.back()" class="btn btn-danger" rel="prev">Kembali</a>
                  <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
  </body>
</html>
