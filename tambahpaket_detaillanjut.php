<?php
	session_start();
	require "koneksi.php";
	if(@$_SESSION["ssstatus"]<1){
		$_SESSION["ssnama"]="Anda Belum Login";
		$_SESSION["ssjabatan"]="!";
	}
	$idpengguna=$_SESSION["ssid"];
	$jumlahawal=$_POST["paketawal"];
	$jumlahtambahan=$_POST["pakettambahan"];

	$result = mysqli_query($conn,"SELECT MAX(id_fasilitas) AS nofasillama FROM fasilitas");
		while($row = mysqli_fetch_array($result)){
		$nofasillama=$row["nofasillama"];
	}
	$nofasilbaru =$nofasillama+1;
	$trace=1;
	$trace1=1;
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
							<form method='POST' action='suksestambahpaket.php'>
								<div class="ml-3 mr-3 mb-3">
									<?php
										if($jumlahawal==0){
										}else{
											echo "<h3 class='text-primary'><b>Fasilitas Awal</b></h3>";
										}
										while($trace<=$jumlahawal){
											echo "<div class='mb-3'>";
											echo "<lable><b>Fasilitas $trace</b></lable>";
											echo "<br><lable>Nama Fasilitas $trace:</lable>";
											echo "<input type='text' name='fasilitasawal[]' class='form-control' placeholder='Fasilitas $trace' required>";
											echo "<br><lable>Deskripsi Fasilitas $trace:</lable>";
											echo "<input type='text' name='deskripsiawal[]' class='form-control' placeholder='Deskripsi Fasilitas $trace' required>";
											echo "<br><lable>Harga Fasilitas $trace (Dalam Rupiah):</lable>";
											echo "<input type='number' name='hargaawal[]' class='form-control' placeholder='Harga Fasilitas $trace' required>";
											echo "<br><lable>Apakah Fasilitas Ini Memerlukan Tourguide?</lable>";
											echo "<select name='perlutgawal[]' class='form-control'>";
											echo "<option value='Tidak'>Tidak</option>";
											echo "<option value='Perlu'>Perlu</option>";
											echo "</select>";
											echo "<br><lable>Apakah Fasilitas Ini Dipesan Untuk Kelompok atau Perorang?</lable>";
											echo "<select name='paxawal[]' class='form-control'>";
											echo "<option value='Perorang'>Perorang</option>";
											echo "<option value='Kelompok'>Kelompok</option>";
											echo "</select>";
											echo "</div>";
											$trace=$trace+1;
										}
									?>
								</div>
								<div class="ml-3 mr-3 mb-3">
									<?php
										if($jumlahtambahan==0){
										}else{
											echo "<h3 class='text-primary'><b>Fasilitas Tambahan</b></h3>";
										}
										while($trace1<=$jumlahtambahan){
											echo "<div class='mb-3 mt-2'>";
											echo "<lable><b>Fasilitas $trace1</b></lable>";
											echo "<br><lable>Nama Fasilitas $trace1:</lable>";
											echo "<input type='text' name='fasilitastambahan[]' class='form-control' placeholder='Fasilitas $trace1' required>";
											echo "<br><lable>Deskripsi Fasilitas $trace1:</lable>";
											echo "<input type='text' name='deskripsitambahan[]' class='form-control' placeholder='Deskripsi Fasilitas $trace1' required>";
											echo "<br><lable>Harga Fasilitas $trace1 (Dalam Rupiah):</lable>";
											echo "<input type='number' name='hargatambahan[]' class='form-control' placeholder='Harga Fasilitas $trace1' required>";
											echo "<br><lable>Apakah Fasilitas Ini Memerlukan Tourguide?</lable>";
											echo "<select name='perlutgtambahan[]' class='form-control'>";
											echo "<option value='Tidak'>Tidak</option>";
											echo "<option value='Perlu'>Perlu</option>";
											echo "</select>";
											echo "<br><lable>Apakah Fasilitas Ini Dipesan Untuk Kelompok atau Perorang?</lable>";
											echo "<select name='paxtambahan[]' class='form-control'>";
											echo "<option value='Perorang'>Perorang</option>";
											echo "<option value='Kelompok'>Kelompok</option>";
											echo "</select>";
											echo "</div>";
											$trace1=$trace1+1;
										}
									?>
									<input type='submit' id='newpaket' value='Tambahkan Paket Baru'>
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