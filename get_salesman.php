<?php
session_start();
include("fc/fc_config.php");

$data=$_POST['data'];
$result = $con->query("Select * from TBLLOGIN where concat(fullname,' | ',address,' | ',phone)='$data'");
$count = mysqli_num_rows($result);
if($count>0){
	while($row = mysqli_fetch_assoc($result))
	{		
		$userid=$row["userid"];
		$fullname=$row["fullname"];
		$address=$row["address"];
		$phone=$row["phone"];
		echo json_encode(array('userid'=>$userid,'fullname'=>$fullname,'address'=>$address,'phone'=>$phone));
	}
}
?>
