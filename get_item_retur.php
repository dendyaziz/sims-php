<?php
session_start();
include("fc/fc_config.php");

$Qbranch=$_SESSION["iss21"]["branch"];
$data=$_POST['data'];
$data=str_replace("'","''",$data);
$result = $con->query("Select a.jenis,a.barang,a.satuan,a.kode,ifnull(sum(a.qty),0)-ifnull(sum(b.qty),0)  as saldo
	from OUTGOING a left join RETUR b on a.branch=b.branch and a.kode_customer=b.kode_customer and a.kode=b.kode and a.jenis=b.jenis and a.barang=b.barang and a.satuan=b.satuan
	where a.branch='$Qbranch' and concat(a.kode_customer, a.kode,' | ',a.jenis,' | ',a.barang)='$data'
	group by a.jenis,a.barang,a.satuan,a.kode
	");
$count = mysqli_num_rows($result);
if($count>0){
	while($row = mysqli_fetch_assoc($result))
	{				
		$jenis=$row["jenis"];
		$barang=$row["barang"];
		$satuan=$row["satuan"];
		$kode=$row["kode"];
		$stok=$row["saldo"];
		if(empty($stok)){$stok=0;}
		echo json_encode(array('barang'=>$barang,'jenis'=>$jenis,'satuan'=>$satuan,'kode'=>$kode,'stok'=>$stok));
	}
}
?>
