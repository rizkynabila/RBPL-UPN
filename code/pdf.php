<?php 
require '../vendor/autoload.php';
require_once ('conn.php');
use Dompdf\Dompdf;


if(isset($_POST['print'])){
$query = "SELECT transaksi.*, transaksi_detail.*, produk.*
          FROM transaksi
          LEFT JOIN transaksi_detail ON transaksi.kode_transaksi = transaksi_detail.kode_transaksi
          LEFT JOIN produk ON transaksi_detail.kode_produk = produk.kode_produk";

if (isset($_POST['filter']) && !empty($_POST['filter'])) {
  $tanggal = $_POST['filter'];
  $query .= " WHERE transaksi.tanggal_transaksi = '$tanggal'";
}

if (isset($_POST['show_all'])) {
  $query = "SELECT transaksi.*, transaksi_detail.*, produk.*
              FROM transaksi
              LEFT JOIN transaksi_detail ON transaksi.kode_transaksi = transaksi_detail.kode_transaksi
              LEFT JOIN produk ON transaksi_detail.kode_produk = produk.kode_produk";
}
$result = mysqli_query($conn, $query);
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estimate Document</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap">
  <style>
  :root {
    --font-color: black;
    --highlight-color: #60d0e4;
    --header-bg-color: #b8e6f1;
    --footer-bg-color: #bfc0c3;
    --table-row-separator-color: #bfc0c3;
  }

  @page {
    size: landscape;
    margin: 0cm 0 0cm 0;

    @top-left {
      content: element(header);
    }

    @bottom-left {
      content: element(footer);
    }
  }

  body {
    margin: 0;
    padding: 1cm 2cm;
    color: var(--font-color);
    font-family: "Montserrat", sans-serif;
    font-size: 10pt;
  }

  a {
    color: inherit;
    text-decoration: none;
  }

  hr {
    margin: 1cm 0;
    height: 0;
    border: 0;
    border-top: 1mm solid var(--highlight-color);
  }

  header {
    height: 4cm;
    padding: 0 2cm;
    position: running(header);
    background-color: var(--header-bg-color);
  }

  header .headerSection {
    display: flex;
    justify-content: space-between;
  }

  header .headerSection:first-child {
    padding-top: 0.5cm;
  }

  header .headerSection:last-child {
    padding-bottom: 0.5cm;
  }

  header .headerSection div:last-child {
    width: 35%;
  }

  header .logoAndName {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  header .logoAndName svg {
    width: 1.5cm;
    height: 1.5cm;
    margin-right: 0.5cm;
  }

  header .headerSection .estimateDetails {
    padding-top: 1cm;
  }

  header .headerSection .issuedTo {
    display: flex;
    justify-content: space-between;
  }

  header .headerSection .issuedTo h3 {
    margin: 0 0.75cm 0 0;
    color: var(--highlight-color);
  }

  header .headerSection div p {
    margin-top: 2px;
  }

  header h1,
  header h2,
  header h3,
  header p {
    margin: 0;
  }

  header h2,
  header h3 {
    text-transform: uppercase;
  }

  header hr {
    margin: 1cm 0 0.5cm 0;
  }

  main table {
    width: 100%;
    border-collapse: collapse;
  }

  main table thead th {
    height: 1cm;
    color: var(--highlight-color);
  }

  main table thead th:nth-of-type(2),
  main table thead th:nth-of-type(3),
  main table thead th:last-of-type {
    width: 2.5cm;
  }

  main table tbody td {
    padding: 2mm 0;
    border-bottom: 0.5mm solid var(--table-row-separator-color);
  }

  main table thead th:last-of-type,
  main table tbody td:last-of-type {
    text-align: right;
  }

  main table th {
    text-align: left;
  }

  main table.summary {
    width: calc(40% + 2cm);
    margin-left: 60%;
    margin-top: 0.5cm;
  }

  main table.summary tr.total {
    font-weight: bold;
    background-color: var(--highlight-color);
  }

  main table.summary th {
    padding: 4mm 0 4mm 1cm;
    border-bottom: 0;
  }

  main table.summary td {
    padding: 4mm 2cm 4mm 0;
    border-bottom: 0;
  }

  footer {
    height: 3cm;
    line-height: 3cm;
    padding: 0 2cm;
    position: running(footer);
    background-color: var(--footer-bg-color);
    font-size: 8pt;
    display: flex;
    align-items: baseline;
    justify-content: space-between;
  }

  footer a:first-child {
    font-weight: bold;
  }
</style>
</head>
<body>
  <header>
    <div class="headerSection">
      <div>
        <h1>Laporan Penjualan Barokah Acc Bird</h1>
        <p><b>Tanggal Cetak</b> <?php echo date('d/m/Y'); ?></p>
      </div>
    </div>
  </header>
  <main>
    <table>
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Kode Transaksi</th>
          <th scope="col">Tanggal Transaksi</th>
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
        $nomor_urut = 1; // Nomor urut dinamis
        while ($row = mysqli_fetch_array($result)) :
          $totalharga += $row['harga_produk'] * $row['jumlah_produk'];
        ?>
          <tr class="">
            <td scope="row"><?php echo $nomor_urut++; ?></td>
            <td><?php echo $row['kode_transaksi']; ?></td>
            <td><?php echo $row['tanggal_transaksi']; ?></td>
            <td><?php echo $row['kode_produk']; ?></td>
            <td><?php echo $row['nama_produk']; ?></td>
            <td><?php echo 'Rp ' . number_format($row['harga_produk'], 0, ',', '.'); ?></td>
            <td><?php echo $row['jumlah_produk']; ?></td>
            <td><?php $total = $row['harga_produk'] * $row['jumlah_produk']; echo 'Rp ' . number_format($total, 0, ',', '.'); ?></td>
          </tr>
        <?php
        endwhile;
        ?>
      </tbody>
    </table>
    <h2>Jumlah Total</h2>
    <h1 class="fw-bolder mb-4"><?= 'Rp ' . number_format($totalharga, 0, ',', '.');?></h1>
  </main>
</body>
</html>

<?php 
  $html = ob_get_clean();
  $dompdf = new Dompdf();
  $dompdf->setPaper('letter', 'landscape');
  $dompdf->loadHtml($html);
  $dompdf->render();
  $dompdf->stream('example.pdf');
}
?>

