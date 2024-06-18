<?php 
include_once ('conn.php');
session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
    header("location: login.php");
    exit;
}

$query = "SELECT * FROM produk";
$result = mysqli_query($conn, $query);

function formatRupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
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
                <div class="row">
                  <div class="col-4">
                    <h5 class="card-title fw-semibold mb-4">Daftar Produk</h5>
                  </div>
                  <div class="col d-flex flex-column align-items-end">
                    <a href="addProduct.php" class="btn btn-primary">Tambah Produk</a>
                  </div>
                </div>
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
                        <th scope="col">Harga Satuan</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $a=0;
                      while($row = mysqli_fetch_assoc($result)) {
                        $a = $a + 1;
                      ?>
                      <tr>
                        <td scope="row"><?=$a?></td>
                        <td><?=$row['kode_produk']?></td>
                        <td><?=$row['nama_produk']?></td>
                        <td><?= formatRupiah($row['harga_produk']);?></td>
                        <td><a href="editProduct.php?id=<?=$row['kode_produk']?>" class="btn btn-primary">Edit</a> <a href="deleteProduct.php?id=<?=$row['kode_produk']?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a></button></td>
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
