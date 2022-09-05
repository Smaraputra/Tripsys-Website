<?php
	session_start();
	require "koneksi.php";
	if(@$_SESSION["ssstatus"]<1){
		$_SESSION["ssnama"]="Anda Belum Login";
		$_SESSION["ssjabatan"]="!";
	}
	@$_SESSION['infasilitas']= @$_POST['fasilitas'];
	@$_SESSION['intourguide']= @$_POST['tourguide'];
	@$_SESSION['tanggal']	= @$_POST['inputtanggal'];
	@$_SESSION['jumlah']		= @$_POST['inputorang'];
	
	@$_SESSION['idkredit']	= @$_POST['inkredit'];
	@$_SESSION['innokartu']	= @$_POST['innokartu'];
	
	@$bank					= @$_SESSION['idbank'];
	@$rekbank				= @$_SESSION['rekbank'];
	@$namarek				= @$_SESSION['namarek'];
	
	@$kredit				= @$_SESSION['idkredit'];
	@$kartu					= @$_SESSION['innokartu'];
	
	@$nopembayaran			= @$_SESSION['nopembayaran'];
	
	@$_SESSION['upbayar']	= @$_POST['upbayar'];
	@$upbayar				= @$_SESSION['upbayar'];
	
	@$idpelanggan			= @$_SESSION["ssid"];
	@$pilihan				= @$_SESSION['idpil'];
	@$namapilihan			= @$_SESSION['namapil'];
	@$pilihantra			= @$_SESSION['idpiltra'];
	@$namapilihantra		= @$_SESSION['namapiltra'];
	@$fasilitas 			= @$_SESSION['infasilitas'];
	@$tourguide 			= @$_SESSION['intourguide'];
	@$tanggal 				= @$_SESSION['tanggal'];
	@$jumlahorang			= @$_SESSION['jumlah'];
	@$nopaketbaru			= @$_SESSION['nopaketbaru'];
	@$total_harga			= @$_SESSION['total_harga'];
	@$nopesanbaru			= @$_SESSION['nopesanbaru'];
	
	if(@$_SESSION['metodepembayaran']=='Bank'){
		
	}else{
		@$_SESSION['metodepembayaran']= @$_POST['bayar'];
	}
	@$tipe_bayar=@$_SESSION['metodepembayaran'];
	if($tipe_bayar=="Kredit"){
		$result = mysqli_query($conn,"INSERT INTO pembayaran (id_pemesanan, tgl_pembayaran, tipe_pembayaran, status_pembayaran) VALUES ($nopesanbaru, NOW(), '$tipe_bayar', 'Success');");
		$result1 = mysqli_query($conn1,"SELECT MAX(id_pembayaran) AS nopembayaran FROM pembayaran");
		while($row = mysqli_fetch_array($result1)){
			$nopembayaran =	$row["nopembayaran"];
			if($nopembayaran==0){
				$nopembayaran=$nopembayaran+1;
			}
		}
		$result2 = mysqli_query($conn2,"INSERT INTO pembayaran_kredit (id_pembayaran, id_kredit, no_kartu) VALUES ($nopembayaran, $kredit, '$kartu');");
		$result3 = mysqli_query($conn3,"UPDATE pembayaran SET acc_tourguide='Pending', status_kegiatan='Belum' WHERE id_pembayaran=$nopembayaran;");
	}elseif($tipe_bayar=="Bank"){
		$result = mysqli_query($conn,"INSERT INTO pembayaran (id_pemesanan, tgl_pembayaran, tipe_pembayaran, status_pembayaran) VALUES ($nopesanbaru, NOW(), '$tipe_bayar', 'Pending');");
		$result1 = mysqli_query($conn1,"SELECT MAX(id_pembayaran) AS nopembayaran FROM pembayaran");
		while($row = mysqli_fetch_array($result1)){
			$nopembayaran =	$row["nopembayaran"];
			if($nopembayaran==0){
				$nopembayaran=$nopembayaran+1;
			}
		}
		$result2 = mysqli_query($conn2,"INSERT INTO pembayaran_bank (id_pembayaran, id_bank, no_rekening, nama_pemilik) VALUES ($nopembayaran, $bank, '$rekbank', '$namarek');");
		$result3 = mysqli_query($conn3,"UPDATE pembayaran SET bukti_bayar = '$upbayar',acc_tourguide='Pending', status_kegiatan='Belum' WHERE id_pembayaran=$nopembayaran;");
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
		#upload{
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
				<h1><b>Tripsys | Pembayaran Sukses</b></h1>
				<p class="lead"><b>Pembayaran Paket Wisata Anda Telah Selesai. Silahkan Tunggu Konfirmasi Tour Guide Anda.</b></p>
				<a class="text-white" href="index.php"><b><-- Kembali</b></a>
			</div>
		</div>

		<div class="jumbotron bg-light">
			<div class="container">
				<?php
				echo "<div id='tampilkonfirmasipilihanpaket' class='mb-2'>
						<h3 class='text-center'>Resi Pembayaran Anda</h3>
						</div>";
				?>
				<div class="row">		
					<div class='col-md-12 mb-2 mt-2'>
						<div class='card'>
							<div class='pilihanfasilitas'>
								<table id="tablekonfirm" border='2'>
									<tr>
										<th><h4><b>Fasilitas</b></h4></th>
										<th><h4><b>Jumlah</b></h4></th>
										<th><h4><b>Harga</b></h4></th>
										<th><h4><b>Total</b></h4></th>
									</tr>
									<tr>
										<td>
											<?php
												$result = mysqli_query($conn,"SELECT paketwisata.nama_fasilitas, paketwisata.deskripsi FROM fasilitas INNER JOIN paketwisata ON paketwisata.`id_fasilitas`=fasilitas.`id_fasilitas` WHERE no_paketwisata=$nopaketbaru;");
												while($row = mysqli_fetch_array($result)){
													$nama_fasilitas=$row['nama_fasilitas'];
													$deskripsi=$row['deskripsi'];
													echo "<b>$nama_fasilitas</b><br>";
													echo "$deskripsi<br>";
												}
											?>		
										</td>
										<td>
											<?php
												$result = mysqli_query($conn,"SELECT jumlah FROM fasilitas INNER JOIN paketwisata ON paketwisata.`id_fasilitas`=fasilitas.`id_fasilitas` WHERE no_paketwisata=$nopaketbaru;");
												while($row = mysqli_fetch_array($result)){
													$jumlahshow=$row['jumlah'];
													echo "<b>$jumlahshow</b><br><br>";
												}
											?>	
										</td>
										<td>
											<?php
												$result = mysqli_query($conn,"SELECT paketwisata.harga FROM fasilitas INNER JOIN paketwisata ON paketwisata.`id_fasilitas`=fasilitas.`id_fasilitas` WHERE no_paketwisata=$nopaketbaru;");
												while($row = mysqli_fetch_array($result)){
													$harga=$row['harga'];
													echo "<b>Rp. $harga</b><br><br>";
												}
											?>	
										</td>
										<td>
											<?php
												$result = mysqli_query($conn,"SELECT total FROM fasilitas INNER JOIN paketwisata ON paketwisata.`id_fasilitas`=fasilitas.`id_fasilitas` WHERE no_paketwisata=$nopaketbaru;");
												while($row = mysqli_fetch_array($result)){
													$total=$row['total'];
													
													echo "<b>Rp. $total</b><br><br>";
												}
											?>	
										</td>
									</tr>
									<tr>	
										<td colspan="3">
											<h4><b>Total Akhir: </b></h4>
										</td>
										<td>
											<?php
												$result = mysqli_query($conn,"SELECT total_harga FROM fasilitas INNER JOIN paketwisata ON paketwisata.`id_fasilitas`=fasilitas.`id_fasilitas` WHERE no_paketwisata=$nopaketbaru GROUP BY no_paketwisata;");
												while($row = mysqli_fetch_array($result)){
													$total_harga=$row['total_harga'];
													$_SESSION['total_harga']=$row['total_harga'];
													echo "<h4><b>Rp. $total_harga</b></h4>";
												}
											?>	
										</td>
									</tr>
								</table>
								<div>
									<?php
										$result = mysqli_query($conn,"SELECT tgl_wisata FROM fasilitas INNER JOIN paketwisata ON paketwisata.`id_fasilitas`=fasilitas.`id_fasilitas` WHERE no_paketwisata=$nopaketbaru GROUP BY no_paketwisata;");
										while($row = mysqli_fetch_array($result)){
											$tgl=$row['tgl_wisata'];
											echo "<br>Tanggal (Tahun-Bulan-Hari) : <b>$tgl</b>";
										}
									?>	
									<?php
										$result = mysqli_query($conn,"SELECT tourguide.id_tourguide, tourguide.nama FROM paketwisata INNER JOIN tourguide ON tourguide.id_tourguide=paketwisata.id_tourguide WHERE no_paketwisata=$nopaketbaru GROUP BY no_paketwisata;");
										while($row = mysqli_fetch_array($result)){
										echo "<br>Tourguide : <b>".$row['nama']." (ID Tourguide: ".$row['id_tourguide'].")</b>";
										echo "<br>Afiliasi Travel : <b>".$namapilihantra."</b>";
										}
									?>
								</div>
								<div>
									<?php
										echo "<br>ID Pemesanan : <b>$nopesanbaru</b>";
										echo "<br>ID Pembayaran : <b>$nopembayaran</b>";
									?>		
								</div>
							</div>
						</div>			
					</div>
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