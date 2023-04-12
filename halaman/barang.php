<?php
  $alert = "";

  // tambah data
  if (isset($_POST['tambah'])) {
      $nama_barang = $_POST['nama_barang'];
      $stok = $_POST['stok'];
      $harga = $_POST['harga'];
  
      $sql_tambah = "INSERT INTO barang (nama_barang, stok, harga) VALUES ('$nama_barang', '$stok', '$harga')";
      mysqli_query($db, $sql_tambah);
      $alert = "tambah";
  }

  //hapus data
if(isset($_GET['hapus'])){
  $sql_hapus = "UPDATE barang SET aktif ='0' WHERE id = '{$_GET['hapus']}'";
  mysqli_query($db, $sql_hapus);
  $alert = "hapus";
}

// ubah data
if(isset($_POST['ubah'])){
  $sql_ubah = "UPDATE barang SET nama_barang = '{$_POST['nama_barang']}', stok = '{$_POST['stok']}', harga = '{$_POST['harga']}' WHERE id = '{$_POST['id']}'";
  mysqli_query($db, $sql_ubah);
  $alert = "ubah";
}


  $sql = "SELECT * FROM barang WHERE aktif = 1";
  $result = mysqli_query($db, $sql);
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Barang</h1>
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
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Harga (Rp.)</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php while($row = mysqli_fetch_array($result)){ ?>
                  <tr>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['nama_barang'] ?></td>
                    <td><?php echo $row['stok'] ?></td>
                    <td><?php echo $row['harga'] ?></td>
                    <td><a href="?hal=barang_ubah&ubah=<?php echo $row['id'] ?>" class="btn btn-primary">Ubah</a> <a href="?hal=barang&hapus=<?php echo $row['id'] ?>" class="btn btn-danger">Hapus</a></td>
                  </tr>
                  <?php }?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Harga (Rp.)</th>
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
                    <label>Nama Barang</label>
                    <input type="text" class="form-control" placeholder="Masukan barang", name="nama_barang" required>
              </div>
              <div class="form-group">
                    <label>Stok</label>
                    <input type="number" min="0" class="form-control" placeholder="Masukan jumlah", name="stok" required>
              </div>
              <div class="form-group">
                    <label>Harga</label>
                    <input type="number" min="0" class="form-control" placeholder="Masukan Harga", name="harga" required>
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