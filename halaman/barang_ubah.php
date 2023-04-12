<?php
  $sql = "SELECT * FROM barang WHERE id = '{$_GET['ubah']}'";
  $data = mysqli_fetch_array(mysqli_query($db, $sql));
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
        <div class="row">
          <!-- /.col-md-12 -->
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Ubah Data Barang</h5>
              </div>
              <div class="card-body">
              <form method="POST" action="?hal=barang">
                <div class="card-body">
                  <div class="form-group">
                    <label for="username">Nama Barang</label>
                    <input type="hidden" value="<?php echo $data['id'] ?>"  name="id">
                    <input type="text" class="form-control" name="nama_barang" value="<?php echo $data['nama_barang'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="password">Stok</label>
                    <input type="number" class="form-control" name="stok" value="<?php echo $data['stok'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="nama_lengkap">Harga</label>
                    <input type="number" class="form-control" name="harga" value="<?php echo $data['harga'] ?>">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="ubah">Ubah</button>
                </div>
              </form>
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