<?php 
	include "koneksi.php";
	include "functions.php";
	require 'cek-sesi.php';
	$boxMeja = query("SELECT * FROM reservasi JOIN meja ON reservasi.id_reservasi = meja.id_reservasi");
	$boxMenu = query("SELECT * FROM menu");

	$strMeja = "";
	$b = 0;
	foreach ($boxMeja as $MEJA) {
		if($b>0){
			$strMeja .= ",";
	 	}	
		$id_meja = $MEJA['id_meja'];
		$nama_pelanggan = $MEJA['nama_pelanggan'];
		$id_reservasi = $MEJA['id_reservasi'];
		$status = $MEJA['status'];
		$strMeja .= "{'id_meja':'$id_meja','nama_pelanggan':'$nama_pelanggan','id_reservasi':$id_reservasi,'status':'$status'}";
		$b++;	
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Menu </title>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/styles/style.css">
  <link rel="stylesheet" href="assets/styles/sidebar.css">
</head>

<style>	
	.menu{
		display: flex;
		justify-content: space-around;
	}

	menu-item{
		margin: 5px 0;
		display: inline-block;
		width: auto;
	}
	
	#input_div{
		display: flex;
		align-items: center;
		justify-content: center;
	}

	#total{
		text-align: center;
		border: none;
		background: white;
		color:black;
		font-size: 2em;
		margin: auto;
	}

	#count{
		border: none;
		background: white;
		width: 40px;
		color:black;
		font-size: 2em;
	}

	.btnInput{
		cursor: pointer;
		display: inline-block;
		width: 40px;
		border: 1px solid;
		border-radius: 40%;
		text-align: center;
		font-size: 20px;
		background-color: lightblue;
	}

	.buttonSubmit{
		width: 49%;
	}

</style>

<body>

<div class="d-flex" id="wrapper">
	<!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">Welcome , <?= $_SESSION['nama'] ?>  </div>
      <div class="list-group list-group-flush">
	  	<a href="index.php" class="list-group-item list-group-item-action bg-light">Home</a>
        <a href="menu.php" class="list-group-item list-group-item-action bg-light">Pesan</a>
        <a href="menuLaporan.php" class="list-group-item list-group-item-action bg-light">Laporan</a> 
        <a href="logout.php" class="list-group-item list-group-item-action bg-light">logout</a>  
	</div>
    </div>
	<!-- /#sidebar-wrapper -->
	
	<!-- Page Content -->
    <div id="page-content-wrapper">

		<div class="container-fluid banner"></div>
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-info" id="menu-toggle">Toggle Menu</button>

      </nav>

      
	  <div class="container">
		  <?php 
			echo "<input type='hidden' id='hiddenMeja' value=[$strMeja]>";
			foreach ($boxMenu as $menuData) {
				echo "
				<div class='row menu mt-3' style='border : 1px solid' data-toggle='modal' data-target='#ModalMenu'>
				  <menu-item> ".$menuData['id_menu'] ." </menu-item>
				  <menu-item> ".$menuData['nama'] ."</menu-item>
				  <menu-item> Rp. ".$menuData['harga'] ."</menu-item>
				  <menu-item> <img src='./assets/image/". $menuData['gambar'] ."' width='200' ></menu-item>
				</div>";
			}
		   ?>
		   
	  </div>

    </div>
    <!-- /#page-content-wrapper -->


	

	<!-- Modal Pesanan-->
	<div class="modal fade" id="ModalMenu" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Pesan </h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body m-3">
	      </div>
	    </div>
	  </div>
	</div>
	<!-- Modal Pesanan-->	

</div>

</body>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="scriptMenu.js"></script>
</html>