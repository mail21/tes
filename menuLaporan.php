<?php 
	include "koneksi.php";
	include "functions.php";
	$boxStaff = query("SELECT * FROM staff");
	$orderListQuery = query("SELECT 
	order_list.no_transaksi AS nomortransaksi,
	order_list.id_order_list AS id,
	meja.id_meja AS nomormeja,
	menu.nama AS namamenu,
	staff.nama AS namastaff,
	menu.harga AS Harga,
	order_list.quantity AS quantity,
	order_list.total AS total
	FROM
	order_list JOIN meja 
		ON order_list.id_meja = meja.id_meja
	JOIN staff 
		ON order_list.id_staff = staff .id_staff
	JOIN menu 
		ON order_list.id_menu = menu.id_menu

  ORDER BY order_list.id_order_list ASC");
  
  $tanggal = query("SELECT tgl_pengeluaran FROM pengeluaran ORDER BY id_pengeluaran DESC LIMIT 1");
  date_default_timezone_set('Asia/Jakarta');
  $date = date('Y-m-d H:i:s');
  $tanggalTerakhir = substr($tanggal[0]["tgl_pengeluaran"] ,5,2);
  $tanggalSkrng = substr($date,5,2);
  

  // $totalPendapatanPilihan = query("SELECT SUM(total) FROM `order_detail` WHERE tanggal LIKE '". $tahun . "-". $bulan ."-%'"); 
    $totalPendapatan = query("SELECT SUM(total) AS total FROM order_detail");
    $pengeluaran = query("SELECT jumlah FROM pengeluaran WHERE tgl_pengeluaran = '2020-05-20 15:51:32' ");
    $totalBiayaPengeluaran = query("SELECT SUM(jumlah) AS total FROM pengeluaran WHERE tgl_pengeluaran = '2020-05-20 15:51:32'");
    $laba =(int)$totalPendapatan[0]['total'] - (int)$totalBiayaPengeluaran[0]['total'];
	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laporan</title>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/styles/style.css">
  <link rel="stylesheet" href="assets/styles/sidebar.css">
</head>

<style>	
	.kotak{
    background: lightgreen;
    width: 100%;
    position: relative;
  }

  
</style>

<body>

<div class="d-flex" id="wrapper">
	<!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">Welcome , user </div>
      <div class="list-group list-group-flush">
	  	<a href="index.php" class="list-group-item list-group-item-action bg-light">Home</a>
        <a href="menu.php" class="list-group-item list-group-item-action bg-light">Pesan</a>
        <a href="menuLaporan.php" class="list-group-item list-group-item-action bg-light">Laporan</a> 
	  </div>
    </div>
	<!-- /#sidebar-wrapper -->
	
	<!-- Page Content -->
    <div id="page-content-wrapper">

		<div class="container-fluid banner"></div>
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-info" id="menu-toggle">Toggle Menu</button>
        <button type="button" class="btn btn-info btnCetak ml-2" aria-pressed="false" autocomplete="off">
			Cetak Laporan
		</button>
		<button type="button" class="btn btn-info btnForm ml-2" aria-pressed="false" autocomplete="off">
			Form Biaya
		</button>
      </nav>

      
	  <div class="container">
      <!-- ======================== table ============================== -->
      <div class="containerTable">
        <table class="table table-striped ">
          <thead>
              <tr class="table-primary">
              <th scope="col">No</th>
              <th scope="col">Nama Laporan</th>
              <th scope="col">Preview</th>
              <th scope="col">Download</th>
              </tr>
          </thead>
          <tbody>
              <tr>
              <th scope="row">1</th>
              <td>Laporan Data User</td>
              <td><button type="button" data-toggle='modal' data-target='#ModalDataUser' class="btn btn-outline-success">Lihat</button></td>
              <td><button type="button" class="btn btn-outline-success">Download</button></td>
              </tr>
              <tr>
              <th scope="row">2</th>
              <td>Laporan Neraca Laba Rugi</td>
              <td><button type="button" data-toggle='modal' data-target='#ModalLabarugi' class="btn btn-outline-success">Lihat</button></td>
              <td><button type="button" class="btn btn-outline-success">Download</button></td>
              </tr>
              <tr>
              <th scope="row">3</th>
              <td>Laporan Order</td>
              <td><button type="button" data-toggle='modal' data-target='#ModalOrder' class="btn btn-outline-success">Lihat</button></td>
              <td><button type="button" class="btn btn-outline-success">Download</button></td>
              </tr>
          </tbody>
          </table>
      </div>
      <!-- ======================== table ============================== -->

      <!-- ======================== form ============================== -->
          <?php if($tanggalSkrng === $tanggalTerakhir ){ ?> 
            <div class="containerForm kotak" hidden>
              <h1>Data Bulan Ini Sudah Diinput</h1>
          <?php }else{ ?>
            <div class="containerForm" hidden>
              <h1>Data Bulan Ini Belom Diinput</h1>
          <?php }  ?>
        <br>
          <form action="biaya.php" method="POST">
            <div class="form-group">
              <label for="gajiPegawai">Beban Gaji Pegawai</label>
              <input type="text" name="gajiPegawai" class="form-control" id="gajiPegawai" placeholder="Beban Gaji Pegawai">
            </div>
            <div class="form-group">
              <label for="Listrik">Beban Listrik</label>
              <input type="text" name="listrik" class="form-control" id="Listrik" placeholder="Beban Listrik">
            </div>
            <div class="form-group">
              <label for="Telpon">Beban Telpon & internet</label>
              <input type="text" name="telpon" class="form-control" id="Telpon" placeholder="Beban Telpon & internet">
            </div>
            <div class="form-group">
              <label for="Perlengkapan">Beban  Perlengkapan Kantor</label>
              <input type="text" name="perlengkapan" class="form-control" id="Perlengkapan" placeholder="Beban Perlengkapan Kantor">
            </div>
            <div class="form-group">
              <label for="Transportasi">Beban Transportasi dan bensin</label>
              <input type="text" name="transportasi" class="form-control" id="Transportasi" placeholder="Beban Transportasi dan bensin">
            </div>
            <div class="form-group">
              <label for="TidakTerduga">Beban Tidak Terduga</label>
              <input type="text" name="tidakTerduga" class="form-control" id="TidakTerduga" placeholder="Beban Tidak Terduga">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
      <!-- ======================== form ============================== -->

    </div>
    <!-- /#page-content-wrapper -->

	<!-- Modal Laporan Data User-->
	<div class="modal fade" id="ModalDataUser" tabindex="-1" role="dialog">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Laporan </h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body m-3">
          <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">No Staff</th>
            <th scope="col">Username</th>
            <th scope="col">Nama</th>
            <th scope="col">Tipe</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($boxStaff as $staff):  ?>
            <tr>
            <th scope="row"><?= $staff['id_staff']; ?></th>
            <td><?= $staff['username']; ?></td>
            <td><?= $staff['nama']; ?></td>
            <td><?= $staff['tipe']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
	      </div>
	    </div>
	  </div>
	</div>
    <!-- Modal Laporan Data User-->

    <!-- Modal Laporan Laba Rugi-->
	<div class="modal fade" id="ModalLabarugi" tabindex="-1" role="dialog">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Laporan </h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body m-3">
        <table class="table">
        <tr>
            <th colspan="4">LAPORAN LABA RUGI</th>
          </tr>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr> 
           
      <tr>
        <th>Pendapatan</th>
        <th></th>
        <th></th>
        <th></th>
      </tr>

      <tr>
         <td>Pendapatan Restoran</td>
         <td></td>
         <td>Rp. <?= number_format($totalPendapatan[0]['total']) ?></td>
         <td></td>
      </tr>

      <tr>
        <td>Total Pendapatan</td>
        <td></td>
        <td></td>
        <td>Rp. <?= number_format($totalPendapatan[0]['total']) ?></td>
     </tr>

     <tr>
        <th>Biaya-Biaya</th>
        <th></th>
        <th></th>
        <th></th>
      </tr>

     <tr>
        <td>Gaji Pegawai</td>
        <td></td>
        <td>Rp. <?= number_format($pengeluaran[0]['jumlah']) ?></td>
        <td></td>
     </tr>

     <tr>
        <td>Listrik</td>
        <td></td>
        <td>Rp. <?= number_format($pengeluaran[5]['jumlah']) ?></td>
        <td></td>
     </tr>

     <tr>
        <td>Telpon & Internet</td>
        <td></td>
        <td>Rp. <?= number_format($pengeluaran[1]['jumlah']) ?></td>
        <td></td>
     </tr>

     <tr>
        <td>Perlengkapan Kantor</td>
        <td></td>
        <td>Rp. <?= number_format($pengeluaran[2]['jumlah']) ?></td>
        <td></td>
     </tr>

     <tr>
        <td>Transportasi & Bensin</td>
        <td></td>
        <td>Rp. <?= number_format($pengeluaran[3]['jumlah']) ?></td>
        <td></td>
     </tr>

     <tr>
        <td>Biaya Tidak terduga</td>
        <td></td>
        <td>Rp. <?= number_format($pengeluaran[4]['jumlah']) ?></td>
        <td></td>
     </tr>

     <tr>
        <td>Totak Biaya</td>
        <td></td>
        <td></td>
        <td>Rp. <?= number_format($totalBiayaPengeluaran[0]['total']) ?></td>
     </tr>
     <tr>
        <th>Laba Bersih</th>
        <td></td>
        <td></td>
        <th>Rp. <?= number_format($laba) ?></th>
     </tr>
        
    </table>
	      </div>
	    </div>
	  </div>
	</div>
    <!-- Modal Laporan Laba Rugi-->
    
    <!-- Modal Laporan  Order-->
	<div class="modal fade" id="ModalOrder" tabindex="-1" role="dialog">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Laporan </h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body m-3">
          <table class="table table-striped ">
        <thead>
            <tr>
            <th scope="col">nomortransaksi</th>
            <th scope="col">id</th>
            <th scope="col">nomormeja</th>
            <th scope="col">namamenu</th>
            <th scope="col">namastaff</th>
            <th scope="col">Harga</th>
            <th scope="col">quantity</th>
            <th scope="col">total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderListQuery as $order):  ?>
            <tr>
            <th scope="row"><?= $order['nomortransaksi']; ?></th>
            <td><?= $order['id']; ?></td>
            <td><?= $order['nomormeja']; ?></td>
            <td><?= $order['namamenu']; ?></td>
            <th><?= $order['namastaff']; ?></th>
            <td><?= $order['Harga']; ?></td>
            <td><?= $order['quantity']; ?></td>
            <td><?= $order['total']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- Modal Laporan Order-->

</div>

</body>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script>
		$("#menu-toggle").click(function(e) {
		  e.preventDefault();
		  $("#wrapper").toggleClass("toggled");
		});

    const btnForm = document.querySelector('.btnForm');
	const  btnCetak = document.querySelector('.btnCetak');

	const  containerTable = document.querySelector('.containerTable');
	const  containerForm = document.querySelector('.containerForm');

	btnForm.addEventListener("click", ()=>{
		containerTable.toggleAttribute('hidden');
		containerForm.toggleAttribute('hidden');
	});
	btnCetak.addEventListener("click", ()=>{
		containerTable.toggleAttribute('hidden');
		containerForm.toggleAttribute('hidden');
	})
		
		
	</script>
</html>