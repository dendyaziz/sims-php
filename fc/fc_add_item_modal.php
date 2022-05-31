<?php
session_start();
include("fc_config.php");
if( !empty($_POST["jenis"]) && !empty($_POST["barang"]) &&  !empty($_POST["satuan"]) ){	
	
	/*
	$result = $con->query("Select kode from BARANG order by kode desc limit 1");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$kode_barang=$row["kode"];
			$kode=number_format(right($kode_barang,5))+1;	
			$kode="B".right("00000".$kode,5);
		}		
	}else{
		$kode="B00001";
	}
	*/
	
	$kode=$_POST["kode"];
	$jenis=$_POST["jenis"];
	$subgroup=$_POST["subgroup"];
	$merk=$_POST["merk"];
	$barang=$_POST["barang"];
	$satuan=$_POST["satuan"];
	$harga_beli=$_POST["harga_beli"];
	$harga_jual=$_POST["harga_jual"];
	$username=$_POST["username"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");	
	
	$result = $con->query("Select * from BARANG Where kode='$kode'");
	$count = mysqli_num_rows($result);
	if($count>0){
	    while($row = mysqli_fetch_assoc($result))
		{				
			$Xbarang=$row["barang"];
		}
		$_SESSION["iss21"]["info"]="Gagal, Kode barang $kode sudah terdaftar dengan nama barang $Xbarang.";
	}else{
		$result = $con->query("Insert Into BARANG (kode, jenis, subgroup, merk, barang, satuan, harga_beli, harga_jual, username, entrydate) 
			values ('$kode', '$jenis', '$subgroup', '$merk', '$barang', '$satuan', '$harga_beli', '$harga_jual', '$username', '$entrydate')");
	}
    header("location: ../item.php");
		
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../item.php");
}
?>