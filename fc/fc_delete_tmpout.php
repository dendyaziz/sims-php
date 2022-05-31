<?php
ob_start();session_start();
include("fc_config.php");
if(!empty($_GET["id"])){	

	$id=$_GET["id"];
	$username=$_SESSION["iss21"]["fullname"];
	$tanggal=$_GET["tanggal"];
	$po=$_GET["po"];
	$faktur=$_GET["faktur"];
	
	$result = $con->query("Select * from TMPOUT where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$tanggal=$row["tanggal"];
			$kode_supplier=$row["kode_supplier"];	
			$faktur=$row["faktur"];
			
			$kode=($row["kode"]);
			$barang=$row["barang"];
			$jenis=$row["jenis"];
			$satuan=($row["satuan"]);			
			$qty=$row["qty"];	
			$incoming=$qty;
			
			$result = $con->query("Delete From TMPOUT where id='$id'");
			$result = $con->query("update PO set qty3=qty3-$qty Where po='$po' and kode='$kode'");
			
			header("location: ../incoming_by_po.php?tanggal=$tanggal&kode_supplier=$kode_supplier&po=$po&faktur=$faktur");
		}
	}else{
		$tanggal=$_GET["tanggal"];
		$po=$_GET["po"];
		$faktur=$_GET["faktur"];
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../incoming_by_po.php?tanggal=$tanggal&kode_supplier=$kode_supplier&po=$po&faktur=$faktur");
	}
}else{
	$tanggal=$_GET["tanggal"];
	$po=$_GET["po"];
	$faktur=$_GET["faktur"];
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../incoming_by_po.php?tanggal=$tanggal&kode_supplier=$kode_supplier&po=$po&faktur=$faktur");
}
?>