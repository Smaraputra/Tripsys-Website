<?php
	session_start();
	require "koneksi.php";
	if((@$_SESSION["ssstatus"])<1){
		$_SESSION["ssnama"]="Anda Belum Login";
		$_SESSION["ssjabatan"]="!";
	}
	$tipeakun	= $_POST['tipeakun'];
	$idin		= $_POST['idin'];
	$nama		= $_POST['nama'];
	
	if(isset($_POST['alamat'])){
		$alamat	= $_POST['alamat'];
	}
	if(isset($_POST['telpon'])){
		$no_telp= $_POST['telpon'];
	}
	if(isset($_POST['inpass'])){
		$pass= $_POST['inpass'];
	}
	if(isset($_POST['statusganti'])){
		$statusganti= $_POST['statusganti'];
	}

	if($tipeakun=='Pengguna'){
		if($statusganti==1){
			$gantipropil="UPDATE pelanggan SET nama='$nama', alamat='$alamat', telpon='$no_telp', password='$pass' WHERE id_pelanggan=$idin;";
		}else{
			$gantipropil="UPDATE pelanggan SET nama='$nama', alamat='$alamat', telpon=$no_telp WHERE id_pelanggan=$idin;";
		}
		$result=mysqli_query($conn, $gantipropil);
	}elseif($tipeakun=='Admin'){
		if($statusganti==1){
			$gantipropil="UPDATE admin SET nama='$nama', password='$pass' WHERE id_admin=$idin;";
		}else{
			$gantipropil="UPDATE admin SET nama='$nama' WHERE id_admin=$idin;";
		}
		$result=mysqli_query($conn, $gantipropil);
	}elseif($tipeakun=='Tour Guide'){
		if($statusganti==1){
			$gantipropil="UPDATE tourguide SET nama='$nama', alamat='$alamat', password='$pass' WHERE id_tourguide=$idin;";
		}else{
			$gantipropil="UPDATE tourguide SET nama='$nama', alamat='$alamat' WHERE id_tourguide=$idin;";
		}
		$result=mysqli_query($conn, $gantipropil);
	}
	$_SESSION['ssedit']=1;
	header("Location: profil.php");
	
?>