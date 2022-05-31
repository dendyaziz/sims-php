<?php
session_start();
include("fc/fc_config.php");

$Qbranch=$_SESSION["iss21"]["branch"];
$data=$_POST['data'];
$result = $con->query("Select harga from OUTGOING where concat(kode_customer,kode)='$data' order by id desc limit 1");
$count = mysqli_num_rows($result);
if($count>0){
	while($row = mysqli_fetch_assoc($result))
	{				
		$harga=$row["harga"];
		echo json_encode(array('harga'=>$harga));
	}
}
?>
