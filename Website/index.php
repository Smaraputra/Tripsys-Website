<?php
	session_start();
	require "koneksi.php";
	if((@$_SESSION["ssstatus"])<1){
		$_SESSION["ssnama"]="Anda Belum Login";
		$_SESSION["ssjabatan"]="!";
	}
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="formskrip.js"></script>
		<title>Tripsys | Go Get The Trip You Want</title>
		<style>
		.pesanawal{
			margin-top: 10px;
			padding:10px;
			color: #ffffff;
			background-color: #007bff;
			border: 0px;
		}
		#desc{
			overflow: auto;
		}
		</style>
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
				<h1><b>Tripsys | Beranda</b></h1>
				<p class="lead"><b>Rencanakan rencana wisata yang anda inginkan dengan mudah.</b></p>
			</div>
		</div>

		<div class="jumbotron bg-light">
			<div class="container">
				<div id="judul">
					<span id="judulform1" class="text-center"><b>Pilihlah paket wisata terbaik yang bisa kami tawarkan.</b></span>
				</div>
				<div class="row">
					<?php
						$result = mysqli_query($conn,"SELECT id_nama_wisata, nama, kode, gambar, deskripsi FROM nama_wisata ORDER BY id_nama_wisata ASC");
						while($row = mysqli_fetch_array($result)){
							echo 	"<div class='col-md-4 mb-2'>
									<div class='card'>
									<img src=". $row['gambar'] . " height='150' class='card-img-top' alt='Gambar'>
									<div class='card-body'>
										<h5 class='card-title text-primary'>". $row['nama'] ."</h6>
										<div id='desc'>
										<h6 class='card-text text-black'>". $row['deskripsi'] . "</h6>
										</div>
									<form id='".$row['id_nama_wisata']."' method='POST' action='pesan.php' >
										<input type='hidden' name='id' value='".$row['id_nama_wisata']."'>
										<input type='hidden' name='nama' value='".$row['nama']."'>
										<input type='submit' value='Pesan' class='pesanawal'>
									</form>
									</div>
									</div>
									</div>
									<script>
										$(document).ready(function(){
											$('#".$row['id_nama_wisata']."').submit(function(e){
												$.ajax({
													url			: 'pesan.php',
													type		: 'POST',
													data        : $('#".$row['id_nama_wisata']."').serialize(),
													success: function(data) {			
														alert('Memesan ".$row['nama']."');
													}
												});
											});
										});
									</script>";
						}
					?>
					<?php
					if($_SESSION["ssjabatan"]=="Tour Guide" || $_SESSION["ssjabatan"]=="Admin" ){
						echo "<script>
								$('.pesanawal').hide();
								</script>";
					}
					?>
				</div>
			</div>
		</div>

		<footer class="bg-primary">
			<div class="fix-bottom text-white text-center pt-3 pb-3">
				<span><b>Copyright @2020 - Tripsys | Project RPL</b></span>
			</div>
		</footer>
	</body>
</html>