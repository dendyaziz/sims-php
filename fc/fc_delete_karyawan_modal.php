<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){

	$id=$_POST["id"];
	$dept=$_POST["dept"];
	$nik=$_POST["nik"];
	$fullname=$_POST["fullname"];
	$position=$_POST["position"];
	$address=$_POST["address"];
	$phone=$_POST["phone"];
	
	$username=$_POST["username"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");	
	
	$result = $con->query("Select * from KARYAWAN Where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){		
		$result1 = $con1->query("Delete From KARYAWAN where id='$id'");		
		header("location: ../karyawan.php");
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../karyawan.php");
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../karyawan.php");
}
?>