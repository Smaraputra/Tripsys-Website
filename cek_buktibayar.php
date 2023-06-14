<?php
	session_start();
	require "koneksi.php";
	if(@$_SESSION["ssstatus"]<1){
		$_SESSION["ssnama"]="Anda Belum Login";
		$_SESSION["ssjabatan"]="!";
	}
	$idpengguna=$_SESSION["ssid"];
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
		.cek{
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
				<h1><b>Tripsys | Cek Bukti Pembayaran Pengguna</b></h1>
				<p class="lead"><b>Daftar Bukti Pembayaran Yang Belum Diverifikasi.</b></p>
				<a class="text-white" href="index.php"><b><-- Kembali</b></a>
			</div>
		</div>

		<div class="jumbotron bg-light">
			<div class="container">
				<?php
				echo "<div id='tampilkonfirmasipilihanpaket' class='mb-2'>
						<h3 class='text-center'>Konfirmasi Bukti Pembayaran</h3>
						</div>";
				?>
				<div class="row">
				<?php
					$result		= mysqli_query($conn,"SELECT nama_wisata.nama AS nama_wisata, pelanggan.`id_pelanggan`, pelanggan.`id_pelanggan`, pelanggan.`nama` AS nama_pelanggan, pelanggan.`telpon`,
								pembayaran.id_pembayaran, tourguide.id_tourguide, tourguide.`nama`,paketwisata.tgl_wisata,  
								pembayaran.status_kegiatan, pembayaran.acc_tourguide, pembayaran.tipe_pembayaran, travel.id_travel, travel.nama_travel, pembayaran.status_pembayaran
								FROM fasilitas 
								INNER JOIN paketwisata ON fasilitas.`id_fasilitas`=paketwisata.`id_fasilitas`
								INNER JOIN pemesanan ON pemesanan.`no_paketwisata`=paketwisata.`no_paketwisata`
								INNER JOIN pembayaran ON pembayaran.`id_pemesanan`=pemesanan.`id_pemesanan`
								LEFT JOIN tourguide ON tourguide.`id_tourguide`=paketwisata.`id_tourguide`
								INNER JOIN nama_wisata ON nama_wisata.id_nama_wisata=paketwisata.id_nama_wisata
								INNER JOIN travel ON travel.id_travel=paketwisata.id_travel
								INNER JOIN pelanggan ON pelanggan.`id_pelanggan`=pemesanan.`id_pelanggan`
								WHERE pembayaran.status_pembayaran='Pending' AND pembayaran.bukti_bayar IS NOT NULL
								GROUP BY paketwisata.no_paketwisata;");
					while($row = mysqli_fetch_array($result)){
						echo "
								<div class='col-md-12 mb-2 mt-2'>
									<div class='card pl-2 pr-2 pt-2'>
										<form id='pilihan".$row['id_pembayaran']."' method='POST' action='cek_buktibayar_detail.php'>
										<h5 class='text-primary'><b>ID Pembayaran ".$row['id_pembayaran']." (".$row['tgl_wisata'].")</b></h5>
										<span>Paket Wisata: <b>".$row['nama_wisata']."</b></span></br>
										<span>Travel Penyedia: <b>".$row['nama_travel']."</b></span></br>
										<span>Nama Pemesan: <b>".$row['nama_pelanggan']."</b></span></br>
										<span>Pembayaran Melalui: <b>".$row['tipe_pembayaran']."</b></span></br>
										<span>Status Pembayaran: <b>".$row['status_pembayaran']."</b></span></br>
										<span>Status Penerimaan Oleh Tourguide: <b>".$row['acc_tourguide']."</b></span></br>
										<span>Status Kegiatan : <b>".$row['status_kegiatan']."</b></span></br>
										<input type='hidden' name='detailidpengguna' value='".$row['id_pelanggan']."'>
										<input type='hidden' name='pilihandetail' value='".$row['id_pembayaran']."'>
										<input class='cek' type='submit' value='Cek Detail'>
										</form>
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