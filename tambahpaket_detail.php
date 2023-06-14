<?php
	session_start();
	require "koneksi.php";
	if(@$_SESSION["ssstatus"]<1){
		$_SESSION["ssnama"]="Anda Belum Login";
		$_SESSION["ssjabatan"]="!";
	}
	$idtravel=$_POST["afiliasi"];
	$idwisata=$_POST["tempat"];
	
	$_SESSION["idtravel"]=$idtravel;
	$_SESSION["idwisata"]=$idwisata;
	
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
		#newpaket{
			margin-top: 10px;
			width: 100%;
			color: white;
			padding: 8px;
			background-color: #007bff;
			border: 0px;
		}
		</style>
		<title>WisataSyS | Go Get The Trip You Want</title>
	</head>
	<body>
		<header>
			<div class="container">
				<nav class="navbar navbar-expand-lg navbar-primary bg-light">
					<a class="navbar-brand" href="#"><b>WisataSyS | </b> The Trip You Want</a>
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
				<h1><b>WisataSyS | Tambah Paket</b></h1>
				<p class="lead"><b>Tambah Paket Wisata Baru.</b></p>
				<a class="text-white" href="index.php"><b><-- Kembali</b></a>
			</div>
		</div>

		<div class="jumbotron bg-light">
			<div class="container">
				<?php
				echo "<div id='tampilkonfirmasipilihanpaket' class='mb-2'>
						<h3 class='text-center'>Tambah Paket Wisata Baru Anda</h3>
						</div>";
				?>
				<div class="row">
					<div class='col-md-12 mb-2 mt-2'>
						<div class='card pl-2 pr-2 pt-2 pb-2'>
							<form method='POST' action='tambahpaket_detaillanjut.php'>
								<div class="ml-3 mr-3 mb-3">
									<label><b>Jumlah Fasilitas Awal</b></label>
									<?php
										$result = mysqli_query($conn,"SELECT COUNT(id_fasilitas) AS jumlah FROM fasilitas WHERE id_travel=$idtravel AND id_nama_wisata=$idwisata");
											while($row = mysqli_fetch_array($result)){
												$jumlah=$row["jumlah"];
											}
										if($jumlah==0){
											echo "<input type='number' name='paketawal' class='form-control' placeholder='Jumlah Paket Awal' min='1' value='1' required>";
										}else{
											echo "<input type='number' name='paketawal' class='form-control' placeholder='Jumlah Paket Awal' min='0' value='0'>";
										}
									?>
								</div>
								<div class="ml-3 mr-3 mb-3">
									<label><b>Jumlah Fasilitas Tambahan</b></label>
									<input type='number' name='pakettambahan' class='form-control' placeholder='Jumlah Paket Tambahan' min='0' value='1'>
									<input type='submit' id='newpaket' value='Selanjutnya'>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
		</script>

		<footer class="bg-primary">
			<div class="fix-bottom text-white text-center pt-3 pb-3">
				<span><b>Copyright @2020 - WisataSyS | Project RPL</b></span>
			</div>
		</footer>
	</body>
</html>