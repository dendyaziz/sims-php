<?php
session_start();
include("fc_config.php");
if(!empty($_POST["jenis"])){
	$jenis=$_POST["jenis"];	
	$result = $con->query("Select * from JENIS Where jenis='$jenis'");
	$count = mysqli_num_rows($result);
	if($count>0){
		$_SESSION["iss21"]["info"]="Gagal, Category barang $jenis sudah terdaftar.";
		header("location: ../category.php");
	}else{
		$result = $con->query("Insert Into JENIS (jenis) values ('$jenis')");
		header("location: ../category.php");
	}		
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../category.php");
}
?>