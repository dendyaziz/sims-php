<?php
session_start();
include("fc_config.php");
if(!empty($_POST["merk"])){
	$merk=$_POST["merk"];	
	$result = $con->query("Select * from MERK Where merk='$merk'");
	$count = mysqli_num_rows($result);
	if($count>0){
		$_SESSION["iss21"]["info"]="Gagal, Merk barang $merk sudah terdaftar.";
		header("location: ../merk.php");
	}else{
		$result = $con->query("Insert Into MERK (merk) values ('$merk')");
		header("location: ../merk.php");
	}		
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../merk.php");
}
?>