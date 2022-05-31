<?php
ob_start();session_start();
include("fc_config.php");
if(!empty($_GET["id"])){	

	$id=$_GET["id"];
	$po=$_GET["po"];
	$tanggal=$_GET["tanggal"];
	$kode_supplier=$_GET["kode_supplier"];	
	$result = $con->query("Delete From PO where id='$id'");
	header("location: ../add-po.php?tanggal=$tanggal&po=$po&kode_supplier=$kode_supplier");
		
}else{
	$po=$_GET["po"];
	$tanggal=$_GET["tanggal"];
	$kode_supplier=$_GET["kode_supplier"];
	header("location: ../add-po.php?tanggal=$tanggal&po=$po&kode_supplier=$kode_supplier");
}
?>