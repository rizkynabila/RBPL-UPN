<?php
require_once ('conn.php');
session_start();

if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
    header("location: login.php");
    exit;
}

function formatRupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard | Barokah</title>
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
          <div class="row">
            <div class="col">
              <div class="card w-100">
                <div class="card-body">
                  <div class="row">
                    <div class="col d-flex flex-column justify-content-center">
                      <h1 class="display-2">Selamat Pagi, <?= $_SESSION["name"]; ?></h1>
                      <h2 class="text-body-secondary">
                        Semoga harimu menyenangkan!
                      </h2>
                    </div>
                    <div class="col-4">
                      <img
                        src="../assets/images/439 1.png"
                        class="rounded float-end" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-body">
                  <div class="row alig n-items-start">
                    <div class="col-8">
                      <?php 
                      $queryA = "SELECT SUM(total_harga) AS total_hari_ini 
                      FROM transaksi 
                      WHERE DATE(tanggal_transaksi) = CURRENT_DATE";
                      $result = mysqli_query($conn, $queryA);
                      $row = mysqli_fetch_assoc($result);
                      $totalHariIni = $row['total_hari_ini'] ?? 0;
                      ?>
                      <h5 class="card-title mb-9 fw-semibold">
                        Total Penjualan Hari Ini
                      </h5>
                      <h4 class="fw-semibold mb-3"><?= formatRupiah($totalHariIni) ?></h4>
                    </div>
                    <div class="col-4">
                      <div class="d-flex justify-content-end">
                        <div
                          class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                          <i class="ti ti-currency-dollar fs-6"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card">
                <div class="card-body">
                  <div class="row alig n-items-start">
                    <div class="col-8">
                      <?php 
                      $queryB = "SELECT SUM(total_harga) AS total_bulan_ini 
                      FROM transaksi 
                      WHERE MONTH(tanggal_transaksi) = MONTH(CURRENT_DATE) 
                        AND YEAR(tanggal_transaksi) = YEAR(CURRENT_DATE)";
                      $result = mysqli_query($conn, $queryB);
                      $row = mysqli_fetch_assoc($result);
                      $totalbulanIni = $row['total_bulan_ini'] ?? 0;
                      ?>
                      <h5 class="card-title mb-9 fw-semibold">
                        Total Penjualan Bulan Ini
                      </h5>
                      <h4 class="fw-semibold mb-3"><?= formatRupiah($totalbulanIni) ?></h4>
                    </div>
                    <div class="col-4">
                      <div class="d-flex justify-content-end">
                        <div
                          class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                          <i class="ti ti-currency-dollar fs-6"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body p-4">
                  <h5 class="card-title fw-semibold mb-4">Transaksi Terkini</h5>
                  <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                      <thead class="text-dark fs-4">
                        <tr>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Kode Transaksi</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Tanggal</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Nama Pembeli</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Total Transaksi</h6>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $query = "SELECT * FROM transaksi ORDER BY tanggal_transaksi DESC LIMIT 5;";
                        $result = mysqli_query($conn, $query);
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)):
                        ?>
                        <tr>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?= $row['kode_transaksi']?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1"><?= $row['tanggal_transaksi']?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <p class="mb-0 fw-normal"><?= $row['nama_pembeli']?></p>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?= formatRupiah($row['total_harga'])?></h6>
                          </td>
                        </tr>
                        <?php endwhile;?>
                      </tbody>
                    </table>
                  </div>
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
