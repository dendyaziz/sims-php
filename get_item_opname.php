<?php
session_start();
include("fc/fc_config.php");

$Qbranch=$_SESSION["iss21"]["branch"];
$data=$_POST['data'];
$data=str_replace("'","''",$data);
$result = $con->query("Select a.*,b.harga_beli from STOK a inner join BARANG b on a.kode=b.kode and a.jenis=b.jenis and a.barang=b.barang and a.satuan=b.satuan 
	where a.branch='$Qbranch' and concat(a.kode,' | ',a.jenis,' | ',a.barang)='$data'");
$count = mysqli_num_rows($result);
if($count>0){
	while($row = mysqli_fetch_assoc($result))
	{				
		$jenis=$row["jenis"];
		$barang=$row["barang"];
		$satuan=$row["satuan"];
		$kode=$row["kode"];
		$harga=$row["harga_beli"];
		$stok=$row["saldo"];
		if(empty($stok)){$stok=0;}
		echo json_encode(array('barang'=>$barang,'jenis'=>$jenis,'satuan'=>$satuan,'kode'=>$kode,'harga'=>$harga,'stok'=>$stok));
	}
}
?>
