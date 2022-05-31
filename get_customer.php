<?php
session_start();
include("fc/fc_config.php");

$data=$_POST['data'];
$result = $con->query("Select * from CUSTOMER where concat(customer,' | ',address,' | ',phone,' | ',contact)='$data'");
$count = mysqli_num_rows($result);
if($count>0){
	while($row = mysqli_fetch_assoc($result))
	{		
		$kode=$row["kode"];
		$customer=$row["customer"];
		$address=$row["address"];
		$phone=$row["phone"];
		$contact=$row["contact"];		
		echo json_encode(array('kode'=>$kode,'customer'=>$customer,'address'=>$address,'phone'=>$phone,'contact'=>$contact));
	}
}
?>
