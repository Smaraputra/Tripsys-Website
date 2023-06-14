<?php
	session_start();
	require "koneksi.php";
	if(@$_SESSION["ssstatus"]<1){
		$_SESSION["ssnama"]="Anda Belum Login";
		$_SESSION["ssjabatan"]="!";
	}
	$_SESSION['infasilitas']= @$_POST['fasilitas'];
	$_SESSION['intourguide']= @$_POST['tourguide'];
	$_SESSION['tanggal']	= @$_POST['inputtanggal'];
	$_SESSION['jumlah']		= @$_POST['inputorang'];
	$idpelanggan			= $_SESSION["ssid"];
	$pilihan				= $_SESSION['idpil'];
	$namapilihan			= $_SESSION['namapil'];
	$pilihantra				= $_SESSION['idpiltra'];
	$namapilihantra			= $_SESSION['namapiltra'];
	$fasilitas 				= $_SESSION['infasilitas'];
	$tourguide 				= $_SESSION['intourguide'];
	$tanggal 				= $_SESSION['tanggal'];
	$jumlahorang			= $_SESSION['jumlah'];
	$nopaketbaru			= $_SESSION['nopaketbaru'];
	$total_harga			= $_SESSION['total_harga'];

	$result = mysqli_query($conn,"SELECT MAX(id_pemesanan) AS nopesanlama FROM pemesanan");
	while($row = mysqli_fetch_array($result)){
		$nopesanlama =	$row["nopesanlama"];
	}
	$nopesanbaru=$nopesanlama+1;
	$_SESSION['nopesanbaru']=$nopesanbaru;
	$result = mysqli_query($conn,"INSERT INTO pemesanan (id_pelanggan, no_paketwisata, tgl_pemesanan) VALUES ($idpelanggan, $nopaketbaru, NOW())");
	
	unset($_SESSION['metodepembayaran']);
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
		#tablekonfirm {
			border: 1px solid #007bff;
			width: 100%;
			height: 100%;
			text-align: left;
		}
		#tablekonfirm th {
			border: 1px solid #007bff;
			color: white;
			padding: 8px;
			background-color: #007bff;
		}
		#tablekonfirm td {
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
		#checkout{
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
				<h1><b>WisataSyS | Panel Pembayaran</b></h1>
				<p class="lead"><b>Lakukan pembayaran pada paket wisata yang sudah anda buat.</b></p>
				<a class="text-white" href="index.php"><b><-- Kembali</b></a>
			</div>
		</div>

		<div class="jumbotron bg-light">
			<div class="container">
				<?php
				echo "<div id='tampilkonfirmasipilihanpaket' class='mb-2'>
						<h3>Pembayaran Paketwisata dengan ID Pemesanan $nopesanbaru (Rp. $total_harga)</h3>
						</div>";
				?>
				<div class="row">		
					<div class='col-md-12 mb-2 mt-2'>
						<div class='card'>
							<form id='pembayaran' method='POST' action=''>			
								<div class="mb-3 ml-3 mr-3">
									<label for="metodebayar" class="form-label mt-2"><b>Metode Pembayaran</b></label>
									<select id="metodebayar" name="bayar" class="form-control">
										<option value="0" class="inputform1" selected="true" disabled="disabled">------------------Metode Pembayaran-------------------</option>
										<option value="Bank" class="inputform1">Bank</option>
										<option value="Kredit" class="inputform1">Kredit</option>
									</select>
								</div>
								<div class="mb-3 ml-3 mr-3" id="bayarbank">
									<div class="mb-3">
									<label for="inputbank" class="form-label"><b>Bank Penyedia</b></label>
									<select id="inputbank" name="inbank" class="form-control">
									<option value="" class="inputform1" selected="true" disabled="disabled">-------------------Pilihan Bank--------------------</option>
									<?php
										$result = mysqli_query($conn,"SELECT id_bank, nama FROM bank ORDER BY id_bank ASC");
										while($row = mysqli_fetch_array($result)){
											echo "<option value='" . $row['id_bank'] . "'>" . $row['nama'] . "</option>";
										}
									?>
									</select>
									</div>
									<div class="mb-3">
									<label for="inputrekening" class="form-label"><b>Nomor Rekening</b></label>
									<input type="text" name="inrekening" id="inputrekening" class='form-control' placeholder="Nomor Rekening">
									</div>
									<div class="mb-3">
									<label for="inputnamarek" class="form-label"><b>Nama Rekening</b></label>
									<input type="text" name="innamarek" id="inputnamarek" class='form-control' placeholder="Nama Rekening">
									</div>
								</div>
								<div class="mb-3 ml-3 mr-3" id="bayarkredit">
									<div class="mb-3">
									<label for="inputkredit" class="form-label"><b>Kredit Penyedia</b></label>
									<select id="inputkredit" name="inkredit" class="form-control">
									<option value="" class="inputform1" selected="true" disabled="disabled">-------------------Pilihan Kredit--------------------</option>
									<?php
										$result = mysqli_query($conn,"SELECT id_kredit, nama FROM kredit ORDER BY id_kredit ASC");
										while($row = mysqli_fetch_array($result)){
											echo "<option value='" . $row['id_kredit'] . "'>" . $row['nama'] . "</option>";
										}
									?>
									</select>
									</div>
									<div class="mb-3">
									<label for="inputnokartu" class="form-label"><b>Nomor Kartu</b></label>
									<input type="text" name="innokartu" id="inputnokartu" class='form-control' placeholder="Nomor Kartu">
									</div>
								</div>
								<div class="mb-3 ml-3 mr-3">
									<input type="submit" id="checkout" value="Checkout">
								</div>
							</form>
						</div>			
					</div>
				</div>
			</div>
		</div>
		<script>
		$('#bayarbank').hide();
		$('#bayarkredit').hide();
		$("#metodebayar").change(function() {
			if ($('#metodebayar').val() == 0) {
				$('#bayarbank').hide();
				$('#bayarkredit').hide();
			} else if($('#metodebayar').val() == 'Bank') {
				$('#bayarbank').show();
				$('#bayarkredit').hide();
				$('#pembayaran').attr('action', 'upload_pembayaran.php');
			} else {
				$('#bayarbank').hide();
				$('#bayarkredit').show();
				$('#pembayaran').attr('action', 'sukses.php');
			}
		});
		</script>

		<footer class="bg-primary">
			<div class="fix-bottom text-white text-center pt-3 pb-3">
				<span><b>Copyright @2020 - WisataSyS | Project RPL</b></span>
			</div>
		</footer>
	</body>
</html>