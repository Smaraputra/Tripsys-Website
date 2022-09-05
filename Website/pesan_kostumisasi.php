<?php
	session_start();
	require "koneksi.php";
	if(@$_SESSION["ssstatus"]<1){
		$_SESSION["ssnama"]="Anda Belum Login";
		$_SESSION["ssjabatan"]="!";
	}
	$_SESSION['idpiltra'] = @$_POST['idtravel'];
	$_SESSION['namapiltra'] = @$_POST['namatravel'];
	$pilihan=$_SESSION['idpil'];
	$namapilihan=$_SESSION['namapil'];
	$pilihantra=$_SESSION['idpiltra'];
	$namapilihantra=$_SESSION['namapiltra'];
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
		.pilihanfasilitas{
			border-bottom: 1px solid;
			margin: 10px;
		}
		#submitpesan{
			margin-top: 10px;
			padding:10px;
			color: #ffffff;
			background-color: #007bff;
			border: 0px;
		}
		.hargakanan{
			float: right;
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
				<h1><b>Tripsys | Panel Kostumisasi</b></h1>
				<p class="lead"><b>Silahkan kostumisasi paket wisata sesuai dengan rancangan wisata yang anda inginkan.</b></p>
				<a class="text-white" href="index.php"><b><-- Kembali</b></a>
			</div>
		</div>

		<div class="jumbotron bg-light">
			<div class="container">
				<?php
				echo "<div id='tampilseleksipilihanpaket' class='mb-2'>
						<h3>Kostumisasi Paket $namapilihan Oleh $namapilihantra</h3>
						</div>";
				?>
				
				<div class="row">		
					<div class='col-md-6 mb-2 mt-2'>
						<div class='card'>
							<label class='ml-2 mr-2 text-left'><b>Keterangan Fasilitas</b></label>
						</div>
					</div>
					<div class='col-md-6 mb-2 mt-2'>
						<div class='card'>
							<label class='ml-2 mr-2 text-right'><b>Keterangan Harga</b></label>
						</div>
					</div>
					
						<div class='col-md-12 mb-2 mt-2'>
							<div class='card'>	
								<form id='pilfasi' method='POST' action='konfirmasipesanan.php'>							
								<div class='pilihanfasilitas'>							
						<?php
							$result = mysqli_query($conn,"SELECT id_fasilitas, nama_fasilitas, fasilitas.`deskripsi`, harga FROM fasilitas WHERE fasilitas.`id_nama_wisata`=$pilihan AND fasilitas.`id_travel`=$pilihantra AND fasilitas.`status`='Standar';");
							while($row = mysqli_fetch_array($result)){
								echo "
										<input type='checkbox' name='fasilitas[]' value='". $row['id_fasilitas'] . "'onclick='return false;' checked>
										<label><b>". $row['nama_fasilitas'] . " (Fasilitas Standar)</b></label><label class='hargakanan'><b>Rp.". $row['harga'] . "</b></label><br>
										<label>". $row['deskripsi'] . "</label><br>";
							}
						?>							
						<?php
							$result = mysqli_query($conn,"SELECT id_fasilitas, nama_fasilitas, fasilitas.`deskripsi`, harga FROM fasilitas WHERE fasilitas.`id_nama_wisata`=$pilihan AND fasilitas.`id_travel`=$pilihantra AND fasilitas.`status`='Tambahan' AND fasilitas.`tuntunan`='Tidak';");
							while($row = mysqli_fetch_array($result)){
								echo "<input type='checkbox' name='fasilitas[]' value='". $row['id_fasilitas'] . "'>
										<label><b>". $row['nama_fasilitas'] . "</b></label><label class='hargakanan'><b>Rp.". $row['harga'] . "</b></label><br>
										<label>". $row['deskripsi'] . "</label><br>
										";
							}
						?>
						<?php
							$result = mysqli_query($conn,"SELECT id_fasilitas, nama_fasilitas, fasilitas.`deskripsi`, harga FROM fasilitas WHERE fasilitas.`id_nama_wisata`=$pilihan AND fasilitas.`id_travel`=$pilihantra AND fasilitas.`status`='Tambahan' AND fasilitas.`tuntunan`='Perlu';");
							while($row = mysqli_fetch_array($result)){
								echo "<input type='checkbox' id='chktourguide' name='fasilitas[]' value='". $row['id_fasilitas'] . "'>
										<label><b>". $row['nama_fasilitas'] . "</b></label><label class='hargakanan'><b>Rp.". $row['harga'] . "</b></label><br>
										<label>". $row['deskripsi'] . "</label><br>
										";
							}
						?>
									<select id='tourguide' name='tourguide' class='form-control'>
										<option value='' class='inputform1' selected='true' disabled='disabled'>-----------------------------------------------------Pilihan Tour Guide------------------------------------------------------</option>
						<?php
							$result = mysqli_query($conn,"SELECT id_tourguide, nama FROM tourguide WHERE id_travel=$pilihantra");
							while($row = mysqli_fetch_array($result)){
								echo "
										
										<option value='" . $row['id_tourguide'] . "'>" . $row['nama'] . "</option>";
							}
						?>	
									</select>	
								<label><b>Tanggal Wisata</b></label>
								<input type="date" name="inputtanggal" id="intanggal" class='form-control' required>
								<label><b>Jumlah Orang</b></label>
								<input type="number" name="inputorang" id="inorang" min="1" value="1" class='form-control' required>
								<br>
								</div>
								</form>
							</div>			
						</div>
						<div class='col-md-12 mb-2 mt-2'>
							<div class='card'>
								<input type='submit' id="submitpesan" value='Selanjutnya' onclick='$("#pilfasi").submit()'>
							</div>
						</div>
				</div>
			</div>
		</div>
		<script>
			$('#tourguide').hide();
			$("#error_tgl").hide();
			$('input[type="checkbox"]').on('click', function() {
				if ($('#chktourguide').prop('checked') == true){
					$('#tourguide').show();
				}else{
					$('#tourguide').hide();
				}
				
			});
			
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1;
			var yyyy = today.getFullYear();
			if(dd<10){
				dd='0'+dd
			} 
			if(mm<10){
				mm='0'+mm
			} 
			dd=dd+2;
			today = yyyy+'-'+mm+'-'+dd;
			document.getElementById("intanggal").setAttribute("min", today);
			document.getElementById("intanggal").setAttribute("value", today);
		</script>

		<footer class="bg-primary">
			<div class="fix-bottom text-white text-center pt-3 pb-3">
				<span><b>Copyright @2020 - Tripsys | Project RPL</b></span>
			</div>
		</footer>
	</body>
</html>

										<?php
										//$result = mysqli_query($conn,"SELECT nama, gambar, travel.id_travel,travel.`nama_travel`, nama_wisata.deskripsi FROM nama_wisata 
										//	INNER JOIN fasilitas ON fasilitas.id_nama_wisata=nama_wisata.id_nama_wisata 
										//	INNER JOIN travel ON travel.id_travel=fasilitas.id_travel
										//	WHERE nama_wisata.id_nama_wisata=$pilihan GROUP BY fasilitas.id_travel ASC;");
									//	$result2 = mysqli_query($conn,"SELECT nama, gambar, travel.id_travel,travel.`nama_travel`, nama_wisata.deskripsi FROM nama_wisata 
									//		INNER JOIN fasilitas ON fasilitas.id_nama_wisata=nama_wisata.id_nama_wisata 
									//		INNER JOIN travel ON travel.id_travel=fasilitas.id_travel
									//		WHERE nama_wisata.id_nama_wisata=$pilihan GROUP BY fasilitas.id_travel ASC;");
									//	while($row = mysqli_fetch_array($result)){
									//	echo	"<div class='form-group' id='formlanjutan".$row['id_travel']."'>
									//				<div class='row'>
									//				</div>
									//			</div>";
									//	}
									//	?>