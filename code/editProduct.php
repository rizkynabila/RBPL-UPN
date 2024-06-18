<?php 
require_once ('conn.php');
session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
    header("location: login.php");
    exit;
}
$id = $_GET['id'];

$query = "SELECT * FROM produk WHERE kode_produk = '$id'";
$result = mysqli_query($conn, $query);
$produk = mysqli_fetch_assoc($result);

if(isset($_POST['submit'])){
  $nama = $_POST['nama_produk'];
  $harga = $_POST['harga_produk'];
  $query = "UPDATE produk SET nama_produk = '$nama', harga_produk = '$harga' WHERE kode_produk = '$id'";
  $result = mysqli_query($conn, $query);
  if ($result) {
    $log = "Produk berhasil diubah.";
  } else {
    $log = "Produk gagal diubah.";
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
                <h5 class="card-title fw-semibold mb-4">Edit Produk</h5>
                <form method="post" >
                  <div class="col-4 mb-3">
                        <label for="kode_produk" class="form-label"
                          >Kode Produk</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="kode_produk"
                          id="kode_produk" value="<?= $produk['kode_produk']?>" disabled/>
                      </div>
                    <div class="col-4 mb-3">
                        <label for="nama_produk" class="form-label"
                          >Nama Produk</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="nama_produk"
                          id="nama_produk" value="<?= $produk['nama_produk']?>"/>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="harga_produk" class="form-label"
                          >Harga Produk</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="harga_produk"
                          id="harga_produk" value="<?= $produk['harga_produk']?>"/>
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
