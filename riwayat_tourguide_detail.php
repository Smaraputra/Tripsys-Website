<?php
	session_start();
	require "koneksi.php";
	if(@$_SESSION["ssstatus"]<1){
		$_SESSION["ssnama"]="Anda Belum Login";
		$_SESSION["ssjabatan"]="!";
	}
	$idpengguna=$_SESSION["ssid"];
	$idpembayaran=$_POST["pilihandetailpesan"];
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="formskrip.js"></script>
		<style>
		#tampilkonfirmasipilihanpaket{
			padding-top: 10px;
			padding-bottom: 10px;
			border-top: 1px solid;
			border-bottom: 1px solid;
			margin-bottom: 20px;
			color: #007bff;
		}
		.tableriwayat {
			border: 1px solid #007bff;
			width: 100%;
			height: 100%;
			text-align: left;
		}
		.tableriwayat th {
			border: 1px solid #007bff;
			color: white;
			padding: 8px;
			background-color: #007bff;
		}
		.tableriwayat td {
			border: 1px solid #007bff;
			color: #007bff;
			padding: 8px;
			background-color: white;
		}
		.pilihanfasilitas{
			margin: 10px;
		}
		.hargakanan{
			float: right;
		}
		#acc{
			margin-top: 10px;
			width: 100%;
			color: white;
			padding: 8px;
			background-color: #007bff;
			border: 0px;
		}
		</style>
		<title>Tripsys | Go Get The Trip You Want</title>
	</head>
	<body>
		<header>
			<div class="container">
				<nav class="navbar navbar-expand-lg navbar-primary bg-light">
					<a class="navbar-brand" href="#"><b>Tripsys | </b> The Trip You Want</a>
					<div class="collapse navbar-collapse">
						<ul class="navbar-nav mr-auto">
							<li class="nav-item active">
								<a class="nav-link" href="index.php">Beranda</a>
							</li>
							<?php
								if($_SESSION["ssjabatan"]=="Tour Guide"){
									echo "<li class='nav-item active'>";
									echo "<a class='nav-link' href='tambahpaket.php' id='tambahpaket'>Tambah Paket</a>";
									echo "</li>";
									echo "<li class='nav-item active'>";
									echo "<a class='nav-link' href='editpaket.php' id='editpaket'>Ubah Paket</a>";
									echo "</li>";
									echo "<li class='nav-item active'>";
									echo "<a class='nav-link' href='terimapesan.php' id='konfirmasipesanan'>Konfirmasi Pesanan</a>";
									echo "</li>";
									echo "<li class='nav-item active'>";
									echo "<a class='nav-link' href='riwayat_tourguide.php' id='riwayattourguide'>Riwayat</a>";
									echo "</li>";
									echo "<li class='nav-item active'>";
									echo "<a class='nav-link' href='profil.php' id='profiltg'>Profil</a>";
									echo "</li>";
								}
								if($_SESSION["ssjabatan"]=="Pengguna"){
									echo "<li class='nav-item active'>";
									echo "<a class='nav-link' href='riwayat_pengguna.php' id='riwayatpengguna'>Riwayat</a>";
									echo "</li>";
									echo "<li class='nav-item active'>";
									echo "<a class='nav-link' href='profil.php' id='profilpg'>Profil</a>";
									echo "</li>";
								}
								if($_SESSION["ssjabatan"]=="Admin"){
									echo "<li class='nav-item active'>";
									echo "<a class='nav-link' href='cek_buktibayar.php' id='cekbuktibayar'>Cek Bukti Bayar</a>";
									echo "</li>";
									echo "<li class='nav-item active'>";
									echo "<a class='nav-link' href='cek_kegiatan.php' id='cekkegiatan'>Cek Bukti Kegiatan</a>";
									echo "</li>";
									echo "<li class='nav-item active'>";
									echo "<a class='nav-link' href='profil.php' id='profila'>Profil</a>";
									echo "</li>";
								}
							?>
						</ul>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item active">
								<a class="nav-link" href="login.php" id="showlogin">Login</a>
							</li>
							<li class="nav-item active">
								<a class="nav-link" href="signup.php" id="showsignup"><b>Signup</b></a>
							</li>
						</ul>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item active">
								<a class="nav-link" id="user" href="#"><?php echo $_SESSION["ssnama"];?> <b>(<?php echo $_SESSION["ssjabatan"];?>)</b></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
			
		<div class="jumbotron bg-primary text-white mb-4 mt-2">
			<div class="container">
				<h1><b>Tripsys | Riwayat Pengguna</b></h1>
				<p class="lead"><b>Lihat daftar kegiatan anda selama menggunakan aplikasi ini.</b></p>
				<a class="text-white" href="riwayat_tourguide.php"><b><-- Kembali</b></a>
			</div>
		</div>

		<div class="jumbotron bg-light">
			<div class="container">
				<?php
				echo "<div id='tampilkonfirmasipilihanpaket' class='mb-2'>
						<h3 class='text-center'>Riwayat Anda</h3>
						</div>";
				?>
				<div class="row">
				<?php
					$result 	= mysqli_query($conn,"SELECT id_pembayaran FROM pembayaran 
								INNER JOIN pemesanan ON pembayaran.`id_pemesanan`=pemesanan.`id_pemesanan`
								INNER JOIN paketwisata ON paketwisata.no_paketwisata=pemesanan.no_paketwisata
								WHERE id_pembayaran=$idpembayaran GROUP BY paketwisata.no_paketwisata;;");
					$result1 	= mysqli_query($conn,"SELECT nama_wisata.nama, nama_wisata.gambar, nama_wisata.deskripsi FROM nama_wisata 
								INNER JOIN paketwisata ON nama_wisata.`id_nama_wisata`=paketwisata.`id_nama_wisata`
								INNER JOIN pemesanan ON pemesanan.`no_paketwisata`=paketwisata.`no_paketwisata`
								INNER JOIN pembayaran ON pembayaran.`id_pemesanan`=pemesanan.`id_pemesanan`
								WHERE id_pembayaran=$idpembayaran GROUP BY pemesanan.`no_paketwisata`;");
					$result2	= mysqli_query($conn,"SELECT paketwisata.nama_fasilitas, paketwisata.deskripsi, paketwisata.harga, paketwisata.`jumlah`, paketwisata.`total` 
								FROM fasilitas 
								INNER JOIN paketwisata ON fasilitas.`id_fasilitas`=paketwisata.`id_fasilitas`
								INNER JOIN pemesanan ON pemesanan.`no_paketwisata`=paketwisata.`no_paketwisata`
								INNER JOIN pembayaran ON pembayaran.`id_pemesanan`=pemesanan.`id_pemesanan`
								WHERE id_pembayaran=$idpembayaran;");
					$result3	= mysqli_query($conn,"SELECT paketwisata.`total_harga` FROM fasilitas 
								INNER JOIN paketwisata ON fasilitas.`id_fasilitas`=paketwisata.`id_fasilitas`
								INNER JOIN pemesanan ON pemesanan.`no_paketwisata`=paketwisata.`no_paketwisata`
								INNER JOIN pembayaran ON pembayaran.`id_pemesanan`=pemesanan.`id_pemesanan`
								WHERE id_pembayaran=$idpembayaran GROUP BY paketwisata.no_paketwisata;");
					$result4	= mysqli_query($conn,"SELECT tourguide.id_tourguide, tourguide.`nama`,paketwisata.tgl_wisata, 
								pembayaran.status_kegiatan, pembayaran.status_pembayaran, pembayaran.acc_tourguide, pembayaran.tipe_pembayaran FROM fasilitas 
								INNER JOIN paketwisata ON fasilitas.`id_fasilitas`=paketwisata.`id_fasilitas`
								INNER JOIN pemesanan ON pemesanan.`no_paketwisata`=paketwisata.`no_paketwisata`
								INNER JOIN pembayaran ON pembayaran.`id_pemesanan`=pemesanan.`id_pemesanan`
								LEFT JOIN tourguide ON tourguide.`id_tourguide`=paketwisata.`id_tourguide`
								WHERE id_pembayaran=$idpembayaran GROUP BY paketwisata.no_paketwisata;");
					$result5	= mysqli_query($conn,"SELECT nama_wisata.nama AS nama_wisata, pelanggan.`id_pelanggan`, pelanggan.`id_pelanggan`, pelanggan.`nama` AS nama_pelanggan, pelanggan.`telpon`,
								pembayaran.id_pembayaran, tourguide.id_tourguide, tourguide.`nama`,paketwisata.tgl_wisata,  
								pembayaran.status_kegiatan, pembayaran.acc_tourguide, pembayaran.tipe_pembayaran, travel.nama_travel, pembayaran.status_pembayaran
								FROM fasilitas 
								INNER JOIN paketwisata ON fasilitas.`id_fasilitas`=paketwisata.`id_fasilitas`
								INNER JOIN pemesanan ON pemesanan.`no_paketwisata`=paketwisata.`no_paketwisata`
								INNER JOIN pembayaran ON pembayaran.`id_pemesanan`=pemesanan.`id_pemesanan`
								LEFT JOIN tourguide ON tourguide.`id_tourguide`=paketwisata.`id_tourguide`
								INNER JOIN nama_wisata ON nama_wisata.id_nama_wisata=paketwisata.id_nama_wisata
								INNER JOIN travel ON travel.id_travel=paketwisata.id_travel
								INNER JOIN pelanggan ON pelanggan.`id_pelanggan`=pemesanan.`id_pelanggan`
								WHERE id_pembayaran=$idpembayaran
								GROUP BY paketwisata.no_paketwisata;");
					while($row = mysqli_fetch_array($result)){
						echo "	<div class='col-md-12 mb-2 mt-2'>
									<div class='card pl-2 pr-2'>
										<div class='mb-2 mt-2'>
											<h4 class='text-center text-primary'><b>ID Pembayaran ".$row['id_pembayaran']."</b></h4>
										</div>
										<div class='row'>";
						while($row1 = mysqli_fetch_array($result1)){
							echo "			<div class='col-md-4 mb-2 mt-2'>
												<div class='card pl-2 pr-2 pt-2 pb-2'>
													<img src='".$row1['gambar']."' height='200px' width='100%'>
													<h5 class='text-center mt-2'>".$row1['nama']."</h5>
													<p>".$row1['deskripsi']."</p>
												</div>
											</div>
											<div class='col-md-8 mb-2 mt-2'>
												<div class='card pl-2 pr-2 pt-2 pb-2'>
													<table class='tableriwayat'>
														<tr>
															<th><h4>Fasilitas</h4></th>
															<th><h4>Harga</h4></th>
															<th><h4>Jumlah</h4></th>
															<th><h4>Total</h4></th>
														</tr>";
							while($row2 = mysqli_fetch_array($result2)){
								echo 				"	<tr>
															<td><b>".$row2['nama_fasilitas']."</b><br>".$row2['deskripsi']."</td>
															<td>Rp. ".$row2['harga']."</td>
															<td>".$row2['jumlah']."</td>
															<td>Rp. ".$row2['total']."</td>
														</tr>";
							}
							while($row3 = mysqli_fetch_array($result3)){
									echo 				"<tr>
															<td colspan='3'><b>Total Harga</b></td>
															<td><b>Rp. ".$row3['total_harga']."</b></td>
														</tr>";
							}
						}
						echo "						</table>
													<div>";
						while($row4 = mysqli_fetch_array($result4)){
							echo "<br>";
						    if(isset($row4['nama'])){
							echo "							
															<span>Tourguide : <b>".$row4['nama']."(ID : ".$row4['id_tourguide'].")</b><span><br>";
							}
							echo "
															<span>Tanggal Wisata : (Tahun-Bulan-Hari) : <b>".$row4['tgl_wisata']."</b><span><br>
															<span>Metode Pembayaran : <b>".$row4['tipe_pembayaran']."</b><span><br>
															<span>Status Pembayaran: <b>".$row4['status_pembayaran']."</b></span></br>
															<span>Status Penerimaan Oleh Guide : <b>".$row4['acc_tourguide']."</b><span><br>
															<span>Status Kegiatan : <b>".$row4['status_kegiatan']."</b><span><br>
													";
						}
						while($row5 = mysqli_fetch_array($result5)){
							echo "							<br>
															<form method='POST' action='suksesupbukti.php'>
															<span>Pelanggan : <b>".$row5['nama_pelanggan']."(ID : ".$row5['id_pelanggan'].")</b><span><br>
															<span>No Telpon : <b>".$row5['telpon']."</b><span><br><br>
															<label>Kirimkan Bukti Pelaksanaan Kegiatan</label>
															<input type='hidden' name='accpembayaran' value='".$row5['id_pembayaran']."'>
															<input type='text' name='buktibayar' class='form-control'>
															<br>
															<input type='submit' id='acc' value='Kirim Bukti'>
															</form>
													";
						}
						echo "						</div>
												</div>
											</div>
										</div>
									</div>
								</div>";
					}
				?>
				</div>
			</div>
		</div>
		<script>
		</script>

		<footer class="bg-primary">
			<div class="fix-bottom text-white text-center pt-3 pb-3">
				<span><b>Copyright @2020 - Tripsys | Project RPL</b></span>
			</div>
		</footer>
	</body>
</html>