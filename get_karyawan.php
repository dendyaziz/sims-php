<?php
session_start();
include("fc/fc_config.php");

$data=$_POST['data'];
$result = $con->query("Select * from KARYAWAN where concat(nik,' | ',fullname,' | ',dept,' | ',address)='$data'");
$count = mysqli_num_rows($result);
if($count>0){
	while($row = mysqli_fetch_assoc($result))
	{		
		$nik=$row["nik"];
		$fullname=$row["fullname"];
		$address=$row["address"];
		$phone=$row["phone"];
		$position=$row["position"];		
		$dept=$row["dept"];		
		echo json_encode(array('nik'=>$nik,'fullname'=>$fullname,'address'=>$address,'phone'=>$phone,'position'=>$position,'dept'=>$dept));
	}
}
?>
