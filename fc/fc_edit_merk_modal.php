<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){	

	$id=$_POST["id"];
	$merk=$_POST["merk"];	
	$result = $con->query("Select merk from MERK Where merk='$merk' and id !='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$xmerk=$row["merk"];
			$_SESSION["iss21"]["info"]="Gagal, merk barang $merk sudah terdaftar.";
			header("location: ../merk.php");
		}
	}else{
		
		$old_merk="";
		$result = $con->query("Select merk from MERK Where id='$id'");
		$count = mysqli_num_rows($result);
		if($count>0){
			while($row = mysqli_fetch_assoc($result))
			{
				$old_merk=$row["merk"];
			}
		}
		$result1 = $con1->query("Update MERK set merk='$merk' where id='$id'");
		$result1 = $con1->query("Update BARANG set merk='$merk' where merk='$old_merk'");
		$result1 = $con1->query("Update PO set merk='$merk' where merk='$old_merk'");
		$result1 = $con1->query("Update TMPOUT set merk='$merk' where merk='$old_merk'");
		$result1 = $con1->query("Update PEMBELIAN set merk='$merk' where merk='$old_merk'");
		$result1 = $con1->query("Update OUTGOING set merk='$merk' where merk='$old_merk'");
		$result1 = $con1->query("Update RETUR set merk='$merk' where merk='$old_merk'");
		$result1 = $con1->query("Update PEMUSNAHAN set merk='$merk' where merk='$old_merk'");
		$result1 = $con1->query("Update OPNAME set merk='$merk' where merk='$old_merk'");
		$result1 = $con1->query("Update STOK set merk='$merk' where merk='$old_merk'");
		$result1 = $con1->query("Update HISTORY set merk='$merk' where merk='$old_merk'");
		header("location: ../merk.php");
		
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../merk.php");
}
?>