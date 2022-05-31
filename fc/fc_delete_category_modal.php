<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){

	$id=$_POST["id"];
	$jenis=$_POST["jenis"];	
	$result = $con->query("Select * from JENIS Where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){		
		$result1 = $con1->query("Delete From JENIS where id='$id'");		
		header("location: ../category.php");
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../category.php");
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../category.php");
}
?>