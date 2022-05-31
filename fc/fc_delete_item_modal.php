<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){

	$id=$_POST["id"];
	$kode=$_POST["kode"];
	$jenis=$_POST["jenis"];
	$subgroup=$_POST["subgroup"];
	$merk=$_POST["merk"];
	$barang=$_POST["barang"];
	$barang=str_replace("'","''",$barang);
	$satuan=$_POST["satuan"];
	$harga_beli=$_POST["harga_beli"];
	$harga_jual=$_POST["harga_jual"];
	$username=$_POST["username"];
	$date=date("Y-m-d")." ".date("H:i:s");	
	
	$result = $con->query("Select * from BARANG Where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){		
		$result1 = $con1->query("Delete From BARANG where id='$id'");		
		header("location: ../item.php");
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../item.php");
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../item.php");
}
?>