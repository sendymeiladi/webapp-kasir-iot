<?php
  $alert = "";

  // tambah data
  if (isset($_POST['tambah'])) {
      $username = $_POST['username'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $nama_pegawai = $_POST['nama_pegawai'];
  
      $sql_tambah = "INSERT INTO pengguna (username, password, nama_pegawai) VALUES ('$username', '$password', '$nama_pegawai')";
      mysqli_query($db, $sql_tambah);
      $alert = "tambah";
  }

  //hapus data
if(isset($_GET['hapus'])){
  $sql_hapus = "UPDATE pengguna SET aktif ='0' WHERE username = '{$_GET['hapus']}'";
  mysqli_query($db, $sql_hapus);
  $alert = "hapus";
}

// ubah data
if(isset($_POST['ubah'])){
    
  if($_POST['password'] == ""){
    $sql_ubah = "UPDATE pengguna SET username = '{$_POST['username']}', nama_pegawai = '{$_POST['nama_pegawai']}' WHERE username = '{$_POST['old_username']}'";
  } else {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql_ubah = "UPDATE pengguna SET username = '{$_POST['username']}', password = '$password', nama_pegawai = '{$_POST['nama_pegawai']}' WHERE username = '{$_POST['old_username']}'";
  }
  echo $sql_ubah;
  mysqli_query($db, $sql_ubah);
  $alert = "ubah";
}


  $sql = "SELECT * FROM pengguna WHERE aktif = 1";
  $result = mysqli_query($db, $sql);
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Pengguna</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <!-- Alert -->
          <?php if ($alert == "tambah") { ?>
            <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
            Data Berhasil ditambahkan.
          </div>
          <?php } else if ($alert == "hapus") { ?>
            <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i>Berhasil</h5>
            Data Berhasil dihapus.
            </div>
          <?php } else if ($alert == "ubah") { ?>
            <div class="alert alert-primary alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i>Berhasil</h5>
            Data Berhasil diubah.
            </div>
          <?php } ?>
        <div class="row">
          <!-- /.col-md-12 -->
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">Tambah Data</button>
              </div>
              <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Username</th>
                    <th>Nama Pegawai</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php while($row = mysqli_fetch_array($result)){ ?>
                  <tr>
                    <td><?php echo $row['username'] ?></td>
                    <td><?php echo $row['nama_pegawai'] ?></td>
                    <td><a href="?hal=pengguna_ubah&ubah=<?php echo $row['username'] ?>" class="btn btn-primary">Ubah</a> <a href="?hal=pengguna&hapus=<?php echo $row['username'] ?>" class="btn btn-danger">Hapus</a></td>
                  </tr>
                  <?php }?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>username</th>
                    <th>nama pegawai</th>
                    <th>Aksi</th>
                  </tr>
                  </tfoot>
                </table>

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
  <!-- Modal -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah data baru</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="">
            <div class="modal-body">
              <div class="form-group">
                    <label>username</label>
                    <input type="text" class="form-control" placeholder="Masukan username", name="username" required>
              </div>
              <div class="form-group">
                    <label>password</label>
                    <input type="password" min="0" class="form-control" placeholder="Masukan password", name="pasword" required>
              </div>
              <div class="form-group">
                    <label>Nama pegawai</label>
                    <input type="text"  class="form-control" placeholder="Masukan nama pegawai", name="nama_pegawai" required>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>