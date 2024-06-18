<?php 
require '../vendor/autoload.php';
require_once ('conn.php');
use Dompdf\Dompdf;
session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
    header("location: login.php");
    exit;
}

// Gunakan hasil markup HTML untuk membuat file PDF
if(isset($_POST['print'])){
  // Mulai buffer output
  ob_start();
  
  // Jalankan file PHP untuk menghasilkan markup HTML
  include 'pdf.php';
  
  // Simpan hasil output ke dalam variabel
  $html = ob_get_clean();
  $dompdf = new Dompdf();
  $dompdf->setPaper('letter', 'landscape');
  $dompdf->loadHtml($html);
  $dompdf->render();
  $dompdf->stream('example.pdf');
}

$a = true;

$query = "SELECT transaksi.*, transaksi_detail.*, produk.*
          FROM transaksi
          LEFT JOIN transaksi_detail ON transaksi.kode_transaksi = transaksi_detail.kode_transaksi
          LEFT JOIN produk ON transaksi_detail.kode_produk = produk.kode_produk";

if (isset($_POST['filter']) && !empty($_POST['filter'])) {
    $a =false;
    $tanggal = $_POST['filter'];
    $query .= " WHERE transaksi.tanggal_transaksi = '$tanggal'";
}

if (isset($_POST['show_all'])) {
    $a = true;
    $query = "SELECT transaksi.*, transaksi_detail.*, produk.*
              FROM transaksi
              LEFT JOIN transaksi_detail ON transaksi.kode_transaksi = transaksi_detail.kode_transaksi
              LEFT JOIN produk ON transaksi_detail.kode_produk = produk.kode_produk";
}

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
    <title>Report | Barokah</title>
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
                <h5 class="card-title fw-semibold mb-4">
                  Daftar Riwayat Transaksi
                </h5>
                <div class="row">
                  <div class="col-4">
                    <form class="row g-2" action="" method="post">
                      <div class="col-6">
                        <input type="date" class="form-control" id="filter" name="filter" value="<?= isset($_POST['filter']) ? $_POST['filter'] : ''; ?>" oninput="this.form.submit()"/>
                      </div>
                      <div class="col-6">
                        <button type="submit" class="btn btn-primary mb-3" name="show_all" value="yes">Tampilkan Semua</button>
                      </div>
                    </form>
                  </div>
                  <div class="col d-flex flex-column align-items-end">
                    <form action="pdf.php" method="post">
                      <?php if($a){
                        echo' <input type="hidden" name="show_all">';
                      }                     
                      ?>
                      <input type="hidden" name="filter" value="<?= isset($_POST['filter']) ? $_POST['filter'] : ''; ?>">
                      <button type="submit" name="print" class="btn btn-primary">Print</button>
                    </form>
                  </div>
                </div>
                <div class="table-responsive mt-4">
                  <?php if(mysqli_num_rows($result) > 0){?>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode Transaksi</th>
                        <th scope="col">Kode Produk</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Harga Satuan</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $totalharga = 0;
                      while ($row = mysqli_fetch_array($result)) :
                        $totalharga += $row['harga_produk'] * $row['jumlah_produk'];
                      ?>
                      <tr class="">
                        <td scope="row">1</td>
                        <td><?= $row['kode_transaksi']?></td>
                        <td><?= $row['kode_produk']?></td>
                        <td><?= $row['nama_produk']?></td>
                        <td><?= formatRupiah($row['harga_produk']);?></td>
                        <td><?= $row['jumlah_produk']?></td>
                        <td><?php $total = $row['harga_produk']*$row['jumlah_produk']; echo formatRupiah($total);?></td>
                      </tr>
                      <?php
                        endwhile;
                      ?>
                    </tbody>
                  </table>
                  <div class="row container">
                    <div class="col d-flex flex-column align-items-end">
                      <h2>Jumlah Total</h2>
                      <h1 class="fw-bolder mb-4"><?= formatRupiah($totalharga)?></h1>
                    </div>
                  </div>
                  <?php 
                  } else {
                        echo '<p class="text-center">Tidak ada data yang ditemukan.</p>';
                      }
                  ?>
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
