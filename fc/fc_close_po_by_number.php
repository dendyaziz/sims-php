<?php
ob_start();session_start();
include("fc_config.php");
if(!empty($_GET["po"])){

	$po=$_GET["po"];
	$result = $con->query("Update PO set status='CLOSE' where po='$po'");
	header("location: ../po.php");
		
}else{
	header("location: ../po.php");
}
?>