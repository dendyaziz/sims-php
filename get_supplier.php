<?php
session_start();
include("fc/fc_config.php");

$data=$_POST['data'];
$result = $con->query("Select * from SUPPLIER where concat(supplier,' | ',address,' | ',phone, ' | ',contact)='$data'");
$count = mysqli_num_rows($result);
if($count>0){
	while($row = mysqli_fetch_assoc($result))
	{		
		$kode=$row["kode"];
		$supplier=$row["supplier"];
		$address=$row["address"];
		$phone=$row["phone"];
		$contact=$row["contact"];
		echo json_encode(array('kode'=>$kode,'supplier'=>$supplier,'address'=>$address,'phone'=>$phone,'contact'=>$contact));
	}
}
?>
