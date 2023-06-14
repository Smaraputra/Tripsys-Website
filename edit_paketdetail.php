<?php
	session_start();
	require "koneksi.php";
	if((@$_SESSION["ssstatus"])<1){
		$_SESSION["ssnama"]="Anda Belum Login";
		$_SESSION["ssjabatan"]="!";
	}
	if(isset($_SESSION['idwisata'])){
		@$idwisata=@$_SESSION['idwisata'];
	}
	if(isset($_SESSION['idtravel'])){
		@$idtravel=@$_SESSION['idtravel'];
	}
	@$idwisata=@$_POST['idwisata'];
	@$idtravel=@$_POST['idtravel'];
	
	$_SESSION['idwisata']=$idwisata;
	$_SESSION['idtravel']=$idtravel;
    $result = mysqli_query($conn,"
								SELECT fasilitas.`id_fasilitas`, nama_fasilitas, fasilitas.`deskripsi`, 
								fasilitas.`harga`, fasilitas.`status`, fasilitas.`tuntunan`, fasilitas.`perpax`
								FROM fasilitas
								INNER JOIN nama_wisata ON fasilitas.id_nama_wisata=nama_wisata.id_nama_wisata
								WHERE id_travel=$idtravel AND fasilitas.id_nama_wisata=$idwisata
								ORDER BY fasilitas.id_nama_wisata;");
	if($result==NULL){
	    header("Location: editpaket.php");
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
		#editpakettombol{
			margin-top: 10px;
			color: #ffffff;
			background-color: #007bff;
			border: 0px;
		}
		.delete{
			background-color: red;
			color: white;
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
		
		<form id='editpkt' action='sukseseditpaket.php' method='POST'>
		<div class="jumbotron bg-light">
			<div class="container">
				<?php
				echo "<div id='tampilkonfirmasipilihanpaket' class='text-center mb-4'>
						<h3>Pilih Paket Wisata Yang Ingin Diedit</h3>
						</div>";
				?>
					<div class="row">
						
					<?php
						$i=0;
						$result = mysqli_query($conn,"
								SELECT fasilitas.`id_fasilitas`, nama_fasilitas, fasilitas.`deskripsi`, 
								fasilitas.`harga`, fasilitas.`status`, fasilitas.`tuntunan`, fasilitas.`perpax`
								FROM fasilitas
								INNER JOIN nama_wisata ON fasilitas.id_nama_wisata=nama_wisata.id_nama_wisata
								WHERE id_travel=$idtravel AND fasilitas.id_nama_wisata=$idwisata
								ORDER BY fasilitas.id_nama_wisata;");
						if($result!=NULL){
						    while($row = mysqli_fetch_array($result)){
							echo 	"<div class='col-md-12 mb-2'>
										<div class='card mt-2 mb-2 p-3'>
											
											<label class='text-primary'><b>Nama Fasilitas</b></label>
											<input type='text' class='form-control' name='namafasil[]' value='".$row['nama_fasilitas']."'>
											<label><b>Deskripsi</b></label>
											<input type='text' class='form-control' name='deskripsi[]' value='".$row['deskripsi']."'>
											<label><b>Harga</b></label>
											<input type='text' class='form-control' name='harga[]' value='".$row['harga']."'>
											<input id='no".$row['id_fasilitas']."' type='hidden' class='form-control' name='nofasil[]' value='".$row['id_fasilitas']."'>
											<label><b>Status Fasilitas</b></label>
											<select name='status[".$i."]' class='form-control' id='editstatus'>";
												if($row['status']=='Standar'){
													echo "<option value='Standar' selected>Standar</option>";
													echo "<option value='Tambahan'>Tambahan</option>";
												}else{
													echo "<option value='Standar'>Standar</option>";
													echo "<option value='Tambahan' selected>Tambahan</option>";
												}
							echo 	"			
											</select>
											<label><b>Memerlukan Tourguide</b></label>
											<select name='tuntunan[".$i."]' class='form-control' id='edittuntunan'>";
												if($row['tuntunan']=='Tidak'){
													echo "<option value='Tidak' selected>Tidak</option>";
													echo "<option value='Perlu'>Perlu</option>";
												}else{
													echo "<option value='Tidak'>Tidak</option>";
													echo "<option value='Perlu' selected>Perlu</option>";
												}
							echo 	"			
											</select>
											<label><b>Tipe Paket Perorang/Kelompok</b></label>
											<select name='perpax[".$i."]' class='form-control' id='edittuntunan'>";
												if($row['perpax']=='Perorang'){
													echo "<option value='Perorang' selected>Perorang</option>";
													echo "<option value='Kelompok'>Kelompok</option>";
												}else{
													echo "<option value='Perorang'>Perorang</option>";
													echo "<option value='Kelompok' selected>Kelompok</option>";
												}
							echo 	"
											</select>
										<span>ID Fasilitas: <b>".$row['id_fasilitas']."</b></span>";
							echo    "
										<form id='deleteform".$row['id_fasilitas']."' action='hapus_fasilitas.php' method='POST'>
											<input type='hidden' class='form-control' name='nomor' value='".$row['id_fasilitas']."'>
											<input id='deletepkt".$row['id_fasilitas']."' type='submit' class='form-control bg-red delete' Value='Hapus Paket'>
										</form>";
							echo    "
										<script>
										$(document).ready(function() {	
											$('#deletepkt".$row['id_fasilitas']."').click(function(e){
											    $('#editpkt').attr('action', 'hapus_fasilitas.php');
												$('#editpkt').submit();
											});
										});
										</script
										</div>
									</div>
								</div>";
							$i=$i+1;
					    	}
						}
					?>
					
						<div class='col-md-12'>
								<input type='submit' id='editpakettombol' class='form-control' value='Simpan Perubahan'>
						</div>
						
					</div>
				</div>
			</div>
		</form>
		</div>

		<footer class="bg-primary">
			<div class="fix-bottom text-white text-center pt-3 pb-3">
				<span><b>Copyright @2020 - WisataSyS | Project RPL</b></span>
			</div>
		</footer>
	</body>
</html>