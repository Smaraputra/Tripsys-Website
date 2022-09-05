<?php
	session_start();
	require "koneksi.php";
	if((@$_SESSION["ssstatus"])<1){
		$_SESSION["ssnama"]="Anda Belum Login";
		$_SESSION["ssjabatan"]="!";
	}
	$idfasilitas=$_POST['nomor'];
	$result		= mysqli_query($conn,"DELETE FROM fasilitas WHERE id_fasilitas=$idfasilitas");
	header("Location: edit_paketdetail.php");
?>