<?php
	session_start();
	require "koneksi.php";
	if(@$_SESSION["showsignup"]==1){
		echo '<script>alert("Signup Gagal. Email sudah dipakai.")</script>';
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
						</ul>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item active">
								<a class="nav-link" href="login.php">Login</a>
							</li>
							<li class="nav-item active">
								<a class="nav-link" href="signup.php"><b>Signup</b></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
			
		<div class="jumbotron bg-primary text-white mb-4 mt-2">
			<div class="container">
				<h1><b>Tripsys | Panel Signup</b></h1>
				<p class="lead"><b>Silahkan masukan data anda pada form dibawah ini untuk mendaftarkan akun baru anda.</b></p>
			</div>
		</div>

		<div class="jumbotron bg-light">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<form class="text-left" method="POST" id="formlogin" action="signup_form.php">
							<div class="mb-3">
								<label for="inputnama" class="form-label">Nama Anda</label>
								<input type="text" class="form-control" id="inputnama" name="innama" required>
							</div>
							<div class="mb-3">
								<label for="inputalamat" class="form-label">Alamat Anda</label>
								<input type="text" class="form-control" id="inputalamat" name="inalamat" required>
							</div>
							<div class="mb-3">
								<label for="inputtelp" class="form-label">No Telpon Anda</label>
								<input type="text" class="form-control" id="inputtelp" name="intelp" required>
							</div>
							<div class="mb-3">
								<label for="inputemail" class="form-label">Email Baru</label>
								<input type="email" class="form-control" id="inputemail" name="inemail" required>
							</div>
							<div class="mb-3">
								<label for="inputpass" class="form-label">Password Baru</label>
								<input type="password" class="form-control" id="inputpass" name="inpass" required>
							</div>
							<div class="mb-3">
								<label for="tipeakunbaru" class="form-label">Tipe Akun</label>
								<select id="tipeakunbaru" name="intipeakunbaru" class="form-control" required>
									<option value="0" class="inputform1" selected="true" disabled="disabled">------------------Tipe Akun-------------------</option>
									<option value="1" class="inputform1">Pengguna</option>
									<option value="2" class="inputform1">Tour Guide</option>
								</select>
							<div id="help" class="form-text">Kami tidak akan membagikan email dan password anda ke pihak manapun.</div>
							</div>
							<div class="mb-3" id="signuptravel">
								<label for="travelbaru" class="form-label">Afiliasi Travel</label>
								<select id="travelbaru" name="intravelbaru" class="form-control">
									<option value="" class="inputform1" selected="true" disabled="disabled">-------------------Travel--------------------</option>
									<?php
										$result = mysqli_query($conn,"SELECT id_travel, nama_travel FROM travel ORDER BY id_travel ASC");
										while($row = mysqli_fetch_array($result)){
											echo "<option value='" . $row['id_travel'] . "'>" . $row['nama_travel'] . "</option>";
										}
									?>
								</select>
							<div id="help" class="form-text">*Hanya diisi untuk tipe akun Tour Guide.</div>
							</div>
							<button type="submit" class="btn btn-primary">Signup</button>
							<script>
								$('#signuptravel').hide();
								$("#tipeakunbaru").change(function() {
									if ($(tipeakunbaru).val() == 0) {
										$('#signuptravel').hide();
									} else if($(tipeakunbaru).val() == 1) {
										$('#signuptravel').hide();
									} else {
										$('#signuptravel').show();
										$("#travelbaru").prop('required',true);
									}
								});
							</script>
						</form>
					</div>
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