<?php
include_once('conn.php');
session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
    header("location: login.php");
    exit;
}

$query = "SELECT kode_transaksi FROM transaksi ORDER BY kode_transaksi DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
    if (isset($row['kode_transaksi'])) {
        $lastId = $row['kode_transaksi'];
        $num = (int)substr($lastId, 5);
        $num++;
        $kode_transaksi_baru = 'BR' . str_pad($num, 5, '0', STR_PAD_LEFT);
    } else {
        $kode_transaksi_baru = 'BR00001';
    }
    
$query = "SELECT kode_produk, nama_produk FROM produk";
$result = mysqli_query($conn, $query);

function formatRupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}

if (isset($_POST['nama_pembeli'])) {
  $_SESSION['nama_pembeli'] = $_POST['nama_pembeli'];
}

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
          <div class="container-fluid">
            <div class="card">
              <div class="card-body">
                <form method="post">
                <h5 class="card-title fw-semibold mb-4">Transaksi</h5>
                <div class="row">
                  <div class="col-4">
                    <h5 class="card-title fw-bolder mb-4"><?= $kode_transaksi_baru ?></h5>
                    <div class="mb-3">
                      <label for="nama_pembeli" class="form-label"
                      >Nama Pembeli</label
                      >
                      <input
                      type="text"
                      class="form-control"
                      id="nama_pembeli" name="nama_pembeli" value="<?php if (isset($_SESSION['nama_pembeli'])) echo $_SESSION['nama_pembeli']; ?>"/>
                    </div>
                  </div>
                  <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $kode_produk => $jumlah) {
                        $produk = getProductById($kode_produk);
                        $total += $produk['harga_produk'] * $jumlah;
                    }
                    ?>
                  <div class="col d-flex flex-column align-items-end">
                    <h1 class="fw-bolder mb-4"><?= formatRupiah($total)?></h1>
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#bayar">
                      Bayar
                    </button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-4">
                      <div class="mb-3">
                        <label for="id" class="form-label">Kode Produk</label>
                        <input class="form-control" list="datalistOptions" id="id" name="id" placeholder="Cari Produk">
                        <datalist id="datalistOptions">
                          <?php 
                          $a=0;
                          while($row = mysqli_fetch_assoc($result)) :
                            $a = $a + 1;
                          ?>
                          <option value="<?=$row['kode_produk']?>"><?=$row['nama_produk']?></option>
                          <?php endwhile; ?>
                        </datalist>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah Produk</label>
                        <input
                          type="Number"
                          class="form-control"
                          id="jumlah" name="jumlah" min="1" required/>
                      </div>
                    </div>
                  </div>
                  <button type="submit" name="add" class="btn btn-primary">Tambahkan</button>
                </form>
                <div class="table-responsive mt-4">
                  <?php if (isset($_GET['message'])): ?>
                      <div class="alert alert-info alert-dismissible fade show" role="alert">
                          <strong>Notice:</strong> <?= $_GET['message'] ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                  <?php endif; 
                    if ($_SESSION['cart']!=null) {
                        echo '<table class="table table-bordered">';
                        echo '<thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Kode Produk</th>
                                            <th scope="col">Nama Produk</th>
                                            <th scope="col">Harga Satuan</th>
                                            <th scope="col">Jumlah</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>';

                        echo'<tbody>';
                        $no = 0;

                        foreach ($_SESSION['cart'] as $kode_produk => $jumlah) {
                            if($jumlah==0){
                                unset($_SESSION['cart'][$kode_produk]);
                            }
                            
                            $no +=1;
                            $produk = getProductById($kode_produk);
                            $totalharga = $produk['harga_produk'] * $jumlah;
                            
                            echo '<tr>';
                            echo '<td>' . $no . '</td>';
                            echo '<td>' . $produk['kode_produk'] . '</td>';
                            echo '<td>' . $produk['nama_produk'] . '</td>';
                            echo '<td>' . formatRupiah($produk['harga_produk']) . '</td>';
                            echo '<td class="col-2"><form method="POST" style="display:inline;"><input
                                            type="number"
                                            class="form-control"
                                            name="jumlah"
                                            id="jumlah" value="'.$jumlah.'"/></td>';
                            echo '<td>' . formatRupiah($totalharga) . '</td>';
                            echo '<td>
                                        <input type="hidden" name="kode_produk" value="' . $produk['kode_produk'] . '">
                                        <button type="submit" class="btn btn-primary" name="edit" onclick="return confirm(\'Apakah Anda yakin ingin mengubah produk ini?\')">Edit</button>
                                    </form>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="kode_produk" value="' . $produk['kode_produk'] . '">
                                        <button type="submit" class="btn btn-danger" name="delete" onclick="return confirm(\'Apakah Anda yakin ingin menghapus produk ini?\')">Hapus</button>
                                    </form></td>';
                            echo '</tr>';
                            
                            }
                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo '<p class="text-center">Tidak ada aktivitas transaksi.</p>';
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="bayar" tabindex="-1" aria-labelledby="modalBayar" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalBayar">Bayar</h5>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <h5>Total yang harus dibayarkan</h5>
          <h3><?= formatRupiah($total)?></h3>
          <input type="hidden" name="kode_transaksi" value="<?=$kode_transaksi_baru?>">
          <input type="hidden" name="nama_pembeli" value="<?=$_SESSION['nama_pembeli']?>">
          <input type="hidden" name="total_harga" value="<?=$total?>">
          <div class="mb-3">
            <label for="dibayar" class="form-label">Total yang dibayarkan</label>
            <input
            type="text"
            class="form-control"
            id="dibayar" name="dibayar" required/>
          </div>
          <div class="mb-3">
            <label for="pembayaran" class="form-label"
            >Jenis Pembayaran</label
            >
            <select
            type="text"
            class="form-control"
            id="pembayaran" name="pembayaran" required>
            <option selected>Pilih Jenis Pembayaran</option>
            <option value="Tunai">Tunai</option>
            <option value="Transfer">Transfer</option>
            <option value="QRIS">QRIS</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batalkan</button>
        <button type="submit" name="bayar" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
</div>

<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sidebarmenu.js"></script>
<script src="../assets/js/app.min.js"></script>
</body>
</html>
