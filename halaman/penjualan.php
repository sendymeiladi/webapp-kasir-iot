<?php

  $sql = "SELECT * FROM penjualan";
  $result = mysqli_query($db, $sql);

  if(isset($_GET['detail'])){
    $sql_detail = "SELECT barang.nama_barang, penjualan_detail.id ,penjualan_detail.jumlah, penjualan_detail.harga 
    FROM barang 
    INNER JOIN penjualan_detail
    ON barang.id = penjualan_detail.id_barang
    WHERE penjualan_detail.id_keranjang = '{$_GET['detail']}'";

    $result_detail = mysqli_query($db,$sql_detail);
    $total_belanja = 0;
  }
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Penjualan</h1>
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
              <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Waktu</th>
                    <th>ID Keranjang</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php while($row = mysqli_fetch_array($result)){ ?>
                  <tr>
                    <td><?php echo $row['waktu'] ?></td>
                    <td><?php echo $row['id_keranjang'] ?></td>
                    <td><a href="?hal=penjualan&detail=<?php echo $row['id_keranjang'] ?>" class="btn btn-info">Detail</a>
                  </tr>
                  <?php }?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Waktu</th>
                    <th>ID Keranjang</th>
                    <th>Aksi</th>
                  </tr>
                  </tfoot>
                </table>

              </div>
            </div>
            
            <?php if(isset($_GET['detail'])){ ?>
            <!-- detail -->
            <div class="card card-info">
              <div class="card-header">
                <h5 class="card-title m-0">ID keranjang : <?php echo $_GET['detail'] ?> </h5>
              </div>
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Harga</th>
                      <th>Jumlah</th>
                      <th>Sub Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($row_detail = mysqli_fetch_array($result_detail)) {?>
                    <tr>
                      <td><?php echo $row_detail['nama_barang'] ?></td>
                      <td><?php echo $row_detail['harga'] ?></</td>
                      <td><?php echo $row_detail['jumlah'] ?></</td>
                      <td><?php echo $row_detail['harga']*$row_detail['jumlah'] ?></</td>
                    </tr>
                    <?php 
                      $total_belanja += $row_detail['harga']*$row_detail['jumlah'];
                      } 
                      ?>
                    </tbody>
                </table>
                <div class="form-group">
                  <h5><b style="color:green">Total : Rp <?php echo $total_belanja ?></b></h5>
                </div>
              </div>
            </div>
            <?php } ?>
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
              <h4 class="modal-title">Detail Penjualan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>