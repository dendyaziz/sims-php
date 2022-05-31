<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){	

	$id=$_POST["id"];
	$kode=$_POST["kode"];
	$subgroup=$_POST["subgroup"];
	$merk=$_POST["merk"];
	$jenis=$_POST["jenis"];
	$barang=$_POST["barang"];
	$barang=str_replace("'","''",$barang);
	$satuan=$_POST["satuan"];
	$harga_beli=$_POST["harga_beli"];
	$harga_jual=$_POST["harga_jual"];
	$username=$_POST["username"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from BARANG Where kode='$kode' and id !='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$xbarang=$row["barang"];
			$_SESSION["iss21"]["info"]="Gagal, kode barang $kode sudah terdaftar dengan nama barang $xbarang.";
			header("location: ../item.php");
		}
	}else{
	    $result1 = $con1->query("Update BARANG set jenis='$jenis', subgroup='$subgroup', merk='$merk', barang='$barang', satuan='$satuan', harga_beli='$harga_beli', harga_jual='$harga_jual', lastname='$username', lastdate='$entrydate' where id='$id'");			
	    $result1 = $con1->query("Update PO set jenis='$jenis', subgroup='$subgroup', merk='$merk', barang='$barang', satuan='$satuan' where kode='$kode'");	
	    $result1 = $con1->query("Update TMPOUT set jenis='$jenis', subgroup='$subgroup', merk='$merk', barang='$barang', satuan='$satuan' where kode='$kode'");	
	    $result1 = $con1->query("Update PEMBELIAN set jenis='$jenis', subgroup='$subgroup', merk='$merk', barang='$barang', satuan='$satuan' where kode='$kode'");	
	    $result1 = $con1->query("Update OUTGOING set jenis='$jenis', subgroup='$subgroup', merk='$merk', barang='$barang', satuan='$satuan' where kode='$kode'");	
	    $result1 = $con1->query("Update RETUR set jenis='$jenis', subgroup='$subgroup', merk='$merk', barang='$barang', satuan='$satuan' where kode='$kode'");	
	    $result1 = $con1->query("Update PEMUSNAHAN set jenis='$jenis', subgroup='$subgroup', merk='$merk', barang='$barang', satuan='$satuan' where kode='$kode'");	
	    $result1 = $con1->query("Update OPNAME set jenis='$jenis', subgroup='$subgroup', merk='$merk', barang='$barang', satuan='$satuan' where kode='$kode'");	
	    $result1 = $con1->query("Update STOK set jenis='$jenis', subgroup='$subgroup', merk='$merk', barang='$barang', satuan='$satuan' where kode='$kode'");	
	    $result1 = $con1->query("Update HISTORY set jenis='$jenis', subgroup='$subgroup', merk='$merk', barang='$barang', satuan='$satuan' where kode='$kode'");	
		header("location: ../item.php");
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../item.php");
}
?>