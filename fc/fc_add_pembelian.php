<?php
session_start();
include("fc_config.php");
if(!empty($_POST["tanggal"]) && !empty($_POST["supplier"]) && !empty($_POST["kode_supplier"]) && !empty($_POST["kode"]) && !empty($_POST["qty"])){	

	$branch=$_SESSION["iss21"]["branch"];	
	$tanggal=$_POST["tanggal"];	
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
	}	
	
	$supplier=$_POST["supplier"];
	$address=$_POST["address"];
	$phone=$_POST["phone"];
	$contact=$_POST["contact"];
	$kode_supplier=$_POST["kode_supplier"];
	
	$kode=$_POST["kode"];
	$jenis=$_POST["jenis"];
	$subgroup=$_POST["subgroup"];
	$merk=$_POST["merk"];
	$barang=$_POST["barang"];
	$barang=str_replace("'","",$barang);
	$satuan=$_POST["satuan"];	
	$qty=$_POST["qty"];
	$harga_beli=$_POST["harga_beli"];
	$descr=$_POST["descr"];
	
	$username=$_POST["username"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from PEMBELIAN Where branch='$branch' and tanggal='$tanggal' and faktur='$faktur' and  kode='$kode'");
	$count = mysqli_num_rows($result);
	if($count>0){	
		$result = $con->query("update PEMBELIAN set qty=qty+$qty, harga_beli=$harga_beli Where branch='$branch' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode'");
	}else{
		$result = $con->query("Insert Into PEMBELIAN (branch, tanggal, faktur, supplier, address, phone, contact, kode_supplier, kode, jenis, subgroup, merk, barang, satuan, qty, harga_beli, descr, username, entrydate) 
			values ('$branch','$tanggal','$faktur','$supplier', '$address', '$phone', '$contact', '$kode_supplier', '$kode', '$jenis', '$subgroup', '$merk', '$barang', '$satuan', '$qty', '$harga_beli', '$descr', '$username', '$entrydate')");
	}
	
	$result = $con->query("Select * from STOK Where branch='$branch' and kode='$kode'");
	$count = mysqli_num_rows($result);	
	$s_in=$qty;
	if($count>0){		
		$result1 = $con1->query("update STOK set s_in=s_in+$s_in, saldo=saldo+$s_in where branch='$branch' and kode='$kode'");		
	}else{		
		$result1 = $con1->query("Insert into STOK (branch, kode, jenis, subgroup, merk, barang, satuan, s_in, s_out, saldo, username, entrydate) 
			values ('$branch', '$kode', '$jenis', '$subgroup', '$merk', '$barang', '$satuan', '$s_in','0','$s_in','$username','$entrydate')");		
	}
	
	$result = $con->query("Select * from HISTORY Where branch='$branch' and transaksi='INCOMING' and faktur='$faktur' and tanggal='$tanggal' and  kode='$kode'");
	$count = mysqli_num_rows($result);
	if($count>0){
		$result = $con->query("update HISTORY set qty=qty+$qty Where branch='$branch' and transaksi='INCOMING' and faktur='$faktur' and tanggal='$tanggal' and  kode='$kode'");
	}else{
		$result2 = $con2->query("Insert into HISTORY (branch, tanggal, faktur, transaksi, kode_supplier, supplier, address, phone, contact, kode, jenis, subgroup, merk, barang, satuan, qty, harga_beli, descr, username, entrydate) 
		values ('$branch', '$tanggal', '$faktur', 'INCOMING', '$kode_supplier', '$supplier', '$address', '$phone', '$contact', '$kode', '$jenis', '$subgroup', '$merk', '$barang', '$satuan', '$qty','$harga_beli', '$descr', '$username', '$entrydate')");		
	}
	header("location: ../incoming.php?tanggal=$tanggal&faktur=$faktur&kode_supplier=$kode_supplier");	
	
}else{
    $tanggal=$_POST["tanggal"];	
	$faktur=$_POST["faktur"];
	$kode_supplier=$_POST["kode_supplier"];
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../incoming.php?tanggal=$tanggal&faktur=$faktur&kode_supplier=$kode_supplier");
}
?>