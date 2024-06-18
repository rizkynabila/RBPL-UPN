<?php 
require_once('conn.php');

$id = $_POST['id'];

$query = "SELECT transaksi.*, transaksi_detail.*, produk.*
          FROM transaksi
          LEFT JOIN transaksi_detail ON transaksi.kode_transaksi = transaksi_detail.kode_transaksi
          LEFT JOIN produk ON transaksi_detail.kode_produk = produk.kode_produk 
          WHERE transaksi.kode_transaksi = '$id'";
$result = mysqli_query($conn, $query);

$nama = "SELECT nama_pembeli, tanggal_transaksi from transaksi where kode_transaksi = '$id'";
$res_nama = mysqli_query($conn, $nama);
$pembeli = mysqli_fetch_assoc($res_nama);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Example 1</title>
    <style>

      @page {
    size: potrait;
    margin: 0cm 0 0cm 0;

    @top-left {
      content: element(header);
    }

    @bottom-left {
      content: element(footer);
    }
  }

      .clearfix:after {
        content: "";
        display: table;
        clear: both;
      }

      body {
        position: relative;
        width: 21cm;
        height: 29.7cm;
        margin: 0 auto;
        color: #001028;
        background: #ffffff;
        font-family: Arial, sans-serif;
        font-size: 12px;
        font-family: Arial;
      }

      header {
        padding: 10px 0;
        margin-bottom: 30px;
      }

      h1 {
        border-top: 1px solid #5d6975;
        border-bottom: 1px solid #5d6975;
        color: #5d6975;
        font-size: 2.4em;
        line-height: 1.4em;
        font-weight: normal;
        text-align: center;
        margin: 0 0 20px 0;
      }

      #project {
        float: left;
      }

      #project span {
        color: #5d6975;
        text-align: left;
        width: 52px;
        margin-right: 60px;
        display: inline-block;
        font-size: 0.8em;
      }

      #project div{
        white-space: nowrap;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
      }

      table tr:nth-child(2n-1) td {
        background: #f5f5f5;
      }

      table th,
      table td {
        text-align: center;
      }

      table th {
        padding: 5px 20px;
        color: #5d6975;
        border-bottom: 1px solid #c1ced9;
        white-space: nowrap;
        font-weight: normal;
      }

      table td {
        padding: 20px;
        text-align: right;
      }

      table td.grand {
        border-top: 1px solid #5d6975;
      }

      .text-left {
        text-align: left;
      }
    </style>
  </head>
  <body>
    <header class="clearfix">
      <h1>BAROKAH ACC BIRD</h1>
      <div id="project">
        <div><span>KODE TRANSAKSI </span> <?= $id ?></div>
        <div><span>NAMA PEMBELI </span> <?= $pembeli['nama_pembeli'] ?></div>
        <div><span>TANGGAL TRANSAKSI</span> <?= $pembeli['tanggal_transaksi'] ?></div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="text-left">No</th>
            <th class="text-left">Nama Produk</th>
            <th class="text-left">Harga</th>
            <th class="text-left">Jumlah</th>
            <th class="text-left">Sub Total</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $total = 0;
            $kembali = 0;
            $bayar = 0;
            $no = 1;
            while($row = mysqli_fetch_array($result)):
            $subtotal = $row['harga_produk'] * $row['jumlah_produk'];
            $kembali = $row['kembalian'];
            $bayar = $row['total_dibayar'];
            $total += $subtotal;
            ?>
          <tr>
            <td class="text-left"><?= $no++;?></td>
            <td class="text-left"><?= $row['nama_produk']?></td>
            <td class="text-left"><?= 'Rp ' . number_format($row['harga_produk'], 0, ',', '.') ?></td>
            <td class="text-left"><?= $row['jumlah_produk']?></td>
            <td class="text-left"><?= 'Rp ' . number_format($subtotal, 0, ',', '.')?></td>
          </tr>
          <?php endwhile;?>
          <tr>
            <td colspan="4" class="grand">TOTAL</td>
            <td class="grand text-left"><?= 'Rp ' . number_format($total, 0, ',', '.')?></td>
          </tr>
          <tr>
            <td colspan="4">BAYAR</td>
            <td class="text-left"><?= 'Rp ' . number_format($bayar, 0, ',', '.')?></td>
          </tr>
          <tr>
            <td colspan="4">KEMBALI</td>
            <td class="text-left"><?= 'Rp ' . number_format($kembali, 0, ',', '.')?></td>
          </tr>
        </tbody>
      </table>
    </main>
    <footer>
    </footer>
  </body>
</html>
