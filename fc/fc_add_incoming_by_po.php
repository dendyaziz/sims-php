<?php
ob_start();session_start();
include("fc_config.php");
if(!empty($_POST["tanggal"]) && !empty($_POST["do"]) && !empty($_POST["po"]) && !empty($_POST["kode_supplier"]) && !empty($_POST["kode"]) && !empty($_POST["qty"]) ){	
	
	$branch=$_SESSION["iss21"]["branch"];
	$tanggal=$_POST["tanggal"];	
	$do=$_POST["do"];
	$po=$_POST["po"];
	$tanggal_po=$_POST["tanggal_po"];	
	$kode_supplier=$_POST["kode_supplier"];	
	$supplier=$_POST["supplier"];	
	$address=$_POST["address"];	
	$phone=$_POST["phone"];	
	$contact=$_POST["contact"];	
	
	$kode=$_POST["kode"];
	$barang=$_POST["barang"];
	$jenis=$_POST["jenis"];	
	$satuan=$_POST["satuan"];
	$qty=$_POST["qty"];
	
	$faktur=$_POST["faktur"];
	if(empty($faktur)){
		$transNo="I".right(date('Ym'),4);
		$result = $con->query("Select faktur from PEMBELIAN where left(faktur,5)='$transNo' order by faktur desc limit 1");
		$count = mysqli_num_rows($result);
		if($count>0){
			while($row = mysqli_fetch_assoc($result))
			{
				$transno=right($row["faktur"],9)+1;
				$faktur="I".$transno;
			}
		}else{
			$faktur="I".right(date('Ym'),4)."00001";
		}
		
		$result = $con->query("update PO set qty3=qty2-qty  Where branch='$branch' and po='$po' and kode_supplier='$kode_supplier' and kode='$kode'");
	}	
	
	$username=$_POST["username"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from TMPOUT Where branch='$branch' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode'");
	$count = mysqli_num_rows($result);
	if($count>0){	
		$result = $con->query("update TMPOUT set qty=qty+$qty Where branch='$branch' and tanggal='$tanggal' and faktur='$faktur' and  kode='$kode'");
	}else{
		$result = $con->query("Insert Into TMPOUT (branch, tanggal, faktur, do, po, tanggal_po, kode_supplier, supplier, address, phone, contact, kode, barang, jenis, satuan, qty, username, entrydate) 
			values ('$branch', '$tanggal','$faktur', '$do', '$po', '$tanggal_po', '$kode_supplier', '$supplier', '$address', '$phone', '$contact', '$kode', '$barang', '$jenis', '$satuan', '$qty', '$username', '$entrydate')");
	}
	
	$result = $con->query("update PO set qty3=qty3+$qty Where branch='$branch' and po='$po' and kode='$kode'");
	header("location: ../incoming_by_po.php?tanggal=$tanggal&faktur=$faktur&po=$po&kode_supplier=$kode_supplier&do=$do");
	
}else{
	$tanggal=$_POST["tanggal"];	
	$do=$_POST["do"];
	$po=$_POST["po"];
	$faktur=$_POST["faktur"];
	$kode_supplier=$_POST["kode_supplier"];	
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../incoming_by_po.php?tanggal=$tanggal&faktur=$faktur&po=$po&kode_supplier=$kode_supplier&do=$do");
}
?>