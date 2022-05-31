<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){	

	$id=$_POST["id"];
	$subgroup=$_POST["subgroup"];	
	$result = $con->query("Select subgroup from SUBGROUP Where subgroup='$subgroup' and id !='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$xsubgroup=$row["subgroup"];
			$_SESSION["iss21"]["info"]="Gagal, sub group barang $subgroup sudah terdaftar.";
			header("location: ../subgroup.php");
		}
	}else{
		
		$subgroup_old="";
		$result = $con->query("Select subgroup from SUBGROUP Where id='$id'");
		$count = mysqli_num_rows($result);
		if($count>0){
			while($row = mysqli_fetch_assoc($result))
			{
				$subgroup_old=$row["subgroup"];
			}
		}
		$result1 = $con1->query("Update SUBGROUP set subgroup='$subgroup' where id='$id'");
		$result1 = $con1->query("Update BARANG set subgroup='$subgroup' where subgroup='$subgroup_old'");
		$result1 = $con1->query("Update PO set subgroup='$subgroup' where subgroup='$subgroup_old'");
		$result1 = $con1->query("Update PEMBELIAN set subgroup='$subgroup' where subgroup='$subgroup_old'");
		$result1 = $con1->query("Update OUTGOING set subgroup='$subgroup' where subgroup='$subgroup_old'");
		$result1 = $con1->query("Update STOK set subgroup='$subgroup' where subgroup='$subgroup_old'");
		$result1 = $con1->query("Update HISTORY set subgroup='$subgroup' where subgroup='$subgroup_old'");
		$result1 = $con1->query("Update OPNAME set subgroup='$subgroup' where subgroup='$subgroup_old'");
		$result1 = $con1->query("Update PEMUSNAHAN set subgroup='$subgroup' where subgroup='$subgroup_old'");
		$result1 = $con1->query("Update RETUR set subgroup='$subgroup' where subgroup='$subgroup_old'");
		$result1 = $con1->query("Update TMPOUT set subgroup='$subgroup' where subgroup='$subgroup_old'");
		$result1 = $con1->query("Update PO set subgroup='$subgroup' where subgroup='$subgroup_old'");
		header("location: ../category.php");
		
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../subgroup.php");
}
?>