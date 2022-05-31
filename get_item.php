<?php
session_start();
include("fc/fc_config.php");

$data=str_replace("'","",$_POST['data']);
$result = $con->query("Select * from BARANG where concat(kode,' | ',jenis,' | ',subgroup,' | ',merk,' | ',barang)='$data'");
$count = mysqli_num_rows($result);
if($count>0){
	while($row = mysqli_fetch_assoc($result))
	{				
		$kode=$row["kode"];
		$jenis=$row["jenis"];
		$subgroup=$row["subgroup"];
		$merk=$row["merk"];
		$barang=$row["barang"];
		$satuan=$row["satuan"];
		$harga_beli=$row["harga_beli"];
		$harga_jual=$row["harga_jual"];
		
		$stok=0;
		$result1 = $con1->query("Select saldo from STOK where kode='$kode'");
        $count1 = mysqli_num_rows($result1);
        if($count1>0){
        	while($row1 = mysqli_fetch_assoc($result1))
        	{				
        		$stok=$row1["saldo"];
        	}
        }
		echo json_encode(array('kode'=>$kode,'jenis'=>$jenis,'subgroup'=>$subgroup,'merk'=>$merk,'barang'=>$barang,'satuan'=>$satuan,'harga_beli'=>$harga_beli,'harga_jual'=>$harga_jual, 'stok'=>$stok, ));
	}
}
?>
