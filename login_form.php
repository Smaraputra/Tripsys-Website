<?php
	session_start();
	require "koneksi.php";
	unset($_SESSION["ssnama"]);
	unset($_SESSION["ssjabatan"]);
	unset($_SESSION["ssid"]);
	unset($_SESSION["ssstatus"]);
	$email				= $_POST['inemail'];
	$password 			= $_POST['inpass'];
	$tipeakun 			= $_POST['intipeakun'];
	$log				= "CALL login($tipeakun, '$email', '$password');";
	
	if($result=mysqli_query($conn, $log)){
		while($row=mysqli_fetch_assoc($result)){
			$inid			= $row["id"];
			$innama			= $row["nama"];
			$injabatan		= $row["jabatan"];
			$instatus_login	= $row["status_login"];
		}
	}
	$_SESSION["ssid"]		= $inid;
	$_SESSION["ssnama"]		= $innama;
	$_SESSION["ssjabatan"]	= $injabatan;
	$_SESSION["ssstatus"]	= $instatus_login;
	
	if($_SESSION["ssstatus"]>0) {
		header("Location:index.php");
		$_SESSION["showgagallogin"]	= 0;
	}else{
		header("Location: login.php");
		$_SESSION["showgagallogin"]	= 1;
	}
?>