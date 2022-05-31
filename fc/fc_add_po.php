<?php
ob_start();session_start();
include("fc_config.php");
if(!empty($_POST["branch"]) && !empty($_POST["tanggal"]) && !empty($_POST["kode_supplier"]) && !empty($_POST["kode"]) && !empty($_POST["qty"]) ){	
	
	$branch=$_POST["branch"];
	$tanggal=$_POST["tanggal"];
	$kode_supplier=$_POST["kode_supplier"];
	$supplier=$_POST["supplier"];
	$address=$_POST["address"];
	$contact=$_POST["contact"];
	$phone=$_POST["phone"];
	
	$po=$_POST["po"];
	if(empty($po)){
		
		$transNo="PO-".$kode_supplier."-".right(date("Ym"),4);
		$result = $con->query("Select po from PO where left(po,14)='$transNo' order by po desc limit 1");
		$count = mysqli_num_rows($result);
		if($count>0){
			while($row = mysqli_fetch_assoc($result))
			{
				$transno=right($row["po"],9)+1;
				$po="PO-".$kode_supplier."-".$transno;
			}
		}else{
			$po="PO-".$kode_supplier."-".right(date("Ym"),4)."00001";
		}
	}
	
	$kode=$_POST["kode"];
	$jenis=$_POST["jenis"];
	$tipe=$_POST["tipe"];
	$merk=$_POST["merk"];
	$barang=$_POST["barang"];
	$barang=str_replace("'","",$barang);
	$satuan=$_POST["satuan"];	
	$qty=$_POST["qty"];
	$harga_beli=$_POST["harga_beli"];
	
	$descr=$_POST["descr"];
	$status="OPEN";	
		
	$username=$_POST["username"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from PO Where branch='$branch' and tanggal='$tanggal' and po='$po' and kode_supplier='$kode_supplier' and kode='$kode'");
	$count = mysqli_num_rows($result);
	if($count>0){	
		$result = $con->query("update PO set qty=qty+$qty, qty2=qty+$qty, descr='$descr' Where branch='$branch' and tanggal='$tanggal' and po='$po' and kode_supplier='$kode_supplier' and kode='$kode'");
	}else{
		$result = $con->query("Insert Into PO (branch, tanggal, po, kode_supplier, supplier, address, phone, contact, kode, jenis, tipe, merk, barang, satuan, qty, qty2, harga_beli, descr, status, username, entrydate) 
			values ('$branch', '$tanggal','$po', '$kode_supplier', '$supplier', '$address','$phone', '$contact', '$kode', '$jenis', '$tipe', '$merk', '$barang', '$satuan', '$qty', '$qty', '$harga_beli', '$descr', '$status', '$username', '$entrydate')");
	}
	header("location: ../add-po.php?tanggal=$tanggal&po=$po&kode_supplier=$kode_supplier");
	
}else{
	$tanggal=$_POST["tanggal"];		
	$kode_supplier=$_POST["kode_supplier"];
	$po=$_POST["po"];	
	$_SESSION["iss9"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../add-po.php?tanggal=$tanggal&po=$po&kode_supplier=$kode_supplier");
}
?>