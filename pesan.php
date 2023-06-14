<?php
	session_start();
	require "koneksi.php";
	if(@$_SESSION["ssstatus"]<1){
		$_SESSION["ssnama"]="Anda Belum Login";
		$_SESSION["ssjabatan"]="!";
	}
	$_SESSION['idpil'] = $_POST['id'];
	$_SESSION['namapil'] = $_POST['nama'];
	$pilihan=$_SESSION['idpil'];
	$namapilihan=$_SESSION['namapil'];
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
		#tampilseleksipilihanpaket{
			padding-top: 10px;
			padding-bottom: 10px;
			border-top: 1px solid;
			border-bottom: 1px solid;
			margin-bottom: 20px;
			color: #007bff;
		}
		#lihat{
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
				<h1><b>WisataSyS | Panel Pesan</b></h1>
				<p class="lead"><b>Silahkan pilih travel penyedia paket wisata buat rancangan wisata yang anda inginkan.</b></p>
				<a class="text-white" href="index.php"><b><-- Kembali</b></a>
			</div>
		</div>

		<div class="jumbotron bg-light">
			<div class="container">
				<?php
				echo "<div id='tampilseleksipilihanpaket' class='mb-2'>
						<h3>Menunjukkan Daftar Pilihan Travel Penyedia Paket ($namapilihan)</h3>
						</div>";
				?>
				<div class="row">						
						<?php
							$result = mysqli_query($conn,"SELECT nama, gambar, 
												travel.id_travel,travel.`nama_travel`, nama_wisata.deskripsi, 
												sum(harga) AS harga 
												FROM nama_wisata 
												INNER JOIN fasilitas ON fasilitas.id_nama_wisata=nama_wisata.id_nama_wisata 
												INNER JOIN travel ON travel.id_travel=fasilitas.id_travel
												WHERE nama_wisata.id_nama_wisata=$pilihan AND fasilitas.`status`='Standar' GROUP BY fasilitas.id_travel ASC ;");
							while($row = mysqli_fetch_array($result)){
								echo "	<div class='col-md-6 mb-2 mt-2'>
										<div class='card'>
										<img src=". $row['gambar'] . " class='card-img-top mb-2' alt='Gambar'>
											<div class='text-center ml-4 mr-4'>
											<h5 class='card-title text-info mx-auto'>". $row['nama'] ."</h6>
											</div>
											<div class='text-center ml-4 mr-4'>
											<h6 class='card-text mx-auto'>". $row['deskripsi'] . "</h6>
											</div>
										<div class='card-body' >
											<div class='text-center'>
											<h6 class='card-text'>Travel Penyedia: <b>". $row['nama_travel'] . "</b></h6>
											</div>
											<div class='text-center'>
											<h6 class='card-text'>Harga Mulai Dari: <b>Rp.". $row['harga'] . "</b></h6>
											</div>
											<div class='text-center mt-4'>
											<form id='".$row['id_travel']."' method='POST' action='pesan_kostumisasi.php' >
												<input type='hidden' name='idtravel' value='".$row['id_travel']."'>
												<input type='hidden' name='namatravel' value='".$row['nama_travel']."'>
												<input id='lihat' type='submit' value='Lihat Detail Paket Ini'>
											</form>
											</div>
										</div>
										</div>
										</div>

										<script>
										$(document).ready(function(){
											$('#".$row['id_travel']."').submit(function(e){
												$.ajax({
													url			: 'pesan_kostumisasi.php',
													type		: 'POST',
													data        : $('#".$row['id_travel']."').serialize(),
													success: function(data) {			
														alert('Memilih ".$row['nama_travel']."');
													}
												});
											});
										});
										</script>";
							}
						?>							
			</div>			
				<script>
					$('#otherFieldGroupDiv1').hide();
					$('#otherFieldGroupDiv2').hide();
					$("#seeAnotherFieldGroup").change(function() {
						if ($(seeAnotherFieldGroup).val() == 1) {
							$('#otherFieldGroupDiv1').show();
							$('#otherFieldGroupDiv2').hide();
						} else if($(seeAnotherFieldGroup).val() == 2) {
							$('#otherFieldGroupDiv1').hide();
							$('#otherFieldGroupDiv2').show();
						}
					});
				</script>
			</div>
		</div>

		<footer class="bg-primary">
			<div class="fix-bottom text-white text-center pt-3 pb-3">
				<span><b>Copyright @2020 - WisataSyS | Project RPL</b></span>
			</div>
		</footer>
	</body>
</html>