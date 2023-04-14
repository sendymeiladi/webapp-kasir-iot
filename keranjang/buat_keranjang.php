<?php 
  session_start();

  $pesan = "Masukan ID Keranjang dan Passcode";

  if(isset($_POST['baru'])){
    require "../conf/database.php";

    $passcode = $_POST['passcode'];

    $sql = "INSERT INTO keranjang (passcode) VALUES ('$passcode')";
    mysqli_query($db, $sql);

    $sql_select = "SELECT max(id) as id_keranjang_terakhir FROM keranjang";
    $reuslt_select = mysqli_query($db, $sql_select);
    $row = mysqli_fetch_array($reuslt_select);

    $_SESSION['id_keranjang'] = $row['id_keranjang_terakhir'];

    header("Location: index.php");
  }

  if(isset($_POST['buka'])){
    require "../conf/database.php";

    $id_keranjang = $_POST['id_keranjang'];
    $passcode = $_POST['passcode'];

    $sql = "SELECT * FROM keranjang WHERE id = '$id_keranjang'";
    $result = mysqli_query($db, $sql);
    $data =  mysqli_fetch_array($result);

    if($data){
      if($data['passcode'] == $passcode){
        $_SESSION['id_keranjang'] = $id_keranjang;

        header("Location: index.php");
      } else {
        $pesan = "Passcode Salah";
      }
    } else {
      $pesan = "ID Keranjang Tidak Terdaftar";
    }
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buat Keranjang</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../index2.html"><b>TOKO </b>SendyUNO</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><?php echo $pesan ?></p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="number" name="id_keranjang" class="form-control" placeholder="ID Keranjang" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-shopping-cart"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="passcode" class="form-control" placeholder="Passcode" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="buka" class="btn btn-primary btn-block">Buka Keranjang</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
        <p>- ATAU -</p>
        <form method="post" action="">
          <div class="input-group mb-3">
            <input type="password" name="passcode" class="form-control" placeholder="Passcode Keranjang Baru" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <button type="submit" name="baru" class="btn btn-success btn-block"><span class="fas fa-cart-plus"></span> Buka Keranjang Baru</button>
        </form>
      </div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
