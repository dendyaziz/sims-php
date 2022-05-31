<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){	
    
	$id=$_POST["id"];
	$jenis=$_POST["jenis"];	
	$result = $con->query("Select * from JENIS Where jenis='$jenis' and id !='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$xjenis=$row["jenis"];
			$_SESSION["iss21"]["info"]="Gagal, Group barang $jenis sudah terdaftar.";
			header("location: ../category.php");
		}
	}else{
		
		$jenis_old="";
		$result = $con->query("Select * from JENIS Where id='$id'");
		$count = mysqli_num_rows($result);
		if($count>0){
			while($row = mysqli_fetch_assoc($result))
			{
				$jenis_old=$row["jenis"];
			}
		}
		$result1 = $con1->query("Update JENIS set jenis='$jenis'    where branch='$branch' and id='$id'");
		$result1 = $con1->query("Update BARANG set jenis='$jenis'   where branch='$branch' and jenis='$jenis_old'");
		$result1 = $con1->query("Update PO set jenis='$jenis'       where branch='$branch' and jenis='$jenis_old'");
		$result1 = $con1->query("Update TMPOUT set jenis='$jenis'       where branch='$branch' and jenis='$jenis_old'");
		$result1 = $con1->query("Update PEMBELIAN set jenis='$jenis' where branch='$branch' and jenis='$jenis_old'");
		$result1 = $con1->query("Update OUTGOING set jenis='$jenis' where branch='$branch' and jenis='$jenis_old'");
		$result1 = $con1->query("Update RETUR set jenis='$jenis'     where branch='$branch' and jenis='$jenis_old'");
		$result1 = $con1->query("Update PEMUSNAHAN set jenis='$jenis'   where branch='$branch' and jenis='$jenis_old'");
		$result1 = $con1->query("Update OPNAME set jenis='$jenis'    where branch='$branch' and jenis='$jenis_old'");
		$result1 = $con1->query("Update STOK set jenis='$jenis'     where branch='$branch' and jenis='$jenis_old'");
		$result1 = $con1->query("Update HISTORY set jenis='$jenis'  where branch='$branch' and jenis='$jenis_old'");
		header("location: ../category.php");
		
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../category.php");
}
?>