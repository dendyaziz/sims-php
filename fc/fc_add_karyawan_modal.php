<?php
session_start();
include("fc_config.php");
if( !empty($_POST["dept"]) && !empty($_POST["nik"]) && !empty($_POST["fullname"]) ){	

	$dept=$_POST["dept"];
	$nik=$_POST["nik"];
	$fullname=$_POST["fullname"];
	$position=$_POST["position"];
	$address=$_POST["address"];
	$phone=$_POST["phone"];
	
	$username=$_POST["username"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");	
	
	$result = $con->query("Select * from KARYAWAN Where nik='$nik'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$xfullname=$row["fullname"];
		}
		$_SESSION["iss21"]["info"]="Gagal, NIK Karyawan $nik sudah terdaftar atas nama $xfullname.";
		header("location: ../karyawan.php");
	}else{
		$result = $con->query("Insert Into KARYAWAN (dept, nik, fullname, position, address, phone, username, entrydate) 
			values ('$dept', '$nik', '$fullname', '$position', '$address', '$phone', '$username', '$entrydate')");
		header("location: ../karyawan.php");
	}		
		
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../karyawan.php");
}
?>