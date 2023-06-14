<?php
	session_start();
	require "koneksi.php";
	if((@$_SESSION["ssstatus"])<1){
		$_SESSION["ssnama"]="Anda Belum Login";
		$_SESSION["ssjabatan"]="!";
	}
	$inid=$_SESSION['ssid'];
?>
<html>
	<head>
	
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="formskrip.js"></script>
		<title>WisataSyS | Go Get The Trip You Want</title>
		<style>
		#desc{
			overflow: auto;
		}
		#tampilkonfirmasipilihanpaket{
			padding-top: 10px;
			padding-bottom: 10px;
			border-top: 1px solid;
			border-bottom: 1px solid;
			margin-bottom: 20px;
			color: #007bff;
		}
		</style>
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
				<h1><b>WisataSyS | Panel Edit Paket</b></h1>
				<p class="lead"><b>Edit Paket Wisata Yang Sudah Anda Buat.</b></p>
			</div>
		</div>

		<div class="jumbotron bg-light">
			<div class="container">
				<?php
				echo "<div id='tampilkonfirmasipilihanpaket' class='text-center mb-4'>
						<h3>Pilih Paket Wisata Yang Ingin Diedit</h3>
						</div>";
				?>
					<div class="row">
					<?php
						$result = mysqli_query($conn,"
								SELECT tourguide.id_travel, nama_wisata.id_nama_wisata, nama_wisata.nama, gambar, nama_wisata.deskripsi
								FROM nama_wisata
								INNER JOIN fasilitas ON fasilitas.id_nama_wisata=nama_wisata.id_nama_wisata
								INNER JOIN travel ON fasilitas.id_travel=travel.id_travel
								INNER JOIN tourguide ON tourguide.id_travel=travel.id_travel
								WHERE fasilitas.id_travel=(SELECT tourguide.id_travel FROM tourguide WHERE tourguide.id_tourguide=$inid)
								GROUP BY fasilitas.id_nama_wisata;");
						while($row = mysqli_fetch_array($result)){
							echo 	"<div class='col-md-4 mb-2'>
									<div class='card'>
									<img src=". $row['gambar'] . " height='150' class='card-img-top' alt='Gambar'>
									<div class='card-body'>
										<h5 class='card-title text-primary'>". $row['nama'] ."</h6>
										<div id='desc'>
										<h6 class='card-text text-black'>". $row['deskripsi'] . "</h6>
										</div>
									<form id='".$row['id_nama_wisata']."' method='POST' action='edit_paketdetail.php' >
										<input type='hidden' name='idwisata' value='".$row['id_nama_wisata']."'>
										<input type='hidden' name='idtravel' value='".$row['id_travel']."'>
										<input type='submit' class='form-control mt-4 bg-primary text-white' value='Ganti Paket Wisata Ini' class='pesanawal'>
									</form>
									</div>
									</div>
									</div>
									<script>
										$(document).ready(function(){
											$('#".$row['id_nama_wisata']."').submit(function(e){
												$.ajax({
													url			: 'edit_paketdetail.php',
													type		: 'POST',
													data        : $('#".$row['id_nama_wisata']."').serialize(),
													success: function(data) {			
														alert('Mengedit Paket ".$row['nama']."');
													}
												});
											});
										});
									</script>";
						}
					?>
					</div>
				</div>
			</div>
		</div>

		<footer class="bg-primary">
			<div class="fix-bottom text-white text-center pt-3 pb-3">
				<span><b>Copyright @2020 - WisataSyS | Project RPL</b></span>
			</div>
		</footer>
	</body>
</html>