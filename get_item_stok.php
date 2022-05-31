<?php
session_start();
include("fc/fc_config.php");

$Qbranch=$_SESSION["iss21"]["branch"];
$data=$_POST['data'];
$result = $con->query("Select a.*, b.harga_beli, b.harga_jual from STOK a inner join BARANG b on a.kode=b.kode 
	where a.branch='$Qbranch' and concat(a.kode,' | ',a.jenis,' | ',a.barang)='$data'");
$count = mysqli_num_rows($result);
if($count>0){
	while($row = mysqli_fetch_assoc($result))
	{		
		$kode=$row["kode"];
		$barang=$row["barang"];
		$jenis=$row["jenis"];		
		$satuan=$row["satuan"];	
		$harga_beli=$row["harga_beli"];
		$harga_jual=$row["harga_jual"];
		$stok=$row["saldo"];		
		echo json_encode(array('kode'=>$kode,'barang'=>$barang,'jenis'=>$jenis,'satuan'=>$satuan,'harga_beli'=>$harga_beli,'harga_jual'=>$harga_jual,'stok'=>$stok));
	}
}
?>
