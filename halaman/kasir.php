<?php
  if(isset($_POST['tampil'])) {
  $sql = "SELECT barang.nama_barang, keranjang_detail.id ,keranjang_detail.jumlah, keranjang_detail.harga 
  FROM barang 
  INNER JOIN keranjang_detail
  ON barang.id = keranjang_detail.id_barang
  WHERE keranjang_detail.id_keranjang = '{$_POST['id_keranjang']}'";

  $result = mysqli_query($db,$sql);
  $total_belanja = 0;

  }

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kasir</h1>
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
            <!-- card input keranjang -->
            <div class="card">
              <div class="card-header">
                <h5 class="card-tittle m-0">Input ID Keranjang</h5>
              </div>
              <div class="card-body">
                <form method="POST" action="">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-12">
                        <input type="number" name="id_keranjang" class="form-control" minn="1" placeholder="ID Keranjang" required autofocus>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <input type="submit" name="tampil" class="btn btn-info" value="Tampilkan isi Keranjang">
                  </div>
                </form>

              </div>
            </div>
            <?php if(isset($_POST['tampil'])) { ?>
            <!-- form isi keranjang -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-tittle m-0">ID Keranjang : <?php echo $_POST['id_keranjang'] ?></h5>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Harga</th>
                      <th>Jumlah</th>
                      <th>Sub Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                    <tr>
                      <td><?php echo $row['nama_barang'] ?></td>
                      <td><?php echo number_format($row['harga'],"0",",",".") ?></</td>
                      <td><?php echo $row['jumlah'] ?></</td>
                      <td><?php echo number_format($row['harga']*$row['jumlah'],"0",",",".") ?></</td>
                    </tr>
                    <?php 
                      $total_belanja += $row['harga']*$row['jumlah'];
                    }
                    ?>
                    </tbody>
                </table>
                <div class="form-group">
                  <h4><b style="color:green">Total : Rp. <?php echo number_format($total_belanja,"0",",",".") ?></b></h4>
                </div>
                <input type="submit" name="bayar" class="btn btn-danger" value="Bayar">
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