<?php
session_start();
include("fc_config.php");
if(!empty($_POST["subgroup"])){
	$subgroup=$_POST["subgroup"];	
	$result = $con->query("Select * from SUBGROUP Where subgroup='$subgroup'");
	$count = mysqli_num_rows($result);
	if($count>0){
		$_SESSION["iss21"]["info"]="Gagal, Sub Group barang $subgroup sudah terdaftar.";
		header("location: ../subgroup.php");
	}else{
		$result = $con->query("Insert Into SUBGROUP (subgroup) values ('$subgroup')");
		header("location: ../subgroup.php");
	}		
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../subgroup.php");
}
?>