<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){

	$id=$_POST["id"];
	$kode=$_POST["kode"];
	$customer=$_POST["customer"];
	$address=$_POST["address"];
	$phone=$_POST["phone"];
	$contact=$_POST["contact"];
	$tipe=$_POST["tipe"];
	$note=$_POST["note"];
	$username=$_POST["username"];
	$date=date("Y-m-d")." ".date("H:i:s");	
	
	$result = $con->query("Select * from CUSTOMER Where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){		
		$result1 = $con1->query("Delete From CUSTOMER where id='$id'");		
		header("location: ../customer.php");
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../customer.php");
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../customer.php");
}
?>