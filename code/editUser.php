<?php 
require_once ('conn.php');
session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
    header("location: login.php");
    exit;
}
$id = $_GET['id'];

$query = "SELECT * FROM users WHERE user_id = '$id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if(isset($_POST['submit'])){
  $nama = $_POST['nama'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $query = "UPDATE users SET nama = '$nama', username = '$username', password = '$password' WHERE user_id = '$id'";
  $result = mysqli_query($conn, $query);
  if ($result) {
    $log = "User berhasil diubah.";
  } else {
    $log = "User gagal diubah.";
  }
    header("Location: user.php?message=" . urlencode($log));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Karyawan | Barokah</title>
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
                <h5 class="card-title fw-semibold mb-4">Edit User</h5>
                <form method="post" >
                  <div class="col-4 mb-3">
                        <label for="user_id" class="form-label"
                          >Kode User</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="user_id"
                          id="user_id" value="<?= $user['user_id']?>" disabled/>
                      </div>
                    <div class="col-4 mb-3">
                        <label for="nama" class="form-label"
                          >Nama</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="nama"
                          id="nama" value="<?= $user['nama']?>"/>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="username" class="form-label"
                          >Username</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="username"
                          id="username" value="<?= $user['username']?>"/>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="password" class="form-label"
                          >Password</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="password"
                          id="password" value="<?= $user['password']?>"/>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="role" class="form-label"
                          >Role</label
                        >
                        <select
                          type="text"
                          class="form-control"
                          name="role"
                          id="role" value="<?= $user['role']?>">
                          <option value="<?= $user['role']?>" selected><?= $user['role']?></option>
                          <option value="Kasir">Kasir</option>
                          <option value="Admin">Admin</option>
                          <option value="Owner">Owner</option>
                        </select>
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
