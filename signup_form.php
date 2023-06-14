<?php
	session_start();
	require "koneksi.php";

	$nama				= $_POST['innama'];
	$alamat 			= $_POST['inalamat'];
	$telp 				= $_POST['intelp'];
	$email				= $_POST['inemail'];
	$password			= $_POST['inpass'];
	$tipeakun			= $_POST['intipeakunbaru'];
	@$travel			= @$_POST['intravelbaru'];

    if($tipeakun==1){
        $signup="CALL signup('$nama', '$alamat', '$telp', NULL, '$email', '$password', '$tipeakun');";
    }else{
        $signup="CALL signup('$nama', '$alamat', '$telp', $travel, '$email', '$password', '$tipeakun');";
    }
	if($result=mysqli_query($conn, $signup)){
		while($row=mysqli_fetch_assoc($result)){
			$statussignup			= $row["status_signup"];
		}
	}

	if(isset($statussignup)) {
		header("Location: login.php");
		$_SESSION["showsignup"]	= 1;
	}else{
		header("Location: signup.php");
		$_SESSION["showsignup"]	= 0;
	}
?>