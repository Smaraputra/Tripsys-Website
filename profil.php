<?php
	session_start();
	require "koneksi.php";
	if((@$_SESSION["ssstatus"])<1){
		$_SESSION["ssnama"]="Anda Belum Login";
		$_SESSION["ssjabatan"]="!";
	}
	$id=$_SESSION["ssid"];
	if(@$_SESSION['ssedit']==1){
		echo "<script type='text/javascript'>alert('Profil Berhasil Diganti');</script>";
	}
	unset ($_SESSION['ssedit']);
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
		#gantipropil{
			margin-top: 10px;
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
				<h1><b>WisataSyS | Profil</b></h1>
				<p class="lead"><b>Sesuaikan profil diri anda didalam aplikasi.</b></p>
			</div>
		</div>

		<div class="jumbotron bg-light">
			<div class="container">
				<div id="judul" class="text-center text-primary">
					<span id="judulform1" class="text-center"><b>Profil Anda.</b></span>
				</div>
				<div class="row">
					<div class="col-md-12 mb-2">
						<div class='card pb-2 pt-2 pl-3 pr-3'>
							<form method='POST' action='edit_profil.php'>
							<?php
								if($_SESSION["ssjabatan"]=="Tour Guide"){
									$propil="SELECT nama, alamat, email FROM tourguide WHERE id_tourguide=$id";
									$result = mysqli_query($conn,$propil);
										while($row = mysqli_fetch_array($result)){
											echo "
														<h4 class='text-center'>Tour Guide</h4>
														<label><b>Nama</b></label>
														<input type='text' name='nama' class='form-control' value='" . $row['nama'] . "'placeholder='Nama Anda' required>
														<label><b>Alamat</b></label>
														<input type='text' name='alamat' class='form-control' value='" . $row['alamat'] . "'placeholder='Alamat' required>
														<label><b>Email</b></label>
														<input type='text' class='form-control' value='" . $row['email'] . "'placeholder='Email' readonly>
														<input type='hidden' name='tipeakun' value='Tour Guide'>
														<input type='hidden' name='idin' value='".$id."'>
														
													";
										}
								}elseif($_SESSION["ssjabatan"]=="Admin"){
									$propil="SELECT nama, email FROM admin WHERE id_admin=$id";
									$result1 = mysqli_query($conn1,$propil);
										while($row1 = mysqli_fetch_array($result1)){
											echo "
														<h4 class='text-center'>Admin</h4>
														<label><b>Nama</b></label>
														<input type='text' name='nama' class='form-control' value='" . $row1['nama'] . "'placeholder='Nama Anda' required>
														<label><b>Email</b></label>
														<input type='text' class='form-control' value='" . $row1['email'] . "'placeholder='Email' readonly>
														<input type='hidden' name='tipeakun' value='Admin'>
														<input type='hidden' name='idin' value='".$id."'>
													";
										}
								}else if($_SESSION["ssjabatan"]=="Pengguna"){
									$propil="SELECT nama, alamat, telpon, email FROM pelanggan WHERE id_pelanggan=$id";
									$result2 = mysqli_query($conn2,$propil);
										while($row2 = mysqli_fetch_array($result2)){
											echo "
														<h4 class='text-center'>Pengguna</h4>
														<label><b>Nama</b></label>
														<input type='text' name='nama' class='form-control' value='" . $row2['nama'] . "'placeholder='Nama Anda' required>
														<label><b>Alamat</b></label>
														<input type='text' name='alamat' class='form-control' value='" . $row2['alamat'] . "'placeholder='Alamat' required>
														<label><b>No Telepon</b></label>
														<input type='text' name='telpon' class='form-control' value='" . $row2['telpon'] . "'placeholder='No Telpon' required>
														<label><b>Email</b></label>
														<input type='text' class='form-control' value='" . $row2['email'] . "'placeholder='Email' readonly>
														<input type='hidden' name='tipeakun' value='Pengguna'>
														<input type='hidden' name='idin' value='".$id."'>
													";
										}
								}
							?>
								<input type='button' id='passtombol' value='Ganti Password' class='form-control mt-4'>
								<div id='pass1'>
									<label><b>Password Baru</b></label>
									<input type='password' id='masukpass' class='form-control' name='inpass' placeholder='Password'>
									<input type='hidden' name='statusganti' id='masukapagak' value='0'>
								</div>
								<input type='submit' id='gantipropil' class='form-control mt-4'>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			$('#pass1').hide();
			$('#passtombol').on('click', function() {
				$('#pass1').show();
				$('#passtombol').hide();
				$('#masukpass').prop('required',true);
				$('#masukapagak').val(1);
			});
			
		</script>
		<footer class="bg-primary">
			<div class="fix-bottom text-white text-center pt-3 pb-3">
				<span><b>Copyright @2020 - WisataSyS | Project RPL</b></span>
			</div>
		</footer>
	</body>
</html>