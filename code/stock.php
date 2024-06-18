<?php 
include_once ('conn.php');
session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
    header("location: login.php");
    exit;
}

$query = "SELECT * FROM produk";
$result = mysqli_query($conn, $query);

if(isset($_POST['submit'])){
  $id = $_POST['id'];
  $stock = $_POST['stock'];
  $query = "UPDATE produk SET stok_produk = '$stock' WHERE kode_produk = '$id'";
  $result = mysqli_query($conn, $query);
  if ($result) {
    $log = "Produk berhasil diubah.";
  } else {
    $log = "Produk gagal diubah.";
  }
    header("Location: stock.php?message=" . urlencode($log));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stock | Barokah</title>
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
                <h5 class="card-title fw-semibold mb-4">Daftar Stock Barang</h5>
                <div class="table-responsive mt-4">
                  <?php if (isset($_GET['message'])): ?>
                      <div class="alert alert-info alert-dismissible fade show" role="alert">
                          <strong>Notice:</strong> <?= $_GET['message'] ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                  <?php endif; ?>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode Produk</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Stok</th>
                        <th scope="col" class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                      $a=0;
                      while($row = mysqli_fetch_assoc($result)) {
                        $a = $a + 1;
                      ?>
                      <tr>
                        <form action="" method="post">  
                        <td scope="row" class="col-1"><?=$a?></td>
                        <td class="col-2"><input type="text" readonly class="form-control-plaintext" id="id" name="id" value="<?=$row['kode_produk']?>"></td>
                        <td><?=$row['nama_produk']?></td>
                          <td class="col-2"><input
                          type="number"
                          class="form-control"
                          name="stock"
                          id="stock" value="<?= $row['stok_produk']?>"/></td>
                          <td class="col-1"><button type="submit" name="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin mengubah produk ini?')">Edit</button></td>
                        </form>
                      </tr>
                      <?php 
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
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
