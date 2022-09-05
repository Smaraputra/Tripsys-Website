<?php
	session_start();
	if((@$_SESSION["showgagallogin"])==1){
		echo '<script>alert("Login Gagal. Ulangi Kembali.")</script>'; 
	}
	if((@$_SESSION["showsignup"])==1){
		echo '<script>alert("Signup Sukses.")</script>'; 
	}
	$_SESSION["showgagallogin"]	= 0;
	$_SESSION["showsignup"]	= 0;
	unset($_SESSION["ssnama"]);
	unset($_SESSION["ssjabatan"]);
	unset($_SESSION["ssid"]);
	unset($_SESSION["ssstatus"]);
	$_SESSION["ssid"]		= "";
	$_SESSION["ssnama"]	= "";
	$_SESSION["ssjabatan"]	= "";
	$_SESSION["ssstatus"]	= "";
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
				<h1><b>Tripsys | Panel Login</b></h1>
				<p class="lead"><b>Silahkan masukan kredensial login anda pada form dibawah ini.</b></p>
			</div>
		</div>

		<div class="jumbotron bg-light">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<form class="text-left" method="POST" id="formlogin" action="login_form.php">
							<div class="mb-3">
								<label for="inputemail" class="form-label">Email address</label>
								<input type="email" class="form-control" id="inputemail" name="inemail" required>
							</div>
							<div class="mb-3">
								<label for="inputpass" class="form-label">Password</label>
								<input type="password" class="form-control" id="inputpass" name="inpass" required>
							</div>
							<div class="mb-3">
								<label for="tipeakun" class="form-label">Tipe Login</label>
								<select id="tipeakun" name="intipeakun" class="form-control">
									<option value="" class="inputform1" disabled>------------------Tipe Akun-------------------</option>
									<option value="1" class="inputform1">Pengguna</option>
									<option value="2" class="inputform1">Tour Guide</option>
									<option value="3" class="inputform1">Admin</option>
								</select>
							<div id="help" class="form-text">Kami tidak akan membagikan email dan password anda ke pihak manapun.</div>
							</div>
							<button type="submit" class="btn btn-primary">Login</button>
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