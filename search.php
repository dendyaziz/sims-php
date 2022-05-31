<?php
session_start();
include("fc/fc_config.php");

$keyword = strval($_POST['query']);
$search_param = "%{$keyword}%";

$result = $con->query("Select * from BARANG where barang like '$search_param'");
$count = mysqli_num_rows($result);
if($count>0){
	while($row = mysqli_fetch_assoc($result))
	{				
		$barang=$row["barang"];
	}
	if(empty($barang)){$barang="";}
	echo json_encode($barang);
}
?>
