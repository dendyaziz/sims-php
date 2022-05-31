<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){	

	$id=$_POST["id"];
	$branch=$_POST["branch"];
	$location=$_POST["location"];
	$username=$_POST["username"];
	$date=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from BRANCH Where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
	    while($row = mysqli_fetch_assoc($result))
		{
	        $eks_branch=$row["branch"];
		}
		
	    if($eks_branch==$branch){
	        
	    }else{
	        $result = $con->query("Select * from BRANCH Where branch='$branch' and id != '$id'");
        	$count = mysqli_num_rows($result);
        	if($count>0){
        	    $_SESSION["iss21"]["info"]="Gagal, nama cabang $branch sudah terdaftar.";
        	}else{
        	    $result1 = $con1->query("Update BRANCH set branch='$branch', location='$location', lastuser='$username', lastdate='$date' where id='$id'");	
                $result1 = $con1->query("Update PO set branch='$branch' where branch='$eks_branch'");
                $result1 = $con1->query("Update TMPOUT set branch='$branch' where branch='$eks_branch'");
                $result1 = $con1->query("Update PEMBELIAN set branch='$branch' where branch='$eks_branch'");
                $result1 = $con1->query("Update OUTGOING set branch='$branch' where branch='$eks_branch'");
                $result1 = $con1->query("Update RETUR set branch='$branch' where branch='$eks_branch'");
                $result1 = $con1->query("Update PEMUSNAHAN set branch='$branch' where branch='$eks_branch'");
                $result1 = $con1->query("Update OPNAME set branch='$branch' where branch='$eks_branch'");
                $result1 = $con1->query("Update STOK set branch='$branch' where branch='$eks_branch'");
                $result1 = $con1->query("Update HISTORY set branch='$branch' where branch='$eks_branch'");
        	}
	    }
		
		header("location: ../branch.php");	
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../branch.php");	
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../branch.php");	
}
?>