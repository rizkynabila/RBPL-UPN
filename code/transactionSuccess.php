<?php
include_once('conn.php');
require '../vendor/autoload.php';
use Dompdf\Dompdf;
session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
    header("location: login.php");
    exit;
}

function formatRupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}

// Gunakan hasil markup HTML untuk membuat file PDF
if(isset($_POST['reicept'])){
  // Mulai buffer output
  ob_start();
  
  // Jalankan file PHP untuk menghasilkan markup HTML
  include 'reicept.php';
  
  // Simpan hasil output ke dalam variabel
  $html = ob_get_clean();
  $dompdf = new Dompdf();
  $dompdf->setPaper('letter', 'potrait');
  $dompdf->loadHtml($html);
  $dompdf->render();
  $dompdf->stream('example.pdf');
}
session_start();

$id = $_GET['id'];

$query = "SELECT * FROM transaksi WHERE kode_transaksi = '$id'";
$result = mysqli_query($conn, $query);
$transaksi = mysqli_fetch_assoc($result);

require 'programkasir.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Transaction | Barokah</title>
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
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body d-flex flex-column align-items-center">
          <h3 class="fw-semibold mb-4">Transaksi Berhasil!</h3>
          <iframe src="https://lottie.host/embed/768e9e94-5e77-406a-b055-029f4a8a162e/obh8aU89WY.json"></iframe>
            <div class="container">
              <div class="row">
                <div class="col-md justify-content-start">
                  <p>Kode Transaksi</p>
                </div>
                <div class="col-md ">
                  <h4><?= $transaksi['kode_transaksi']?></h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md justify-content-start">
                  <p>Kembalian</p>
                </div>
                <div class="col-md">
                  <h4><?= formatRupiah($transaksi['kembalian'])?></h4>
                </div>
              </div>
            </div>
            <form action="" method="post" class="row mt-3" style="width: 100%;">
            <input type="hidden" name="id" value="<?= $transaksi['kode_transaksi']?>">
              <button type="submit" name="reicept" class="btn btn-primary btn-lg"><i class="ti ti-download me-4"></i>Cetak Struk</button>
            </form>
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
