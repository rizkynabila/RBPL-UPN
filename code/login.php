<?php 
include_once ('conn.php'); 
session_start();

if(isset($_POST['submit'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $query = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($conn, $query);
  $user = mysqli_fetch_assoc($result);
    if($user['username'] == $username && $user['password'] == $password){
      $_SESSION['role'] = $user['role'];
      $_SESSION['name'] = $user['nama'];
      $_SESSION['login'] = true;
      header('location: index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | Barokah</title>
    <link
      rel="shortcut icon"
      type="image/png"
      href="../assets/images/LOGO.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
  </head>

  <body>
    <div
      class="page-wrapper"
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin6"
      data-sidebartype="full"
      data-sidebar-position="fixed"
      data-header-position="fixed">
      <div
        class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
          <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3">
              <div class="card mb-0">
                <div class="card-body">
                  <a
                    href="./index.html"
                    class="text-nowrap logo-img text-center d-block py-3 w-100">
                    <img src="../assets/images/LOGO.png" width="180" alt="" />
                  </a>
                  <form action="" method="post">
                    <div class="mb-3">
                      <label for="username" class="form-label">Username</label>
                      <input
                        type="text"
                        class="form-control"
                        id="username"
                        name="username" />
                    </div>
                    <div class="mb-4">
                      <label for="password" class="form-label">Password</label>
                      <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password" />
                    </div>
                    <div
                      class="d-flex align-items-center justify-content-between mb-4">
                      <a
                        class="text-primary text-end fw-bold"
                        href="./index.html"
                        >Forgot Password ?</a
                      >
                    </div>
                    <button
                      class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" name="submit">
                      Sign In
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
