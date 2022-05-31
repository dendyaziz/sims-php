<?php
session_start();
include("fc/fc_config.php");

$data=$_POST['data'];
$Qbranch=$_SESSION["iss21"]["branch"];
$result = $con->query("Select * from STOK where branch='$Qbranch' and barang='$data'");
$count = mysqli_num_rows($result);
if($count>0){
	while($row = mysqli_fetch_assoc($result))
	{				
		$saldo=$row["saldo"];
		if(empty($saldo)){$saldo=0;}
		echo json_encode(array('saldo'=>$saldo));
	}
}
?>
