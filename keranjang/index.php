<?php 
  session_start();
  if(!isset($_SESSION['id_keranjang'])){
    header("Location: buat_keranjang.php");
  }

  require "../conf/database.php";

  $error = false;
  $pesan = "";

  if(isset($_POST['tambah'])){

    $id = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];

    $sql_harga  = "SELECT stok, nama_barang, harga FROM barang WHERE id = '$id'";
    $result = mysqli_query($db,$sql_harga);
    $data = mysqli_fetch_array($result);

    if($data['stok'] > $jumlah){
      $sql_keranjang = "INSERT INTO keranjang_detail (id_keranjang, id_barang, jumlah, harga) VALUES ('{$_SESSION['id_keranjang']}', '$id', '$jumlah', '{$data['harga']}')";
      mysqli_query($db,$sql_keranjang);
    } else {
      $pesan = "Stok sisa barangnya hanya " . $data['stok'];
      $error = true;
    }
  }

  if(isset($_GET['batal'])){
    $sql_hapus = "DELETE FROM keranjang_detail WHERE id='{$_GET['batal']}'";
    mysqli_query($db,$sql_hapus);
  }

  $sql = "SELECT barang.nama_barang, keranjang_detail.id ,keranjang_detail.jumlah, keranjang_detail.harga 
          FROM barang 
          INNER JOIN keranjang_detail
          ON barang.id = keranjang_detail.id_barang
          WHERE keranjang_detail.id_keranjang = '{$_SESSION['id_keranjang']}'";

  $result = mysqli_query($db,$sql);

  $total_belanja = 0;
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Keranjang</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="../index3.html" class="navbar-brand">
        <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Toko SendyUNO</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="tunda.php" class="btn btn-block btn-outline-dark">Tunda Keranjang</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> ID Keranjang : <?php echo $_SESSION['id_keranjang'] ?> </h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <!-- ALERT -->
        <?php if($error == true) { ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-ban"></i>Gagal!</h5>
          <?php echo $pesan ?>
        </div>
        <?php } ?>
        <div class="row">
          <div class="col-lg-5">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title m-0">Scan QRCode</h5>
              </div>
              <div class="card-body">
              <h6 class="card-title">Scan QrCode disini</h6>
                <video></video>

                <div class="form-group">
                  <button id="stop-button" class="btn btn-secondary">Batal Scan</button>
                  <button id="start-button" class="btn btn-danger">Mulai Scan</button>
                </div>

                <form method="POST" action="">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-6">
                        <input type="number" name="id_barang" class="form-control" minn="1" placeholder="ID Barang" required>
                      </div>
                      <div class="col-6">
                        <input type="number" name="jumlah" class="form-control" minn="1" placeholder="Jumlah Barang" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <input type="submit" name="tambah" class="btn btn-success" value="Tambahakn Ke Keranjang">
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title m-0">Keranjang Anda</h5>
              </div>
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Harga</th>
                      <th>Jumlah</th>
                      <th>Sub Total</th>
                      <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                    <tr>
                      <td><?php echo $row['nama_barang'] ?></td>
                      <td><?php echo number_format($row['harga'],"0",",",".") ?></td>
                      <td><?php echo $row['jumlah'] ?></</td>
                      <td><?php echo number_format($row['harga']*$row['jumlah'],"0",",",".") ?></td>
                      <td><a href="?batal=<?php echo $row['id'] ?>" class="btn btn-danger">Batal</a></td>
                    </tr>
                    <?php 
                      $total_belanja += $row['harga']*$row['jumlah'];
                    }
                    ?>
                    </tbody>
                </table>
                <div class="form-group">
                  <h4><b style="color:green">Total : Rp <?php echo number_format($total_belanja,"0",",",".") ?></b></h4>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Toko SendyUNO
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023 <a href="#">Sendy</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="../dist/js/demo.js"></script> -->
<!-- DataTables  & Plugins -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="../dist/js/demo.js"></script> -->
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
