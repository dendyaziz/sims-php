<?php
/*
session_start();
include("fc/fc_config.php");
*/
if(isset($_GET['id'])) 
{
	
	$sql="select * from BARANG where id='".$_GET['id']."'";
	$result = $con->query($sql);
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$gambarV=$row["gambar"];
			$tipeV=$row["tipe_gambar"];				
			header("Content-type: " .$tipeV);
			echo $gambarV;
		}			
	}
}
?>